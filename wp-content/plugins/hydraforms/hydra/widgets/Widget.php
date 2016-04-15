<?php

namespace Hydra\Widgets;

use Hydra\Builder;


/**
 * Class WidgetManager
 * @package Hydra\Widgets
 */
class WidgetManager {


    /**
     * @param $name
     * @param $fieldDefinition
     * @param $fieldRecord
     * @param $parentElement
     * @param bool $noWrapper
     * @return array|mixed
     */
    public function getWidgetForm($name, $fieldDefinition, $fieldRecord, $parentElement, $noWrapper = FALSE, $isAdmin = FALSE) {
        $widget = $this->getWidget($name, array($fieldDefinition, $fieldRecord, $parentElement, $isAdmin));

        if(!$widget) {
            return;
        }
        if ($noWrapper) {
            $this->createFormNoWrapper($widget, $parentElement);
        }
        else {
            $parentElement->addAttribute('class', 'form-set');
            $this->createForm($widget);
        }
    }

    /**
     * @param $name
     * @param $fieldDefinition
     * @param $fieldRecord
     * @param $parentElement
     * @param $referrer_id
     * @param bool $noWrapper
     */
    public function getWidgetAdminForm($name, $fieldDefinition, $fieldRecord, $parentElement) {

        $widget = $this->getWidget($name, array($fieldDefinition, $fieldRecord, $parentElement, TRUE));
        if(!$widget) {
            return;
        }
        $widgetDefaultValues = $parentElement->addField('fieldset', array('default_values', __('Widget', 'hydraforms')))
            ->addDecorator('table');
        $this->getWidgetForm($name, $fieldDefinition, $fieldRecord, $widgetDefaultValues, FALSE, TRUE);

        $widgetSettings = $parentElement->addField('fieldset', array('widget_settings', __('Widget Settings', 'hydraforms')))
            ->addDecorator('table');
        $widget->getSettingsForm($widgetSettings, $fieldRecord);
    }

    /**
     * @param $name
     * @param $fieldDefinition
     * @param $fieldRecord
     * @param $parentElement
     * @param bool $noWrapper
     */
    public function getWidgetAdminFilterForm($name, $fieldDefinition, $fieldRecord, $parentElement) {
        $widget = $this->getWidget($name, array($fieldDefinition, $fieldRecord, $parentElement, TRUE));
        if(!$widget) {
            return;
        }
        $widgetDefaultValues = $parentElement->addField('fieldset', array('default_values', __('Widget', 'hydraforms')))
            ->addDecorator('table');
        $this->getWidgetForm($name, $fieldDefinition, $fieldRecord, $widgetDefaultValues);

        $widgetSettings = $parentElement->addField('fieldset', array('widget_settings', __('Widget Settings', 'hydraforms')))
            ->addDecorator('table');

        $widget->getSettingsForm($widgetSettings, $fieldRecord);

        $widgetSettings = $parentElement->addField('fieldset', array('widget_condition', __('Filter Condition', 'hydraforms')))
            ->addDecorator('table');
        $widget->getConditionForm($widgetSettings, $fieldRecord);
    }

    /**
     * @param $widget
     * @param $parentElement
     * @return mixed
     */
    public function createFormNoWrapper($widget, $parentElement) {

        // This is designated for Filter and Custom Forms
        $parent = $parentElement->addField('fieldset', array($widget->getFieldRecord()->field_name, ''))
            ->removeAllDecorators()
            ->isRenderable(FALSE);

        $parent->addAttribute('class', 'form-set');
        return $widget->createItem($parent, $parentElement, 0);
    }

