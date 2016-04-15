<?php

namespace Hydra\Decorators;

class FieldDecorator {

    const FIELD_DECORATOR_PREFIX = 'prefix';
    const FIELD_DECORATOR_SUFFIX = 'suffix';
    const FIELD_DECORATOR_WRAPPER = 'wrapper';


    public $type;
    private $value;

    public function __construct($type, $args) {
        $this->value = reset($args);
        $this->type = $type;
    }

    public function render() {
        switch ($this->type) {
            case FieldDecorator::FIELD_DECORATOR_PREFIX:
                return '<span class="input-group-addon ">' . $this->value . '</span>' . '!field';
                break;
            case FieldDecorator::FIELD_DECORATOR_SUFFIX:
                return '!field' . '<span class="input-group-addon">' . $this->value . "</span>";
                break;
        }
    }
}