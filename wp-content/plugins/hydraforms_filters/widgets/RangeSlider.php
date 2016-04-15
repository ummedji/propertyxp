<?php

namespace Hydra\Widgets;



/**
 * Class RangeSliderWidget
 */
class RangeSliderWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'range_slider';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $widgetSettings = $this->getWidgetSettings();
        $widgetDefaults = $this->getWidgetValues();

        if(isset($_GET[$this->fieldRecord->field_name])) {
            $widgetDefaults = $_GET[$this->fieldRecord->field_name];
        }

        // we want just one value
        $widgetDefaults = $widgetDefaults['items'][$index];

        $range = $itemSet->addField('text', array('range', $this->fieldRecord->getLabel()))
            ->setDefaultValue($widgetDefaults['range'])
            ->addAttribute('class', 'hidden')
            ->addAttribute('class', 'ion-range-slider')
            ->setAttribute('data-min', $widgetSettings['min_value'])
            ->setAttribute('data-max', $widgetSettings['max_value']);
        $attr = $widgetSettings;
        unset($attr['prefix']);
        $attrGenerator->process($range, $attr);

        // admin
        if(count($parts = explode(';', $widgetDefaults['range'])) == 2) {
            $range->setAttribute('data-from', $parts[0]);
            $range->setAttribute('data-to', $parts[1]);
        }

        if(isset($widgetSettings['prefix'])) {
            $range->setAttribute('data-prefix', $widgetSettings['prefix']);
        }

        if(isset($widgetSettings['step'])) {
            $range->setAttribute('data-step', $widgetSettings['step']);
        }

        if(isset($widgetSettings['postfix'])) {
            $range->setAttribute('data-postfix', $widgetSettings['postfix']);
        }

        if(isset($widgetSettings['has_grid'])) {
            if($widgetSettings['has_grid']) {
                $range->setAttribute('data-hasGrid', 'true');
            } else {
                $range->setAttribute('data-hasGrid', 'false');
            }
        }
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if(empty($item['range'])) {
                unset($items[$key]);
                continue;
            }
        }

        return $items;
    }

    public function allowedConditions() {
        // range slider support only in between condition - obviously
        return array(
            'value' => array(
                'in_between' => __('In Between', 'hydraforms'),
            ),
        );
    }

    public function composeCondition($filterField, $conditionField, $condition, $value) {
        $metaArgs = array();

        if(isset($value['range'])) {
            $parts = explode(';', $value['range']);
            $metaArgs = array(
                'key' => $filterField->field_name . '_%_' . $condition->col,
                'compare' => 'BETWEEN',
                'value' => array($parts[0], $parts[1]),
                'type' => 'numeric',
            );
        }

        return $metaArgs;
    }

    public function getSettingsForm($parentForm, \HydraFieldRecord $field) {

        $parentForm->addField('text', array('min_value', __('Min. Value', 'hydraforms')))
            ->addValidator('numeric')
            ->addValidator('required');

        $parentForm->addField('text', array('max_value', __('Max. Value', 'hydraforms')))
            ->addValidator('numeric')
            ->addValidator('required');

        $parentForm->addField('text', array('step', __('Step', 'hydraforms')))
            ->addValidator('numeric')
            ->addValidator('required')
            ->setValue(1);

        $parentForm->addField('text', array('prefix', __('Prefix', 'hydraforms')));
        $parentForm->addField('text', array('postfix', __('Postfix', 'hydraforms')));

        $parentForm->addField('checkbox', array('has_grid', __('Has Grid', 'hydraforms')));
        $parentForm->addField('checkbox', array('hide_label', __('Hide label', 'hydraforms')))
            ->setDescription(__('Do <b>not</b> display label for this element', 'hydraforms'));

        $settingsValues = $this->getWidgetSettings();
        $parentForm->setValue($settingsValues);
    }

    public function getDefaultSettings() {
        $defaultSettings['min_value'] = 1;
        $defaultSettings['max_value'] = 10;
        $defaultSettings['step'] = 1;
        $defaultSettings['prefix'] = '';
        $defaultSettings['postfix'] = '';
        return $defaultSettings;
    }

    public function getDefaultValues() {
        return array(
            'items' => array(
                0 => array(
                    'range' => '1;10'
                )
            )
        );
    }
}
