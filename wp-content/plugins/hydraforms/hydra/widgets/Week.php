<?php

namespace Hydra\Widgets;
/**
 * Class TextWidget
 * @package Hydra\Widgets
 */
class WeekWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'week';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
//        $attrGenerator = FieldAttributesGenerator::getInstance();
        $itemSet->setLabel($this->fieldRecord->getLabel());
        $itemSet->isRenderable(true);
        $itemSet->addDecorator('table');
        $itemSet->addField('text', array('mon', __('Monday')));
        $itemSet->addField('text', array('tue', __('Tuesday')));
        $itemSet->addField('text', array('wed', __('Wednesday')));
        $itemSet->addField('text', array('thu', __('Thursday')));
        $itemSet->addField('text', array('fri', __('Friday')));
        $itemSet->addField('text', array('sat', __('Saturday')));
        $itemSet->addField('text', array('sun', __('Sunday')));
//        $attrGenerator->process($value, $this->getWidgetSettings());
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {
        if (!isset($items['items']) || !count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['mon'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        return $items;
    }
}

