<?php
new PackagesMetabox();

/**
 * Class PackagesMetabox
 */
class PackagesMetabox {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'addMetabox'));
        add_action('save_post', array($this, 'saveMeta'));
    }

    public function addMetabox() {
        add_meta_box(
            'aviators_packages_metabox', // $id
            'Packages data', // $title
            array($this, 'renderForm'), // $callback
            'package', // $page
            'normal', // $context
            'high'
        );
    }

    public function renderForm() {
        $form = $this->getForm();
        print $form->render();
    }

    private function getData() {
        global $post;

        if (!$post) {
            $meta = array();
        }
        else {
            $meta = get_post_meta($post->ID);
        }

        $values = array();
        foreach ($meta as $index => $meta) {
            $values[$index] = reset($meta);
        }

        return $values;
    }

    private function getForm() {
        $values = $this->getData();

        $form = new \Hydra\Builder('form-packages-meta', '', \Hydra\Builder::FORM_EXTENDER);

        $form->addDecorator('table');
        $form->addField('text', array('agency', __('Agencies', 'aviators')))
            ->setDefaultValue(10)
            ->addValidator('numeric');

        $form->addField('text', array('agent', __('Agents', 'aviators')))
            ->setDefaultValue(10)
            ->addValidator('numeric');

        $form->addField('text', array('property', __('Properties', 'aviators')))
            ->setDefaultValue(10)
            ->addValidator('numeric');


        $form->addField('text', array('price', __('Price', 'aviators')))
            ->addValidator('numeric')
            ->addValidator('required');

        $form->addField('text', array('tax', __('Tax', 'aviators')))
            ->addValidator('numeric');

        $form->addField('select', array('trial_period', __('Trial period', 'aviators')))
            ->setOptions(array(
                'none' => __('No Trail', 'aviators'),
                'Day' => __('Day', 'aviators'),
                'Week' => __('Week', 'aviators'),
                'Month' => __('Month', 'aviators'),
                'Year' => __('Year', 'aviators')
            ))
            ->setDescription(__('Starting period which will be for free', 'aviators'))
            ->setDefaultValue('Week');


        $form->addField('select', array('period', __('Subscription period', 'aviators')))
            ->setOptions(array(
                'Day' => __('Day', 'aviators'),
                'Week' => __('Week', 'aviators'),
                'Month' => __('Month', 'aviators'),
            ))
            ->setDescription(__('Period of one subscription, recurring payment will occur once in period', 'aviators'))
            ->setDefaultValue('Month');

        $form->addField('checkbox', array('featured', __('Is Featured', 'aviators')));

        $form->setValues($values);
        $form->build();

        return $form;
    }

    function saveMeta($post_id) {

        // we cant really validate as this interacts directly with hydra generated metabox :\
        if (isset($_POST['agent']) && isset($_POST['agency']) && isset($_POST['property'])) {
            update_post_meta($post_id, 'agent', $_POST['agent']);
            update_post_meta($post_id, 'agency', $_POST['agency']);
            update_post_meta($post_id, 'property', $_POST['property']);
            update_post_meta($post_id, 'price', $_POST['price']);
            update_post_meta($post_id, 'tax', $_POST['tax']);
            update_post_meta($post_id, 'days', $_POST['days']);
            update_post_meta($post_id, 'period', $_POST['period']);
            update_post_meta($post_id, 'trial_period', $_POST['trial_period']);
            update_post_meta($post_id, 'featured', $_POST['featured']);
        }

    }
}