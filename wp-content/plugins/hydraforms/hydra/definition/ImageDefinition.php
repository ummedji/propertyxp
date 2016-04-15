<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class ImageDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL) {
        parent::__construct($builder);
        $this->type = 'image';
    }

    protected function definitionSpecificFields($fieldSet) {
    }

    public function getTokenDefinition() {
        // we do not want to define any tokens at this point for gallery views
        return array();
    }
}
