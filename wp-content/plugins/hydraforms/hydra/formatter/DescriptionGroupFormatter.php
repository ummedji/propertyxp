<?php

namespace Hydra\Formatter;

class DescriptionGroupFormatter extends GroupFormatter {

    public function __construct() {
        $this->name = 'description-group';
    }

    public function render($groupFieldView, $fields, $post) {
        $attributes = $this->printAttributes($groupFieldView);
        $id = str_replace('_', '-', $groupFieldView->field->field_name);
        $fields = $this->preRenderFields($fields, $post);

        if (!count($fields)) {
            return FALSE;
        }
        $field = $groupFieldView;
        $settings = $groupFieldView->settings;
        $displayTitle = (bool) $settings['display_title'];

        ob_start();
        include 'templates/description-group-formatter.tpl.php';
        return ob_get_clean();
    }
}