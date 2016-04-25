<?php

namespace Hydra\Formatter;

require_once 'GroupFormatter.php';
require_once 'BasicFormatter.php';

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Fields\TextField;


class Formatter {

    protected $name;

    /**
     * Utility function for getting values
     * @param $view
     * @return array|bool
     */
    public function getValues($view) {
        $meta = $view->field->meta;
        if (!isset($meta->value)) {
            return FALSE;
        }


        $value = $meta->value;
        if (!isset($value['items'])) {
            return FALSE;
        }

        $items = $value['items'];

        // check if empty
        if (!is_array($items) || !count($items)) {
            return FALSE;
        }

        return $items;
    }


    /**
     * Print attributes which are pulled from field instance and settings
     * @param $view
     * @return string
     */
    protected function printAttributes($view) {
        $output = '';

        $attributes = array();
        if (isset($view->attributes)) {
            if ($view->attributes) {
                $attributes = $view->attributes;
                $class = $attributes['class'];
                $attributes['class'] = array($class);
            }
        }

        // @todo - meh, todo later, should go in attributes, not in settings
        if (isset($view->settings['class'])) {
            $attributes['class'][] = $view->settings['class'];
        }
        if (isset($view->settings['columns'])) {
            $attributes['class'][] = $view->settings['columns'];
        }

        $attributes['class'][] = $this->name;
        $attributes['class'][] = str_replace('_', '-', $view->field->field_type);
        $attributes['class'][] = str_replace('_', '-', $view->field->field_name);

        foreach ($attributes as $attribute => $values) {
            $value = implode(" ", $values);
            $output .= "$attribute=\"$value\"";
        }

        return trim($output);
    }

    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        $parentForm->addField('text', array('class', __('Class', 'hydraforms')));

        $parentForm->addField('text', array('prefix', __('Prefix', 'hydraforms')));
        $parentForm->addField('text', array('suffix', __('Suffix', 'hydraforms')));

        $parentForm->addField('checkbox', array('hide_label', __('Hide label', 'hydraforms')));
        $parentForm->addField('checkbox', array('label_below', __('Label after value', 'hydraforms')));

        $parentForm->addField('select', array('label_element', __('Label HTML', 'hydraforms')))
            ->setOptions(array(
                'div' => 'Div',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
            ));

        $parentForm->addField('select', array('columns', __('Column Width - Mobile', 'hydraforms')))
            ->setOptions(array(
                'no-columns' => 'No columns',
                'col-xs-1' => '1 column',
                'col-xs-2' => '2 column',
                'col-xs-3' => '3 column',
                'col-xs-4' => '4 column',
                'col-xs-5' => '5 column',
                'col-xs-6' => '6 column',
                'col-xs-7' => '7 column',
                'col-xs-8' => '8 column',
                'col-xs-9' => '9 column',
                'col-xs-10' => '10 column',
                'col-xs-11' => '11 column',
                'col-xs-12' => '12 column',
            ));
    }

    /**
     * Returns default settings configuration
     * Configuration to be created upon first saving
     * @return array
     */
    public function getDefaultSettings() {
        return array(
            'class' => '',
            'hide_label' => 0,
            'label_below' => 0,
            'label_element' => 'div',
            'columns' => 'no-columns',
        );
    }

    /**
     * Basic rendering
     *
     * Most straight forward way
     * @param \HydraFieldViewRecord $view
     * @param $post
     * @return bool|string
     */
    public function render(\HydraFieldViewRecord $view, $post) {
        $items = $this->getValues($view);
        if (!$items) {
            return FALSE;
        }

        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }

    /**
     * Render Field Label if not disabled
     * @param $view
     * @param $meta
     * @param $settings
     * @return string
     */
    public function renderLabel($view, $meta, $settings) {
        if (!$settings['hide_label']) {
            if (empty($settings['label_element'])) {
                $settings['label_element'] = "div";
            }
            return "<" . $settings['label_element'] . " class=label><p>" . $meta->label . "</p></" . $settings['label_element'] . ">";
        }
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
        $output = '';

        if (!$items) {
            return $output;
        }

        foreach ($items as $delta => $item) {
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        }

        return $output;
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        $output = "<div class=\"field-item field-item-$delta\">";
        if (isset($settings['prefix'])) {
            $output .= "<div class=\"field-prefix\" >" . $settings['prefix'] . "</div>";
        }
        $output .= "<div class=field-value>" . $item['value'] . "</div>";
        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix']. "</div>";
        }
        $output .= '</div>';

        return $output;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isEmpty($value) {
        if ($value == NULL || $value == FALSE) {
            return TRUE;
        }

        if (is_array($value)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get instance of formatter
     * @param $name
     * @param bool $group
     * @return null
     */
    public static function getFormatter($name, $group = FALSE) {
        static $formatters;
        $formatter = hydra_formatter_get_formatter($name);

        // we might want to call the same formatter multiple times
        // don't initialize the same formatter again as
        if (file_exists($formatter['file'])) {
            try {
                // "Lazy" load
                require_once $formatter['file'];

                $reflection = new \ReflectionClass($formatter['class']);
                $formatters[$name] = $reflection->newInstanceArgs(array());
                return $formatters[$name];
            } catch (Exception $e) {
                // @todo create custom exceptions
                // echo $e->getMessage();
            }
        }

        return NULL;
    }

}
