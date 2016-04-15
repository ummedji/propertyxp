<?php

namespace Hydra\Formatter;

class StarsFormatter extends Formatter {
    public function __construct() {
        $this->name = 'stars';
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = "<div class=\"field-item field-item-$delta\">";

        $output .= "bla bla bla" . $item['value'];

        return $output;
    }
}