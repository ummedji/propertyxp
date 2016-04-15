<?php

namespace Hydra\Formatter;

class LinkFormatter extends Formatter {
    public function __construct() {
        $this->name = 'link';
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = "<div class=\"field-item field-item-$delta\">";
        if (isset($settings['prefix'])) {
            $output .= "<div class=\"field-prefix\" >" . $settings['prefix'] . "</div>";
        }

        $output .= "<div class=field-value><a href=" . $item['url'] . " class=\"btn\">" . $item['value'] . "</a></div>";
        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix']. "</div>";
        }
        $output .= '</div>';

        return $output;
    }

}