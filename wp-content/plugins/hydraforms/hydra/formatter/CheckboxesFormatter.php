<?php

namespace Hydra\Formatter;

use Hydra\Builder;
use Hydra\Definitions\DefinitionManager;

class CheckboxesFormatter extends Formatter {
    public function __construct() {
        $this->name = 'checkboxes';
    }

    /**
     * Render all the items
     * @param $view
     * @param $meta
     * @param $settings
     * @param $items
     * @return string
     */
    public function renderItems($view, $meta, $settings, $items) {
        $defManager = new DefinitionManager();
        $definition = $defManager->createDefinition($view->field->field_type);
        $options = $definition->getOptions($view->field);

        if (!$options || (is_array($options) && !count($options))) {
            return FALSE;
        }

        $keys = array_keys($options);
        $key = array_shift($keys);
        unset($options[$key]);

        $settings = $view->settings;
        $value = array();
        $item = reset($items);

        unset($item['value'][0]);


        foreach ($item['value'] as $val) {
            $value[$val] = $val;
        }


        if($settings['only_enabled']) {
            $tmp_options = array();
            foreach($options as $id => $option) {
                if(isset($value[$id])) {
                    $tmp_options[$id] = $option;
                }
            }

            $options = $tmp_options;
        }

        $output = '';

        if (!$items) {
            return $output;
        }

        $chunks = array_chunk($options, ceil(count($options) / $settings['columns_number']), TRUE);
        $columns_class = $settings['columns_class'];

        ob_start();
        $person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid'));
        
        if($person_field != 'Developer')
        	include 'templates/checkboxes.tpl.php';
        else 
        	include 'templates/checkboxes_developer.tpl.php';
        $output = ob_get_clean();
        return $output;

        return $output;
    }

    // No implementation, rendering is forwarded to template
    public function renderItem($meta, $delta, $settings, $item) {

    }

    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('prefix');
        $parentForm->removeField('suffix');

        $parentForm->addField('text', array('columns_number', __('Number of columns', 'hydraforms')))
            ->setDefaultValue(2);

        $parentForm->addField('text', array('columns_class', __('Class for each column', 'hydraforms')))
            ->setDefaultValue('column');

        $parentForm->addField('checkbox', array('only_enabled', __('Display only enabled', 'hydraforms')))
            ->setDefaultValue(0);
    }

    public function getDefaultSettings() {
        $defaultSettings = parent::getDefaultSettings();
        $defaultSettings['columns_number'] = 2;
        $defaultSettings['column_class'] = '';
        $defaultSettings['only_enabled'] = 0;

        return $defaultSettings;
    }
}
