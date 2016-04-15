<?php

namespace Hydra\Formatter;

class NumberFormatter extends Formatter {

    public function __construct() {
        $this->name = 'number';
    }

    public function isEmpty($value) {
        if ($value == NULL || $value == FALSE) {
            return TRUE;
        }

        if (is_array($value)) {
            return TRUE;
        }

        return FALSE;
    }

    public function renderItem($meta, $delta, $settings, $item) {
        $output = '';

        if (!isset($settings['format'])) {
            $settings['format'] = 0;
        }
        $format = $this->getPredefinedValues($settings['format']);

        $output .= "<div class=\"field-item field-item-$delta\">";
        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-prefix\" >" . $settings['prefix'] . "</div>";
        }

        $output .= "<div class=field-value>" . number_format((float) $item['value'], (int) $format['decimals'], $format['decimalpoint'], $format['separator']) . "</div>";

        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix']. "</div>";
        }
        $output .= '</div>';

        return $output;
    }

    /**
     * Specific settings related to number formatting
     * @param $parentElement
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);

        $options = array();
        foreach ($this->getPredefinedValues() as $key => $predefined) {
            $options[$key] = number_format(100000.99, $predefined['decimals'], $predefined['decimalpoint'], $predefined['separator']);
        }

        $parentForm->addField('select', array('format', __('Output format', 'hydraforms')))
            ->setOptions($options);
    }

    /**
     * Default number formats
     * @param null $index
     * @return array
     */
    private function getPredefinedValues($index = NULL) {
        $predefinedValues = array(
            0 => array(
                'decimals' => 2,
                'decimalpoint' => '.',
                'separator' => ',',
            ),
            1 => array(
                'decimals' => 2,
                'decimalpoint' => ',',
                'separator' => ' ',
            ),
            2 => array(
                'decimals' => 2,
                'decimalpoint' => '.',
                'separator' => ' ',
            ),
            3 => array(
                'decimals' => 2,
                'decimalpoint' => ' ',
                'separator' => ',',
            ),
            4 => array(
                'decimals' => 0,
                'decimalpoint' => '.',
                'separator' => ' ',
            ),
            5 => array(
                'decimals' => 0,
                'decimalpoint' => ' ',
                'separator' => '.',
            ),
        );


        if ($index !== NULL && isset($predefinedValues[$index])) {
            return $predefinedValues[$index];
        }

        return $predefinedValues;
    }
}