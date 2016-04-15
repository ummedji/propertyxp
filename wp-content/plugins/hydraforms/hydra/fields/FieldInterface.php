<?php

namespace Hydra\Fields;

interface FieldInterface {
    public function addValidator($type, $message, $options = array());
    public function render();
}