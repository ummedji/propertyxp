<?php

namespace Hydra\Widgets;
/**
 * Class TextWidget
 * @package Hydra\Widgets
 */
class NumberWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'number';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();

        $settings = $this->getWidgetSettings();
        $value = $itemSet->addField('text', array('value', $this->fieldRecord->getLabel()))
            ->addValidator('numeric');

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $value->addValidator('required');
        }

        $attrGenerator->process($value, $this->getWidgetSettings());
    }

    public function allowedConditions() {
        return array(
            'value' => array(
                'equals' => __('Equals', 'hydraforms'),
                'greater' => __('Greater', 'hydraforms'),
                'greater-equals' => __('Greater or Equals', 'hydraforms'),
                'lower' => __('Lower', 'hydraforms'),
                'lower-equals' => __('Lower or Equals', 'hydraforms'),
            ),
        );
    }

    // no settings
    // no default values
}

