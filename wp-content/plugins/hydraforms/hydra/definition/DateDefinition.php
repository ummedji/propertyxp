<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class DateDefinition extends FieldDefinition {

    public function __construct(Builder $builder = null, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'date';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->addField('date', array('min', __('Min. date', 'hydraforms')));
        $fieldSet->addField('date', array('max', __('Max. date', 'hydraforms')));
    }

    public function getTokenDefinition() {
        return array(
            'date' => array(
                'title' => __('Raw', 'hydraforms'),
                'name' => 'date',
            ),
        );
    }
}
