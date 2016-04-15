<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class FieldsetDefinition extends FieldDefinition {

    public function __construct(Builder $builder = null, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'fieldset';
    }


    public function buildDefinition($fieldRecord = NULL) {
        $builder = $this->getBuilder();

        $fieldset = $builder->addField('fieldset', array('general', __('General information', 'hydra')))
            ->isTree()
            ->addDecorator('table');

        $fieldset->addField('text', array('field_name', __('Name', 'hydra')))
            ->addDecorator('suffix', array($fieldRecord->getCleanMachineName()))
            ->addValidator('required', 'Required')
            ->setDescription('Machine readable name')
            ->addAttribute('disabled', TRUE);

        $fieldset->addField('text', array('field_label', __('Label', 'hydra')))
            ->enableTranslatable()
            ->addValidator('required', 'Required')
            ->setDescription('Field label');

    }

    protected function definitionSpecificFields($fieldSet) {

    }

    protected function definitionWidget($fieldset, $name, $fieldRecord = NULL) {
        $widgetManager = new WidgetManager();
        $widgetManager->getWidgetForm($name, $this, $fieldRecord, $fieldset);
    }

    public function getTokenDefinition() {
        return array();
    }
}
