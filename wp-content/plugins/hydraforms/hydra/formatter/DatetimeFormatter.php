<?php

namespace Hydra\Formatter;

use Hydra\Builder;

class DatetimeFormatter extends Formatter {

    public function __construct() {
        $this->name = 'datetime';
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        $items = $this->getValues($view);
        if (!$items) {
            return FALSE;
        }

        $meta = $view->field->meta;
        $output = '';
        $settings = $view->settings;

        $output = '<div ' . $this->printAttributes($view) . '>';
        $output .= $this->renderLabel($view, $meta, $settings);
        $output .= $this->renderItems($view, $meta, $settings, $items);
        $output .= "</div>";

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

        if(isset($item['date_start']) && isset($item['date_end'])) {
            $output .= "<div class=field-value>" . date($settings['format'], strtotime($item['date_start'])) . ' - ' . date($settings['format'], strtotime($item['date_end'])) . "</div>";
        } else {
            $output .= "<div class=field-value>" . date($settings['format'], strtotime($item['date'])) . "</div>";
        }

        if (isset($settings['suffix'])) {
            $output .= "<div class=\"field-suffix\">" . $settings['suffix']. "</div>";
        }
        $output .= '</div>';

        return $output;
    }

    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->addField('text', array('format', __('Format of date', 'hydraforms')))
            ->setDefaultValue('d-m-y g:i A');
    }

    public function getDefaultSettings() {
        $defaultSettings = parent::getDefaultSettings();
        $defaultSettings['format'] = 'd-m-y g:i A';

        return $defaultSettings;
    }
}