    /**
     * @param $widget
     * @return array
     */
    public function createForm(Widget $widget) {
        $id = str_replace('_', '-', $widget->getFieldRecord()->field_name);

        $values = array(
            'items' => array(),
        );

        // Some fields do not support cardinality in usual way - checkboxes
        if ($widget->isCardinalityAllowed()) {

            // get the values for this record - if it is assigned to the post
            if (isset($widget->getFieldRecord()->meta)) {
                $values = $widget->getFieldRecord()->meta->value;
            }

            // unlimited cardinality
            if ($widget->getFieldRecord()->cardinality == 0) {

                // set proper values count
                if (!isset($widget->itemCount) || empty($widget->itemCount)) {
                    $valuesCount = 1;
                    if (isset($values['items'])) {
                        $valuesCount = count($values['items']);
                    }
                    $widget->itemCount = !empty($valuesCount) ? $valuesCount : 1;
                }
            }
            else {
                // specific number of items
                $widget->getParentElement()->isRenderable(FALSE);
                $widget->itemCount = $widget->getFieldRecord()->cardinality;
            }
        }

        // cardinality not allowed - only one element should be rendered
        // also disabling rendering of parent as there never will be 'add-more' button
        else {
            $widget->itemCount = 1;
            $widget->getParentElement()->isRenderable(FALSE);
        }

        $widget->getParentElement()->setAttribute('id', $id);

        $wrapperSet = $widget->getParentElement()->addField('fieldset', array('items', ''))
            ->removeAllDecorators()
            ->isRenderable(FALSE)
            ->addAttribute('class', 'field-widget-wrapper')
            ->addAttribute('class', 'field-widget-' . $widget->getType() . '-wrapper')
            ->addAttribute('class', 'field-widget-' . $widget->getFieldRecord()->field_type . '-wrapper')
            ->addAttribute('class', 'field-widget-cardinality-' . $widget->getFieldRecord()->cardinality);


        $widget->createItems($wrapperSet);

        // only unlimited cardinality gets add more button
        if ($widget->getFieldRecord()->cardinality == 0 && $widget->isCardinalityAllowed()) {
            $widget->getParentElement()->addField('submit', array('add_more_button', __("Add more", 'hydraforms')))
                ->addAjaxAction('#' . $id, 'click')
                ->addAjaxCallback('ajaxCallback', $this)
                ->setAttribute('id', 'field-widget-' . $widget->getFieldRecord()->id . '-wrapper-add-more')
                ->addAttribute('class', 'add-more')
                ->addAttribute('class', 'button-secondary');
        }
    }


    /**
     * Simple ajax callback for regenerating this form and setting back the values
     * Created for 'add more' purpose
     * @param $form
     * @param $values
     */
    public function ajaxCallback($form, $values) {
        $fieldName = explode('[', $values['trigger_element']);
        $fieldName = $fieldName[0];
        $fieldModel = new \HydraFieldModel();
        $field = $fieldModel->loadByName($fieldName);
        $definition = hydra_field_get_definition($field->field_type);

        $parentElement = $form->getField($fieldName);
        $parentElement->removeFields();
        $widget = $this->getWidget($field->widget, array($definition, $field, $parentElement));

        $values[$fieldName]['count'] += 1;
        $widget->itemCount = $values[$fieldName]['count'];
        $this->createForm($widget);


        // setting values back ?
        $parentElement->setValue($values[$fieldName]);
        print $parentElement->render();
        $parentElement->nestedNamesSet = 0;

        $form->build();
    }


    /**
     * Simple loader to load widgets
     * @param $name
     * @param $args
     * @return null
     */
    public function getWidget($name, $args) {
        $widget = hydra_widget_get_widget($name);

        if(!$widget) {
            return null;
        }
        try {
            require_once $widget['file'];
            $reflection = new \ReflectionClass($widget['class']);

            $widgets[$name] = $reflection->newInstanceArgs($args);

            if(isset($args[3])) {
                $widgets[$name]->setIsAdmin($args[3]);
            }
            return $widgets[$name];
        } catch (Exception $e) {
            // @todo create custom exceptions
            // echo $e->getMessage();
        }
    }
}


/**
 * Convenient class to quickly assign commonly used attributes to field
 */
final class FieldAttributesGenerator {

    public static function getInstance() {
        static $inst = NULL;
        if ($inst === NULL) {
            $inst = new FieldAttributesGenerator();
        }

        return $inst;
    }

    private function __construct() {
    }

    public function process($field, $attributes) {
        foreach ($attributes as $index => $attribute) {

            switch ($index) {
                case 'prefix':
                case 'suffix':
                    if (!empty($attribute)) {
                        $field->addDecorator($index, array($attributes[$index]));
                    }
                    break;
                case 'hide_label':
                    if ($attribute) {
                        $field->disableLabel();
                    }
                    break;
                case 'class':
                    if (!empty($attribute)) {
                        $field->addAttribute('class', $attribute);
                    }
                    break;
                case 'placeholder':
                    if (!empty($attribute)) {
                        $field->addAttribute('placeholder', $attribute);
                    }
                default:
                    break;
            }
        }
    }
}


abstract class Widget {

    /**
     * Type if the widget - machine readable name
     * @var string
     */
    protected $type;

    /**
     * Field Definition of the Widget
     * @var
     */
    protected $fieldDefinition;

    /**
     * Database record of field which is using the field
     * @var
     */
    protected $fieldRecord;

