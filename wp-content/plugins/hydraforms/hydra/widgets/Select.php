<?php

namespace Hydra\Widgets;
/**
 * Class SelectWidget
 * @package Hydra\Widgets
 */
class SelectWidget extends Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'select';
    }

    public function isCardinalityAllowed() {
        return FALSE;
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();

        if ($this->fieldRecord) {
            $args = array('value', $this->fieldRecord->getLabel());
        }
        else {
            $args = array('select', __('Options', 'hydra'));
        }

        $field = $itemSet->addField('select', $args);

        if ($this->fieldRecord) {
            $options = $this->fieldDefinition->getOptions($this->fieldRecord);
            asort($options);
            $field->setOptions($options);
        }
        else {
            $field->setDescription(
                __('Default options will be available when taxonomy vocabulary is chosen and saved', 'hydra')
            );
        }

        if ($this->fieldRecord->cardinality != 1) {
            $field->setAttribute('multiple', 'multiple');
            if (!isset($options)) {
                $options = array();
            }

            if (count($options) > 5) {
                $field->addAttribute('size', 5);
            }
            else {
                $field->addAttribute('size', count($options));
            }
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
        if (!count($items['items'])) {
            return;
        }

        if ($fieldRecord->cardinality != 1) {
            $item = reset($items['items']);
            $items = array();

            foreach ($item['value'] as $index => $value) {
                $items['items'][$index]['value'] = $value;
            }
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['value'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        if (!$post) {
            return $items;
        }

        switch ($fieldRecord->field_type) {
            case 'taxonomy':
                $attributes = $fieldRecord->attributes;
                $vocabularyName = $attributes['taxonomy'];

                if (count($items)) {
                    foreach ($items['items'] as $item) {
                        wp_set_post_terms($post->ID, $item['value'], $vocabularyName);
                    }
                }
                break;
        }

        return $items;
    }

    public function allowedConditions() {
        return array(
            'value' => array(
                'equals' => __('Equals', 'hydraforms'),
            )
        );
    }

    public function composeCondition($filterField, $conditionField, $condition, $value) {
        // if value is empty, ignore condition
        if(isset($value[$condition->col]) && !empty($value[$condition->col])) {
            if($compare = $this->getConditionMapping($condition->condition))
                $metaArgs = array(
                    'key' => $filterField->field_name . '_%_' . $condition->col,
                    'compare' => $compare,
                    'value' => $value[$condition->col],
                );
        }

        return $metaArgs;
    }
}
