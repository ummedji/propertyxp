<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class TextareaDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'textarea';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->addField('text', array('rows', __('Rows', 'hydraforms')));
        $fieldSet->addField('text', array('cols', __('Cols', 'hydraforms')));
    }
}
