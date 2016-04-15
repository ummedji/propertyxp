<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;


class OptionsDefinition extends FieldDefinition {

    public function __construct(Builder $builder = null, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'options';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->addField('textarea', array('options', __('List of options', 'hydra')));
    }

    public function getOptions($fieldRecord) {
        if (!isset($fieldRecord->attributes) || !isset($fieldRecord->attributes['options'])) {
            return FALSE;
        }
        $options = array();
        $output = $fieldRecord->attributes['options'];

        $options[0] = '----';
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            if (!empty($line)) {
                $value = $line;
                $key = $line;
                $options[$key] = $value;
            }
        }

        return $options;
    }

    // @todo
    public function getTokenDefinition() {

    }

    public function replaceToken($fieldRecord, $token_id, $column, $value, $text) {

    }
}
