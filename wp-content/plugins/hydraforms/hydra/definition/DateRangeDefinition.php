<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class DateRangeDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'date_range';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->addField('date', array('min', __('Min. date', 'hydraforms')));
        $fieldSet->addField('date', array('max', __('Max. date', 'hydraforms')));
    }

    public function getTokenDefinition() {
        return array(
            'date_start' => array(
                'title' => __('Date Start', 'hydraforms'),
                'name' => 'date_start',
            ),
            'date_end' => array(
                'title' => __('Date End', 'hydraforms'),
                'name' => 'date_start',
            ),
        );
    }
}
