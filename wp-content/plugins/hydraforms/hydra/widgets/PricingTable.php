<?php

namespace Hydra\Widgets;
/**
 * Class PricingTextWidget
 * @package Hydra\Widgets
 */
class PricingTableWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'pricing_text';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $widgetValues = $this->getWidgetSettings();

        $field = $itemSet->addField('text', array('value', $this->fieldRecord->getLabel()));
        $itemSet->addField('select', array('symbol', __('Use symbol instead', 'hydraforms')))
            ->setOptions(array(
                '0' => __('Dont Use'),
                'checked' => __('Yes', 'hydraforms'),
                'unchecked' => __('No', 'hydraforms'),
            ));

        // required validator for field
        if ($this->isRequired() && $index == 0) {
            $field->addValidator('required');
        }

        $attrGenerator->process($field, $this->getWidgetSettings());
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {

        if (!isset($items['items']) || !count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['value']) && empty($item['symbol'])) {
                unset($items['items'][$key]);
            }

            if (!empty($item['symbol'])) {
                $items['items'][$key]['value'] == $item['symbol'];
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        return $items;
    }
}
