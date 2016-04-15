<?php

namespace Hydra\Formatter;

class PriceFormatter extends Formatter {

    public function __construct() {
        $this->name = 'number';
    }

    public function isEmpty($value) {
        if ($value == NULL || $value == FALSE) {
            return TRUE;
        }

        if (is_array($value)) {
            return TRUE;
        }

        return FALSE;
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = '';
        $output .= "<div class=\"field-item field-item-$delta\">";
        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-prefix\" >" . $settings['prefix'] . "</div>";
        }

        $parts = explode('.', $item['value']);
        $decimals = $parts[0];
        $float = isset($parts[1]) ? $parts[1] : '00';

        $output .= "<div class=field-value>" . $decimals . "<span>" . $float . "</span></div>";

        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix'] . "</div>";
        }
        $output .= '</div>';

        return $output;
    }
}