    /**
     * @todo - Well we should get rid of this as this is mighty stupid!
     * @var
     */
    protected $parentElement;

    /**
     * @var bool
     */
    protected $isAdmin;

    /**
     * @var
     */
    public $itemCount;

    public function setIsAdmin($value) {
        $this->isAdmin = $value;
    }

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        // generic widget - widget, children should overwrite this to match their machine name - select, hierarchy, ...
        $this->type = 'widget';
        if($fieldDefinition) {
            $this->setFieldDefinition($fieldDefinition);
        }

        if($fieldRecord) {
            $this->setFieldRecord($fieldRecord);
        }

        if($parentElement) {
            $this->setParentElement($parentElement);
        }

        $this->isAdmin = FALSE;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Cardinality, if not allowed, cardinality is restricted in a ...
     * @todo - ha. cardinality for select - multiselect, this is handled on level of manager, should not be!
     * However
     * @return bool
     */
    public function isCardinalityAllowed() {
        return TRUE;
    }

    /**
     * @param $fieldDefinition
     */
    public function setFieldDefinition($fieldDefinition) {
        $this->fieldDefinition = $fieldDefinition;
    }

    /**
     * @return mixed
     */
    public function getFieldDefinition() {
        return $this->fieldDefinition;
    }

    /**
     * @param $fieldRecord
     */
    public function setFieldRecord($fieldRecord) {
        $this->fieldRecord = $fieldRecord;
    }

    /**
     * @return mixed
     */
    public function getFieldRecord() {
        return $this->fieldRecord;
    }

    /**
     * @return mixed
     */
    public function isRequired() {
        $validators = $this->fieldRecord->validators;
        if(isset($validators['required'])) {
            return (bool)$validators['required'];
        }
        return false;
    }

    /**
     * @todo Removed!
     * @param $parentElement
     */
    public function setParentElement($parentElement) {
        $this->parentElement = $parentElement;
    }

    /**
     * @todo Removed!
     * @return mixed
     */
    public function getParentElement() {
        return $this->parentElement;
    }

    /**
     * Simple iterator for creating items.
     * @param $widget
     * @param $wrapperSet
     * @return array
     */
    public function createItems($wrapperSet, $itemCount = null ) {
        if($itemCount) {
            $this->itemCount = $itemCount;
        }

        if(!$this->itemCount) {
            $this->itemCount = 1;
        }

        $required = 0;
        if($this->isAdmin && isset($this->fieldRecord->validators['required'])) {
            $required = $this->fieldRecord->validators['required'];
            $this->fieldRecord->validators['required'] = 0;
        }

        for ($index = 0; $index < $this->itemCount; $index++) {
            // new item set
            $itemSet = $wrapperSet->addField('fieldset', array($index, ''))
                ->isRenderable(FALSE)
                ->addAttribute('class', 'field-item-wrapper')
                ->addAttribute('class', 'field-item-wrapper-' . $index);

            $itemSet->removeAllDecorators();
            $this->createItem($itemSet, $wrapperSet, $index);
        }

        if($required) {
            $this->fieldRecord->validators['required'] = $required;
        }

        $defaultValues = $this->getDefaultValues();
        $wrapperSet->setValue($defaultValues);

        if(isset($this->parentElement)) {
            $this->parentElement->addField('hidden', array('count', $this->itemCount));
        }
    }

    /**
     * Create on singe ItemDefinition
     * @param $itemSet
     * @param $wrapperSet
     */
    public abstract function createItem($itemSet, $wrapperSet, $index);

