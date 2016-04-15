<?php
/**
 * @file
 */

require_once 'hydra/formatter/Formatter.php';

function hydra_get_options_for_field($name, $post_type) {
    $prefix = 'hf_' . $post_type . '_';

    if (!strstr($name, $prefix)) {
        $name = 'hf_' . $post_type . '_' . $name;
    }

    $dbModel = new HydraFieldModel();
    $field = $dbModel->loadByName($name);
    if ($field) {
        $defManager = new \Hydra\Definitions\DefinitionManager();
        $definition = $defManager->createDefinition($field->field_type);
        return $definition->getOptions($field);
    }

    return array();
}

/**
 * Will render whole post
 * @var $post_id - identifier of wordpress post
 * @var $view - identifier of display, if none provided, default display will be used
 */
function hydra_render_post($post_id, $view = "default") {
    $handle = new HydraRenderer($post_id, $view);
    return $handle->renderPost();
}

/**
 * Will render particular group
 * @var $post_id - identifier of wordpress post
 * @var $group_name - identifier of group of fields
 * @var $view - identifier of display, if none provided, default display will be used
 */
function hydra_render_group($post_id, $group_name, $view = "default") {
    $handle = new HydraRenderer($post_id, $view);
    return $handle->renderGroup($group_name);
}


/**
 * Render single field
 * @var $post_id - identifier of wordpress post
 * @var $field_name - identifier of field name
 * @var $view - identifier of display, if none provided, default display will be used
 */
function hydra_render_field($post_id, $field_name, $view = "default") {
    $handle = new HydraRenderer($post_id, $view);
    return $handle->renderField($field_name);
}

/**
 * Class SuperformsRender
 *
 * Provides callback for rendering of output in various levels of granularity
 *  - Post
 *  - Group
 *  - Field
 *
 * Should not contain any logical functionality
 * Filters out hidden groups and fields, formatter renders everything that comes in, so resolving "hidden"
 * fields is responsibility of Renderer.
 */
class HydraRenderer {

    private $postId;
    private $view;
    private $post;

    private function createMachineName($name) {
        $prefix = 'hf_' . $this->post->post_type . '_';

        if (!strstr($name, $prefix)) {
            return 'hf_' . $this->post->post_type . '_' . $name;
        }
        return $name;
    }

    public function __construct($postId, $view = 'default') {
        $this->postId = $postId;
        $this->view = $view;
        $this->post = get_post($postId);
    }

    /**
     * Render whole post
     */
    public function renderPost() {
        $type = get_post_type($this->postId);

        // there is no such post
        if (!$type) {
            return;
        }

        $db = new HydraFieldViewModel();
        $container = $db->loadByViewNamePostType($type, $this->view);
        $viewFields = $container->getHierarchy();


        $output = '';
        // Hiding is done on lower levels - Fields should take care themself
        if (count($viewFields)) {
            foreach ($viewFields as $viewField) {
                $viewField->loadField();
                if ($viewField->isWrapper() && $viewField->hasChildren()) {
                    $output .= $this->renderGroup($viewField->field->field_name);
                }
                else {
                    $output .= $this->renderField($viewField->field->field_name);
                }
            }
        }

        return $output;
    }

    /**
     * Render fieldset
     * @param $groupName
     */
    public function renderGroup($groupName) {
        // make sure field name is formatter properly
        $groupName = $this->createMachineName($groupName);
        $manager = new HydraFieldViewModel();

        // group
        $groupViewRecord = $manager->loadByFieldName($groupName, $this->view);


        // faulty record provided - Alarm alarm!
        if (!$groupViewRecord) {
            return;
        }

        $groupViewRecord->loadField();
        $groupViewRecord->field;

        // don't render hidden
        if ($groupViewRecord->hidden) {
            return;
        }

        // load group fields
        $container = $manager->loadGroupRecords($groupViewRecord->id);
        $fieldViews = $container->getRecords();

        // not render if not fields
        if (!count($fieldViews)) {
            return;
        }

        // only non hidden fields should be processed
        $renderableFields = array();
        foreach ($fieldViews as $fieldView) {
            $fieldView->loadField();

            if (!$fieldView->hidden) {
                $fieldView->field->loadMeta($this->postId);
                $renderableFields[] = $fieldView;
            }
        }


        $formatter = \Hydra\Formatter\Formatter::getFormatter($groupViewRecord->formatter, TRUE);
        return $formatter->render($groupViewRecord, $renderableFields, $this->post);
    }

    /**
     * Render one field
     * @param $fieldName
     */
    public function renderField($fieldName) {
        // make sure field name is formatter properly
        $fieldName = $this->createMachineName($fieldName);

        $manager = new HydraFieldViewModel();
        $fieldView = $manager->loadByFieldName($fieldName, $this->view);

        // faulty record provided - Alarm alarm!
        if (!$fieldView) {
            return;
        }

        $fieldView->loadField();

        // don't render hidden
        if ($fieldView->hidden) {
            return;
        }

        if ( ! empty( $fieldView->field ) && is_object( $fieldView->field ) ) {
            $fieldView->field->loadMeta($this->postId);
            $formatter = Hydra\Formatter\Formatter::getFormatter($fieldView->formatter, FALSE);

            if (!empty($formatter)) {
                return $formatter->render($fieldView, $this->post);
            }
        }

        return null;
    }
}
