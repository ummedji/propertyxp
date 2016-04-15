<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;
use Hydra\Widgets\DaterangeWidget;

class DatetimeDefinition extends FieldDefinition {

    public function __construct(Builder $builder = null, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'datetime';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->addField('datetime', array('min', __('Min. date range', 'hydraforms')));
        $fieldSet->addField('datetime', array('max', __('Max. date range', 'hydraforms')));
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