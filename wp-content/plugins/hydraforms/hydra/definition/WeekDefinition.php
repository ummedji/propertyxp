<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class WeekDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'week';
    }

    protected function definitionSpecificFields($fieldSet) {

    }

    public function getTokenDefinition() {
        return array(
            'mon' => array(
                'title' => __('Monday', 'hydraforms'),
                'name' => 'mon',
            ),
            'tue' => array(
                'title' => __('Tuesday', 'hydraforms'),
                'name' => 'tue',
            ),
            'wed' => array(
                'title' => __('Wednesday', 'hydraforms'),
                'name' => 'wed',
            ),
            'thu' => array(
                'title' => __('Thursday', 'hydraforms'),
                'name' => 'thu',
            ),
            'fri' => array(
                'title' => __('Friday', 'hydraforms'),
                'name' => 'fri',
            ),
            'sat' => array(
                'title' => __('Saturday', 'hydraforms'),
                'name' => 'sat',
            ),
            'sun' => array(
                'title' => __('Sunday', 'hydraforms'),
                'name' => 'sun',
            ),
        );
    }
}
