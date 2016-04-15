<?php

namespace Hydra\Widgets;
/**
 * Class TextareaWidget
 * @package Hydra\Widgets
 */
class TextareaWidget extends Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'textarea';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $field = $itemSet->addField('textarea', array('value', $this->fieldRecord->getLabel()));

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $field->addValidator('required');
        }

        $attrGenerator->process($field, $this->getWidgetSettings());
    }
}