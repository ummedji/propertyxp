<?php

namespace Hydra\Widgets;

/**
 * Class DateCalendarWidget
 * @package Hydra\Widgets
 */
class DateCalendarWidget extends Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'date_calendar';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $from = $itemSet->addField('fieldset', array('from', __('Start', 'hydraforms')));
        $from->addField('date', array('date', __('Date', 'hydraforms')));
        $from->addField('text', array('time', __('Time', 'hydraforms')))
            ->addAttribute('size', 5)
            ->addAttribute('class', 'time');

        $from = $itemSet->addField('fieldset', array('to', __('End', 'hydraforms')));
        $from->addField('date', array('date', __('Date', 'hydraforms')));
        $from->addField('text', array('time', __('Time', 'hydraforms')))
            ->addAttribute('size', 5)
            ->addAttribute('class', 'time');

        $itemSet->addField('checkbox', array('day', 'Day'))
            ->addAttribute('class', 'hide-times');
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['date_start']) || empty($item['date_end'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
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
}