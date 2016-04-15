<?php

namespace Hydra\Formatter;

class HTMLGroupFormatter extends GroupFormatter {

    public function __construct() {
        $this->name = 'html-group';
    }

    public function render($groupFieldView, $fields, $post) {
        $attributes = $this->printAttributes($groupFieldView);
        $id = str_replace('_', '-', $groupFieldView->field_name);
        $fields = $this->preRenderFields($fields, $post);

        if (!count($fields)) {
            return FALSE;
        }

        $settings = $groupFieldView->settings;
        if (!empty($settings['display_title'])) {
            $displayTitle = $settings['display_title'];
        } else {
            $displayTitle = null;
        }

        ob_start();
        include 'templates/html-group-formatter.tpl.php';
        return ob_get_clean();
    }


    public function getSettingsForm($parentForm) {
        $fields = array();
        parent::getSettingsForm($parentForm);
    }
}
