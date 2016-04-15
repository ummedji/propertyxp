<?php

namespace Hydra\Widgets;
/**
 * Class TextWidget
 * @package Hydra\Widgets
 */
class MailWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'mail';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $widgetValues = $this->getWidgetSettings();

        $field = $itemSet->addField('text', array('value', $this->fieldRecord->getLabel()))
            ->addValidator('mail');
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
}