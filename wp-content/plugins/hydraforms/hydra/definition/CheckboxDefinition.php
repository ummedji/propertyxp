<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class CheckboxDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'checkbox';
    }

    public function getTokenDefinition() {
        return array(
            'value' => array(
                'title' => __('Boolean', 'hydraforms'),
                'name' => 'value',
            ),
        );
    }
}
