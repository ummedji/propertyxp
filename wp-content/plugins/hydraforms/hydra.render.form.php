<?php
/**
 * @file
 */


/**
 * Register
 */
spl_autoload_register(
    function ($class) {
        if (strstr($class, 'HydraFormWidget') && $class != 'HydraFormWidgetGeneric') {
            class_alias('HydraFormWidgetGeneric', $class);
        }
    }
);

/**
 * Initialize our widgets
 */
add_action(
    'widgets_init',
    function () {
        $dbModel = new HydraFormModel();
        $records = $dbModel->loadAll();
        if (!$records) {
            return;
        }
        foreach ($records as $record) {
            global $hydraFormRecord;
            $hydraFormRecord = $record;
            $settings = $hydraFormRecord->settings;

            if (isset($settings['enable_widget']) && $settings['enable_widget']) {
                register_widget('HydraFormWidget' . ucfirst($record->name));
            }
        }
    }
);

/**
 * @param $form_name
 * @param bool $custom
 * @param bool $post_ids
 * @return array|bool|string
 */
function hydra_render_form($form_name, $custom = FALSE, $post_ids = FALSE) {
    // well, provide at least some context
    if (!$post_ids) {
        $post_ids = array(get_the_ID());
    }

    try {
        $renderer = new HydraFormRenderer($form_name);
        if ($renderer) {
            return $renderer->render($custom, $post_ids);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function hydra_form_filter($form_name) {
    try {
        return new HydraFilterManager($form_name);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * Generic widget
 * Class HydraFormWidgetGeneric
 */
class HydraFormWidgetGeneric extends WP_Widget {
    public $hydraForm;

    public function __construct() {
        global $hydraFormRecord;

        $this->hydraForm = $hydraFormRecord;

        parent::__construct(
            $hydraFormRecord->name,
            __("HydraForm:" . $hydraFormRecord->label, 'hydra')
        );
    }

    public function widget($args, $instance) {
        print hydra_render_form($this->hydraForm->name);
    }

    public function form($instance) {
        // outputs the options form on admin
    }

    public function update($new_instance, $old_instance) {
        // processes widget options to be saved
    }
}


/**
 * Class HydraFormRenderer
 */
class HydraFormRenderer {
    protected $formName;

    public function __construct($formName) {
        $this->formName = $formName;
    }

    public function render($custom = FALSE, $postIds = FALSE) {
        $model = new HydraFormModel();
        $formObject = $model->loadByName($this->formName);

        if (!$formObject) {
            return FALSE;
        }

        if ($formObject->type == 'form') {
            $formManager = new HydraFormManager($this->formName, $postIds);
        }
        else {
            $formManager = new HydraFilterManager($this->formName);
        }

        $form = $formManager->buildForm();
        $formRecord = $formManager->getFormRecord();

        $settings = $formRecord->settings;
        $classes = array('hydra-form', 'hydra-frontend-form', 'hydra-frontend-' . $formRecord->name);
        if (isset($settings['class'])) {
            $classes[] = $settings['class'];
        }

        $id = 'hydraform-' . $formRecord->id;
        $classes = implode(' ', $classes);


        $title_enable = FALSE;
        $title = $formRecord->getLabel();
        if (isset($settings['enable_title']) && $settings['enable_title']) {
            $title_enable = TRUE;
        }
        else {
            $title = '';
        }

        if ($custom) {
            return array($form->customRender(), $title, $classes);
        }
        ob_start();
        include 'template/hydra.form.tpl.php';
        return ob_get_clean();
    }
}

/**
 * Class HydraFormManager
 * 1. Handles building the form
 * 2. Handles submitting the form and processing all the separate handlers
 */
class HydraFormManager {
    private $dbModel;
    private $form;
    private $postIds;

    public function getFormRecord() {
        return $this->form;
    }

    public function __construct($formName, $postIds = FALSE) {
        $this->formName = $formName;
        $this->postIds = $postIds;
        $this->dbModel = new HydraFormModel();
        $this->form = $this->dbModel->loadByName($formName);
    }

    public function buildForm() {
        $settings = $this->form->settings;
        $dbModel = new HydraFieldModel();
        $fieldsContainer = $dbModel->loadByPostType($this->formName);
        $fieldMapper = new HydraDBMapper();

        // altered form name - to have a unique name ( more or less )
        $formName = 'hydraform-' . $this->formName;

        // form instance
        $form = new \Hydra\Builder($formName, '/submit/' . $formName);

        $form->addField('hidden', array('hydra_form_name', $this->formName))
            ->setAttribute('id', 'form-' . str_replace('_', '-', $this->formName));

        if ($this->postIds) {
            $form->addField('hidden', array('tokens', implode($this->postIds)));
        }

        foreach ($fieldsContainer->getHierarchy() as $item) {
            $fieldMapper->generateFromRecord($item, $form);
        }

        $form->addField('submit', array('submit', $this->form->getSettings('submit_text')))
            ->setAttribute('id', 'submit-' . str_replace('_', '-', $formName));

        $form->addOnValidation('validateForm', $this);
        $form->addOnSuccess('submitForm', $this);

        $form->build();

        return $form;
    }

    public function validateForm($form, $values) {
        // call custom defined submit function
    }

    public function submitForm($form, $values) {
        $handlers = $this->form->loadHandlers();
        $settings = $this->form->settings;

        // if there were some token values set, lets pull out our nodes
        $posts = array();
        if (isset($values['tokens'])) {
            $tokenIds = explode(',', $values['tokens']);
            foreach ($tokenIds as $tokenId) {
                $posts[] = get_post($tokenId);
            }
        }

        if (!count($handlers)) {
            return;
        }

        $formToken = new HydraFormToken($values['hydra_form_name'], $posts);
        $values['token_posts'] = $posts;
        foreach ($handlers as $handler) {
            // get handler instance
            $handlerInstance = \Hydra\Handlers\Handler::getHandler($handler->type);
            // process handler instance
            $settings = $handler->settings;

            // do token replacement
            foreach ($settings as $key => $setting) {
                if (is_string($setting)) {
                    $settings[$key] = $formToken->replaceTokens($setting, $values);
//                    $setting = $formToken->replaceFormTokens($setting, $values);
//                    $setting = $formToken->replacePostsTokens($setting, $posts);
                }
            }

            $handlerInstance->action($settings, $form, $values);
        }
    }
}

class HydraFilterManager {
    private $dbModel;
    private $form;

    public function getFormRecord() {
        return $this->form;
    }

    public function __construct($formName) {
        $this->formName = $formName;
        $this->dbModel = new HydraFormModel();
        $this->form = $this->dbModel->loadByName($formName);

        add_filter('posts_where', array($this, 'replacePattern'));
    }

    public function getQueryArray() {
        $values = $_GET;

        $dbModel = new HydraFieldModel();
        $fieldsContainer = $dbModel->loadByPostType($this->formName);
        $fields = $fieldsContainer->getRecords();

        $args = array(
            'post_type' => $this->form->settings['post_type'],
        );

        $metaArgs = array();
        foreach ($fields as $field) {

            if (isset($values[$field->field_name])) {
                $conditions = $field->loadConditions();
                if (!count($conditions)) {
                    continue;
                }

                foreach ($conditions as $condition) {
                    $referrerField = $condition->loadReferrer();
                    if(isset($values[$field->field_name]['items'])) {
                        $metaArg = $this->generateQueryForField($referrerField, $condition, $values[$field->field_name]['items']);
                        if (count($metaArg)) {
                            $metaArgs[] = $metaArg;
                        }
                    }
                }
            }
        }


        $args['meta_query'] = $metaArgs;

        return $args;
    }

    private function generateQueryForField($field, $condition, $values) {
        $metaArgs = array();

        foreach ($values as $itemValue) {
            $fieldModel = new HydraFieldModel();
            $conditionField = $fieldModel->load($condition->field_id);

            $widgetManager = new \Hydra\Widgets\WidgetManager();
            $widget = $widgetManager->getWidget($conditionField->widget, array());

            $metaArgs = $widget->composeCondition($field, $conditionField, $condition, $itemValue);
        }

        return $metaArgs;
    }


    function replacePattern($where) {
        $dbModel = new HydraFieldModel();

        $fieldsContainer = $dbModel->loadByPostType($this->formName);
        $fields = $fieldsContainer->getRecords();

        foreach ($fields as $field) {
            $conditions = $field->loadConditions();

            if (empty($conditions)) {
                continue;
            }
            foreach ($conditions as $condition) {
                $referrer = $condition->loadReferrer();
                $field_name = ! empty( $referrer->field_name ) ? $referrer->field_name : null;
                $condition_col = ! empty( $condition->col ) ? $condition->col : null;

                $name = $field_name . '_%_' . $condition_col;
                $where = str_replace("meta_key = '$name'", "meta_key LIKE '$name'", $where);
            }
        }


        return $where;
    }

    public function buildForm() {
        if (!$this->form) {
            return FALSE;
        }
        $settings = $this->form->settings;
        $dbModel = new HydraFieldModel();
        $fieldsContainer = $dbModel->loadByPostType($this->formName);
        $fieldMapper = new HydraDBMapper();

        // altered form name - to have a unique name ( more or less )
        $formName = 'hydraform-' . $this->formName;

        // form instance
        $form = new \Hydra\Builder($formName, '/submit/' . $formName);
        foreach ($fieldsContainer->getHierarchy() as $item) {
            $fieldMapper->generateFromRecord($item, $form);
        }

        $form->addField('submit', array('submit', $this->form->getSettings('submit_text')));

        $form->addOnSuccess('submitForm', $this);
        $form->setValues($_GET);

        $form->build();
        return $form;
    }

    public function submitForm($form, $values) {
        $dbModel = new HydraFormModel();
        $formRecord = $dbModel->loadByName(str_replace('hydraform-', '', $values['form_id']));

        $redirect = $formRecord->settings['redirect'];
        $values = $form->clearSubmitValues($values);

        $dbModel = new HydraFieldModel();
        $fieldsContainer = $dbModel->loadByPostType($this->formName);
        $widgetManager = new \Hydra\Widgets\WidgetManager();

        foreach ($fieldsContainer->getHierarchy() as $item) {
            $widget = $widgetManager->getWidget($item->widget, array());
            if(isset($values[$item->field_name])) {
                $value = $widget->processValuesBeforeSave($item, $values[$item->field_name]);
                if (is_array($value) && !empty($value)) {
                    $values[$item->field_name] = $value;
                }
                else {
                    unset($values[$item->field_name]);
                }
            }
        }

        $siteurl = get_option('siteurl');
        $query = http_build_query($values);
        $form->setRedirect($siteurl . '/' . $redirect . '?' . $query);
    }
}
