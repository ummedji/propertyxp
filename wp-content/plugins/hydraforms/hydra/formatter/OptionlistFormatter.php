<?php

namespace Hydra\Formatter;

use Hydra\Builder;
use Hydra\Definitions\DefinitionManager;

class OptionlistFormatter extends BasicFormatter {

    public function __construct() {
        $this->name = 'optionlist';
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        $items = $this->getValues($view);

        if (!$items) {
            return $items;
        }

        $view->field->field_type;
        $defManager = new DefinitionManager();
        $definition = $defManager->createDefinition($view->field->field_type);
        $meta = $view->field->meta;
        $settings = $view->settings;

        $options = $definition->getOptions($view->field);
        $output = array();


        foreach ($items as $item) {
            $trimed_string = rtrim($item['value'], "\n");
            $output[] = $options[$trimed_string];
        }

        $output = implode(', ', $output);
        $output = trim($output, ', ');

        $valueOutput = $output;

        $output = '';
        $output .= '<div ' . $this->printAttributes($view) . '>';
        $output .= "<div class=field-value>" . trim($valueOutput) . "</div>";
        $output .= "</div>";
        return $output;

    }

    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);

        $parentForm->removeField('prefix');
        $parentForm->removeField('suffix');
    }
}