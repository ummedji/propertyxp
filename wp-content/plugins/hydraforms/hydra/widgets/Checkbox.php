<?php

namespace Hydra\Widgets;
/**
 * Class TextWidget
 * @package Hydra\Widgets
 */
class CheckboxWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'checkbox';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $field = $itemSet->addField('checkbox', array('value', $this->fieldRecord->getLabel()));

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $field->addValidator('required');
        }

        $attrGenerator->process($field, $this->getWidgetSettings());
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {
        if (!isset($items['items']) || !count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['value'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        return $items;
    }

    public function getSettingsForm($parentForm, \HydraFieldRecord $fieldRecord) {
        parent::getSettingsForm($parentForm, $fieldRecord);
        $parentForm->removeField('placeholder');
    }
}