    /**
     * @param \HydraFieldRecord $fieldRecord
     * @param $items
     * @param null $post
     * @return array
     */
    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        if (!count($items['items'])) {
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

    /**
     * List allowed conditions for particular, database column.
     * @return array
     */
    public function allowedConditions() {
        // range slider support only in between condition - obviously
        return array(
            'value' => array(
                'equals' => __('Equals', 'hydraforms'),
            ),
        );
    }

    /**
     * Basic filtering meta-query composition, should be override in child widget, in most cases
     * @param $filterField
     * @param $conditionField
     * @param $condition
     * @param $value
     * @return array
     */
    public function composeCondition($filterField, $conditionField, $condition, $value) {
        // condition, value cannot be empty
        if (isset($value[$condition->col]) && !empty($value[$condition->col])) {
            if ($compare = $this->getConditionMapping($condition->condition)) {

                if(is_array($value)) {
                    $metaArgs = array(
                        'key' => $filterField->field_name . '_%_' . $condition->col,
                        'compare' => 'IN',
                        'value' => $value[$condition->col],
                    );
                } else {
                    $metaArgs = array(
                        'key' => $filterField->field_name . '_%_' . $condition->col,
                        'compare' => $compare,
                        'value' => $value[$condition->col],
                    );
                }
            }
        }

        return $metaArgs;
    }

    /**
     * Condition mapping - condition => Human Readable label
     * @param null $index
     * @return array|bool
     */
    public function getConditionMapping($index = NULL) {
        $mapping = $this->getConditions();

        if ($index && isset($mapping[$index])) {
            return $mapping[$index];
        }

        if (!$index) {
            return FALSE;
        }

        return $mapping;
    }

    /**
     * List if available comparators
     * @return array
     */
    public function getConditions() {
        return array(
            'equals' => "=",
            'like' => "LIKE",
            'greater' => '>',
            'greater-equals' => '>=',
            'lower' => '<',
            'lower-equals' => '<=',
            'in-array' => '=',
        );
    }

    public function getConditionForm($parentForm, \HydraFieldRecord $fieldRecord) {
        $columns = $this->allowedConditions();
        foreach ($columns as $index => $allowedConditions) {
            $columnSet = $parentForm->addField('fieldset', array($index, ''))
                ->isRenderable(FALSE);

            $columnSet->addField('hidden', array('col', $index));
            $columnSet->addField('select', array('condition', __($index, 'hydraforms')))
                ->setOptions($allowedConditions);

            $condition = $fieldRecord->loadCondition($index);

            if ($condition) {
                $columnSet->addField('hidden', array('id', $condition->id));
                $columnSet->setValue((array) $condition);
            }
            else {
                $columnSet->addField('hidden', array('id', 0));
            }
        }
    }

    /**
     * Widget Settings Form
     * @param $parentForm
     * @param \HydraFieldRecord $fieldRecord
     */
    public function getSettingsForm($parentForm, \HydraFieldRecord $fieldRecord) {
        $defaultSettingsValues = $this->getDefaultSettings();

        $parentForm->addField('checkbox', array('hide_label', __('Hide label', 'hydraforms')))
            ->setDescription(__('Do <b>not</b> display label for this element', 'hydraforms'));

        $parentForm->addField('text', array('placeholder', __('Placeholder', 'hydraforms')))
            ->setDescription(__('Placeholder text - will disappear when input is selected', 'hydraforms'))
            ->enableTranslatable();

        $parentForm->addField('text', array('prefix', __('Prefix', 'hydraforms')))
            ->setDescription(__('Value which will be displayed before field input', 'hydraforms'))
            ->enableTranslatable();
        $parentForm->addField('text', array('suffix', __('Suffix', 'hydraforms')))
            ->setDescription(__('Value which will be displayed after field input', 'hydraforms'))
            ->enableTranslatable();
        $parentForm->addField('text', array('class', __('Classes', 'hydraforms')))
            ->setDescription(__('List of css classes separated by space', 'hydraforms'));

        $parentForm->setValue($defaultSettingsValues);
    }

    /**
     * Get settings stored in database
     * If not available default settings take the place
     * @return array
     */
    public function getWidgetValues() {
        $values = array();

        if($this->fieldRecord->widget == $this->type) {
            if (isset($this->fieldRecord->default_values) && !empty($this->fieldRecord->default_values)) {
                $values = $this->fieldRecord->default_values;
            }
        }

        $defaultValues = $this->getDefaultValues();

        return array_merge($defaultValues, $values);
    }

    /**
     * Get settings stored in database
     * If not available default settings take the place
     * @return array
     */
    public function getWidgetSettings() {
        $settings = array();

        if($this->fieldRecord->widget == $this->type) {
            if (isset($this->fieldRecord->widget_settings) && !empty($this->fieldRecord->widget_settings)) {
                $settings = $this->fieldRecord->widget_settings;
            }
        }

        $defaultSettings = $this->getDefaultSettings();

        return array_merge($defaultSettings, $settings);
    }

    /**
     * Get default settings values
     * Its basically a array of index => value,
     *
     * Index -> represents a settings key
     * @return array
     */
    public function getDefaultSettings() {
        return array();
    }

    /**
     * Gets default values for widget!
     * @return array
     */
    public function getDefaultValues() {
        return array();
    }
}


/**
 * Class FieldsetWidget
 * @package Hydra\Widgets
 */
class FieldsetWidget extends Widget {
    public function isCardinalityAllowed() {
        return FALSE;
    }

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'group';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        // does not have definition like this
        // special widget
    }
}