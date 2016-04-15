<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;
use Hydra\Widgets\DaterangeWidget;
use Hydra\Widgets\Widget;
use Hydra\Widgets\WidgetManager;


class FieldDefinition {

    private $builder;
    protected $fieldName;
    protected $type;
    protected $widget_type;

    public function getBuilder() {
        return $this->builder;
    }

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        $this->widget_type = $widget_type;
        $this->builder = $builder;
        $this->type = 'field';
    }

    public function buildDefinition($fieldRecord = NULL) {
        $builder = $this->builder;

        $fieldset = $builder->addField('fieldset', array('general', __('General information', 'hydra')))
            ->isTree()
            ->addDecorator('table');

        $fieldset->addField('text', array('field_name', __('Name', 'hydra')))
            ->addDecorator('suffix', array($fieldRecord->getCleanMachineName()))
            ->addValidator('required', 'Required')
            ->setDescription('Machine readable name')
            ->addAttribute('disabled', TRUE);

        $fieldset->addField('text', array('field_label', __('Label', 'hydra')))
            ->enableTranslatable()
            ->addValidator('required', 'Required')
            ->setDescription('Field label');

        $options = hydra_widget_get_widgets_for_type($this->type);
        $fieldset->addField('select', array('cardinality', __('Cardinality', 'hydra')))
            ->setOptions(array(
                0 => "Unlimited items",
                1 => "Single item",
                2 => "2 items",
                3 => "3 items",
                4 => "4 items",
                5 => "5 items",
                6 => "6 items",
                7 => "7 items",
                8 => "8 items",
                9 => "9 items",
            ));

        $options = hydra_widget_get_widgets_for_type($this->type);

        $widgetName = '';
        if ($fieldRecord) {
            $widgetName = $fieldRecord->widget;
        }
        else {
            $keys = array_keys($options);
            $widgetName = reset($keys);
        }

        // widget
        if($options) {
            $fieldset->addField('select', array('widget', __('Select widget', 'hydraforms')))
                ->setAttribute('id', 'widget-select')
                ->setOptions($options);
        }

        $widgetFieldset = $builder->addField('fieldset', array('widget', __('Widget', 'hydraforms')))
            ->setAttribute('id', 'widget')
            ->isTree(false);

        if($this->widget_type == 'filter') {
            $widgetManager = new WidgetManager();
            $widgetManager->getWidgetAdminFilterForm($fieldRecord->widget, $this, $fieldRecord, $widgetFieldset);
        } else {
            $widgetManager = new WidgetManager();
            $widgetManager->getWidgetAdminForm($fieldRecord->widget, $this, $fieldRecord, $widgetFieldset);
        }

        // validators
        $validatorsFieldset = $builder->addField('fieldset', array('validators', __('Validators', 'hydraforms')));
        $validatorsFieldset->addField('checkbox', array('required', __('Required', 'hydraforms')));

        $fieldset = $builder->addField('fieldset', array('attributes', __('Attributes', 'hydraforms')));
        $fieldset->addDecorator('table');

        $this->definitionSpecificFields($fieldset);
        // remove attributes if nothing there
        if(!count($fieldset->getFields())) {
            $builder->removeField('attributes');
        }


        if ($fieldRecord) {
            $fieldset->setValue($fieldRecord->attributes);
        }
    }

    protected function definitionSpecificFields($fieldSet) {

    }

    public function getTokenDefinition() {
        return array(
            'value' => array(
                'title' => __('Raw', 'hydraforms'),
                'name' => 'value',
            ),
        );
    }

    public function replaceToken($fieldRecord, $token_id, $column, $value, $text) {
        if(isset($value['items'][0][$column])) {
            if(is_string($value['items'][0][$column])) {
                return str_replace($token_id, $value['items'][0][$column], $text);
            }
        }

        return $text;
    }
}

