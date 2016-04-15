<?php

namespace Hydra\Formatter;

class TableGroupFormatter extends GroupFormatter {

    public function __construct() {
        $this->name = 'table-group';
    }

    public function render($groupFieldView, $fields, $post) {
        $attributes = $this->printAttributes($groupFieldView);
        $id = str_replace('_', '-', $groupFieldView->field_name);
        $fields = $this->preRenderFields($fields, $post);

        $settings = $groupFieldView->settings;

        $displayTitle = isset($settings['display_title']) ? $settings['display_title'] : true;
        $field = $groupFieldView;

        if (!count($fields)) {
            return FALSE;
        }

        ob_start();
        include 'templates/table-group-formatter.tpl.php';
        return ob_get_clean();
    }
}