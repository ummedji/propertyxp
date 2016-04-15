<?php

namespace Hydra\Widgets;

/**
 * Class CheckboxesWidget
 * @package Hydra\Widgets
 */
class CheckboxesWidget extends Widget {

    public function isCardinalityAllowed() {
        return FALSE;
    }

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'checkboxes';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $widgetValues = $this->getWidgetValues();

        $fields = array();
        if ($this->fieldRecord) {
            $args = array('value', $this->fieldRecord->getLabel());
        }
        else {
            $args = array('value', __('Options', 'hydraforms'));
        }

        if ($this->fieldRecord->cardinality != 1) {
            $field = $itemSet->addField('checkboxes', $args);
        }
        else {
            $field = $itemSet->addField('radios', $args);
        }

        if ($options = $this->fieldDefinition->getOptions($this->fieldRecord)) {
            unset($options[0]);
            $field->setOptions($options);
        }
        else {
            $field->setDescription(__('No options available', 'hydraforms'));
        }

        if(isset($widgetValues['items'])) {
            $field->setValue($widgetValues['items'][0]['value']);
        }


        // required validator for field
        if($this->isRequired() && $index == 0) {
            $field->addValidator('required');
        }

        $attrGenerator->process($field, $this->getWidgetSettings());
    }

    /**
     * @param \HydraFieldRecord $fieldRecord
     * @param array $items
     * @param $post
     * @return array
     */
    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {
        if (!isset($items['items'])) {
            return array();
        }
        if (!count($items['items'])) {
            return array();
        }
        $original_values = $items;

        $item = reset($items['items']);
        $items = array();

        if ($fieldRecord->cardinality != 1) {
            foreach ($item['value'] as $index => $value) {
                $items['items'][$index]['value'] = $value;
            }
        }
        else {
            $items['items'][0]['value'] = $item['value'];
        }

        switch ($fieldRecord->field_type) {
            case 'taxonomy':
                $attributes = $fieldRecord->attributes;
                $vocabularyName = $attributes['taxonomy'];
                $terms = array();
                foreach ($items['items'] as $item) {
                    if (is_array($item['value'])) {
                        $terms = array_merge($item['value']);
                    }
                    else {
                        $terms[] = $item['value'];
                    }
                }

                wp_set_post_terms($post->ID, $terms, $vocabularyName);
                break;
        }

        return $original_values;
    }

}