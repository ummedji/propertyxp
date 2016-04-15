<?php

namespace Hydra\Formatter;

class ImageFormatter extends Formatter {

    public function __construct() {
        $this->name = 'image';
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        $items = $this->getValues($view);

        if (!$items) {
            return FALSE;
        }

        // TODO: $items should be empty ? - i dont remember what this was about
        if (empty($items[0]['url'])) {
            return FALSE;
        }

        $meta = $view->field->meta;
        $output = '';
        $output .= '<div ' . $this->printAttributes($view) . '>';
        $output .= '<div class="gallery">';
        $output .= '<div class="preview">';
        $output .= '<img src="' . $items[0]['url'] . '" alt="">';
        $output .= '</div>';

        $output .= '<div class="thumbnails"><ul>';
        foreach ($items as $key => $item) {
            $class = '';

            if ($key == 0) {
                $class = 'active';
            }

            $output .= '<li class="' . $class . '">';
            $output .= '<div class="thumb">';
            $output .= "<div class=\"field-value\"><a href=\"" . $item['url'] . "\"><img src=" . $item['url'] . " alt=\"\"></a></div>";
            $output .= '</div>';
            $output .= '</li>';
        }
        $output .= '</ul></div>';

        $output .= '</div>';
        $output .= "</div>";


        return $output;
    }

    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);

        $parentForm->removeField('suffix');
        $parentForm->removeField('prefix');
    }
}