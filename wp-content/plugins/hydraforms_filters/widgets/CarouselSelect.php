<?php

namespace Hydra\Widgets;

/**
 * Class CarouselSelectWidget
 */
class CarouselSelectWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'carousel_select';
    }

    public function isCardinalityAllowed() {
        return FALSE;
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();

        $widgetSettings = $this->getWidgetSettings();
        $widgetDefaults = $this->getWidgetValues();

        $fields = array();
        if ($this->fieldRecord) {
            $args = array('value', $this->fieldRecord->getLabel());
        }
        else {
            $args = array('value', __('Options', 'hydraforms'));
        }

        if ($this->fieldRecord->cardinality != 1) {
            $field = $itemSet->addField('checkboxes', $args);
            $attrGenerator->process($field, $this->getWidgetSettings());
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

        $field->setWrapperClass('carousel-select');

        $defaultSettings['infite_loop'] = FALSE;
        $defaultSettings['mode'] = 'horizontal';

        $field->addAttribute('data-min_slides', $widgetSettings['min_slides']);
        $field->addAttribute('data-max_slides', $widgetSettings['max_slides']);
        $field->addAttribute('data-mode', $widgetSettings['mode']);
        $field->addAttribute('data-move_slides', $widgetSettings['move_slides']);
        $field->addAttribute('data-pager', $widgetSettings['pager']);

        if($widgetSettings['mode'] == 'horizontal') {
            $field->addAttribute('data-slide_width', $widgetSettings['slide_width']);
        } else {
            $field->addAttribute('data-slide_width', 'auto');
        }
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        return $items;
    }

    public function allowedConditions() {
        // range slider support only in between condition - obviously
        return array(
            'value' => array(
                'in_array' => __('In Array', 'hydraforms'),
            ),
        );
    }

    public function composeCondition($filterField, $conditionField, $condition, $value) {
        $metaArgs = array();

        if(isset($value[$condition->col]) && !empty($value[$condition->col])) {
            $metaArgs = array(
                'key' => $filterField->field_name . '_%_' . $condition->col,
                'value' => $value[$condition->col],
            );
        }

        return $metaArgs;
    }

    public function getSettingsForm($parentForm, \HydraFieldRecord $field) {
        $defaultValues = $this->getDefaultSettings();

        $parentForm->addField('select', array('mode', __('Mode', 'hydraforms')))
            ->setOptions(array(
                'horizontal' => __('Horizontal', 'hydraforms'),
                'vertical' => __('Vertical', 'hydraforms'),
                'fade' => __('Fade', 'hydraforms'),
            ));

        $parentForm->addField('text', array('slide_width', __('Slide Width', 'hydraforms')))
            ->setDescription(__('Works only with horizontal mode! Otherwise ignored', 'hydraforms'));

        $parentForm->addField('select', array('min_slides', __('Min. Slides', 'hydraforms')))
            ->setOptions(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10));

        $parentForm->addField('select', array('max_slides', __('Max. Slides', 'hydraforms')))
            ->setOptions(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10));

        $parentForm->addField('select', array('move_slides', __('Move Slides', 'hydraforms')))
            ->setOptions(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10));

        $parentForm->addField('checkbox', array('pager', __('Enable Pager', 'hydraforms')));

        parent::getSettingsForm($parentForm, $field);

        $parentForm->setValue($defaultValues);
    }

    public function getDefaultSettings() {
        $defaultSettings = array();

        $defaultSettings['infite_loop'] = FALSE;
        $defaultSettings['slide_width'] = 150;
        $defaultSettings['mode'] = 'horizontal';
        $defaultSettings['min_slides'] = 4;
        $defaultSettings['max_slides'] = 4;
        $defaultSettings['pager'] = false;
        $defaultSettings['move_slides'] = 2;

        return $defaultSettings;
    }

    public function getDefaultValues() {
        return array();
    }
}
