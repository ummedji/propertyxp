<?php

use Hydra\Decorators\FieldDecorator;

use Hydra\Builder as Builder;
use Hydra\Fields;
use Hydra\Definitions\FieldDefinition;
use Hydra\Definitions\ValidatorRequiredDefinition;
use Hydra\Fields\SubmitField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;
use Hydra\Fields\CheckboxField;
use Hydra\Fields\SelectField;
use Hydra\Fields\FileField;
use Hydra\Fields\TextareaField;
use Hydra\Decorators\TableDecorator;

new HydraMetabox();

/**
 * Class SuperformMetabox
 */
class  HydraMetabox {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'addMetabox'));
        add_action('save_post', array($this, 'saveMeta'));

        add_action('admin_init', array($this, 'registerAdminScript'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    public function processPost() {
    }

    public function addMetabox() {
        $manager = new HydraFieldModel();
        $postTypes = $manager->loadUsedPostTypes();

        foreach ($postTypes as $postType) {
            add_meta_box(
                'hydra_meta_box', // $id
                'HydraForms', // $title
                array($this, 'renderForm'), // $callback
                $postType->post_type, // $page
                'normal', // $context
                'high'
            );
        }
    }

    public function renderForm() {
        global $post;
        if(!$post) {
            return;
        }
        $postForm = $this->getForm();
        $postForm->build();
        $postForm->render();

    }

    public function getForm() {
        global $post;
        if(!$post) {
            return;
        }
        $postForm = new HydraPostForm($post);
        return $postForm->getForm();
    }


    function saveMeta($post_id) {
        global $post;
        if(!$post) {
            return;
        }
        $postForm = new HydraPostForm($post);

        $form = $this->getForm();
        if ($form->validate()) {
            $values = $form->getValues();
            $postForm->submitForm($values, $post);
        }
    }


    public function registerAdminScript() {
        /* Register our script. */
        wp_register_script('gmap', 'http://maps.googleapis.com/maps/api/js?v=3&sensor=true&ver=3.7.1&libraries=places');
        wp_register_script('chained', HYDRA_URL . '/assets/jquery.chained.min.js', array('jquery'), TRUE);
        wp_register_script('geolocation', HYDRA_URL . '/assets/geolocation.js', array('jquery'), TRUE);
        wp_register_script('fields', HYDRA_URL . '/assets/fields.js', array('jquery'), array(), TRUE);
        wp_register_script('messages', HYDRA_URL . '/assets/messages.js', array('jquery'), TRUE);
        $this->enqueueScripts();
    }

    public function enqueueScripts() {
        wp_enqueue_style('formstyle');
        wp_enqueue_script('chained');
        wp_enqueue_script('gmap');
        wp_enqueue_script('messages');
        wp_enqueue_script('fields');
        wp_enqueue_script('geolocation');
    }
}

/**
 * Frontend submission form
 * Class HydraPostForm
 */
class HydraPostForm {
    private $post;

    public function __construct($post) {
        $this->post = $post;
    }

    public function getForm($form = NULL) {
        $post = $this->post;

        if (!$form) {
            $form = new Builder('metabox-extend', '/submit/metabox-extend', Builder::FORM_EXTENDER);
        }

        $dbManager = new HydraFieldModel();
        $container = $dbManager->loadByPostType($post->post_type);

        $mapper = new HydraDBMapper();

        if (isset($post->post_type) && isset($post->ID)) {
            $meta = get_post_meta($post->ID);
        }

        foreach ($container->getHierarchy() as $item) {
            $mapper->generateFromRecord($item, $form, $post->ID);

        }

        if (isset($post->post_type) && isset($post->ID)) {
            $form->setValues($this->getDefaultValues($meta));
        }
        return $form;
    }


    public function getDefaultValues($postMeta) {
        $defaultValues = array();

        if (!$postMeta || !count($postMeta)) {
            return $defaultValues;
        }

        foreach ($postMeta as $key => $meta) {
            $item = reset($meta);
            if ($arrayValue = @unserialize($item)) {
                $defaultValues[$key] = $arrayValue;
            }
            else {
                $defaultValues[$key] = $item;
            }
        }

        return $defaultValues;
    }

    public function submitForm($values, $post) {
        global $wpdb;
        $dbManager = new HydraFieldModel();
        $container = $dbManager->loadByPostType($values['post_type']);
        $items = $container->getRecords();
        $widgetManager = new \Hydra\Widgets\WidgetManager();

        foreach ($items as $item) {
            /** @var $item HydraFieldRecord */
            if($item->field_type == 'fieldset') {
                continue;
            }

            $widgetInstance = $widgetManager->getWidget($item->widget, array());
            if(!$widgetInstance) {
                continue;
            }
            // no value for field - force false
            if (!isset($values[$item->field_name])) {
                $values[$item->field_name] = array();
            }

            // process the value and provide some space to do some special operations - like taxonomy synchronization, etc.
            if (isset($values[$item->field_name]['value'])) {
                $value['items'][0]['value'] = $values[$item->field_name]['value'];
            }
            else {
                $value = $values[$item->field_name];
            }
            $metaValue = $widgetInstance->processValuesBeforeSave($item, $value, $post);

            // we need to create appropriate fields
            if (!count($metaValue)) {
                delete_post_meta($post->ID, $item->field_name);
            }
            else {
                if (isset($values[$item->field_name]['value'])) {
                    update_post_meta($post->ID, $item->field_name, $metaValue);
                }
                else {
                    update_post_meta($post->ID, $item->field_name, $metaValue);
                }

                // delete old records
                $wpdb->query(
                    $wpdb->prepare(
                        "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE %s AND post_id = %d",
                        $item->field_name . '\_%\_%',
                        $post->ID
                    )
                );

                foreach ($metaValue['items'] as $structureIndex => $valueStructure) {
                    foreach ($valueStructure as $valueIndex => $valueItem) {
                        if(is_array($valueItem)) {
                            $counter = 0;
                            foreach($valueItem as $elementIndex => $element) {
                                $counter++;
                                $structuredName = $item->field_name . '_' . ($structureIndex + $counter) . '_' . $valueIndex;

                                // never compare previous value - what is this good for ?!
                                update_post_meta($post->ID, $structuredName, $element, TRUE);
                            }
                        } else {

                            $structuredName = $item->field_name . '_' . $structureIndex . '_' . $valueIndex;
                            // never compare previous value - what is this good for ?!
                            update_post_meta($post->ID, $structuredName, $valueItem, TRUE);
                        }
                    }
                }
            }
        }
    }
}