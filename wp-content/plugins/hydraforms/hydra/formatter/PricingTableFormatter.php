<?php

namespace Hydra\Formatter;

class PricingTableFormatter extends Formatter {
    public function __construct() {
        $this->name = 'pricing_table';
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = "<div class=\"field-item field-item-$delta\">";
        if (isset($settings['prefix'])) {
            $output .= "<div class=\"field-prefix\" >" . $settings['prefix'] . "</div>";
        }
        $class = '';
        if($item['symbol']) {
            switch($item['symbol']) {
                case 'checked':
                    $item['value'] = '<i class="fa fa-check"></i>';
                    break;
                case 'unchecked':
                    $item['value'] = '<i class="fa fa-times"></i>';
                    break;
            }

            $class = $item['symbol'];
        }

        $output .= "<div class=\"$class field-value\">" . $item['value'] . "</div>";
        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix']. "</div>";
        }
        $output .= '</div>';

        return $output;
    }

}