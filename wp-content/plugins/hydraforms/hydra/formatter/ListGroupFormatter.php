<?php

namespace Hydra\Formatter;

class ListGroupFormatter extends GroupFormatter {

    public function __construct() {
        $this->name = 'list-group';
    }

    public function render($groupFieldView, $fields, $post) {
        $attributes = $this->printAttributes($groupFieldView);
        $id = str_replace('_', '-', $groupFieldView->field_name);
        $fields = $this->preRenderFields($fields, $post);

        if (!count($fields)) {
            return FALSE;
        }
        ob_start();
        include 'templates/list-group-formatter.tpl.php';
        return ob_get_clean();
    }
}