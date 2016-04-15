<?php

namespace Hydra\Formatter;

class WeekFormatter extends Formatter {
    public function __construct() {
        $this->name = 'week';
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = "<div class=\"field-item field-item-$delta\">";

        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Monday', 'hydraforms') . '</span><span class="hours">' . $item['mon'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Tuesday', 'hydraforms') . '</span><span class="hours">' . $item['tue'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Wednesday', 'hydraforms') . '</span><span class="hours">' . $item['wed'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Thursday', 'hydraforms') . '</span><span class="hours">' . $item['thu'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Friday', 'hydraforms') . '</span><span class="hours">' . $item['fri'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Saturday', 'hydraforms') . '</span><span class="hours">' . $item['sat'] . '</span></div>';
        $output .= '<div class="field-mon day clearfix"><span class="name">' . __('Sunday', 'hydraforms') . '</span><span class="hours">' . $item['sun'] . '</span></div>';
        $output .= '</div>';

        return $output;
    }
}