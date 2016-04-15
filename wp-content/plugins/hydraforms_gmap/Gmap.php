<?php

namespace Hydra\Plugins\Gmap;


use Hydra\Formatter as Formatter;
use Hydra\Definitions;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder;
use Hydra\Widgets;
use Hydra\Widgets\Widget;

class GmapDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'gmap';
    }

    protected function definitionSpecificFields($fieldSet) {

    }

    public function getTokenDefinition() {
        return array(
            'latitude' => array(
                'title' => __('Latitude', 'hydraforms'),
                'name' => 'value',
            ),
            'longitude' => array(
                'title' => __('Longitude', 'hydraforms'),
                'name' => 'value',
            ),
            'direct_link' => array(
                'title' => __('Direct Link to Maps', 'hydraforms')
            ),
        );
    }

    public function replaceToken($fieldRecord, $token_id, $column, $value, $text) {
        if (isset($value['items'][0])) {
            if (is_array($value['items'][0])) {

                switch ($column) {
                    case 'latitude':
                    case 'longitude':
                        return str_replace($token_id, $value['items'][0][$column], $text);
                        break;
                    case 'direct_link':
                        $value = $value['items'][0];
                        $map_link = 'http://maps.google.com/maps?q=' . $value['latitude'] . ',' . $value['longitude'];
                        $link = "<a href=$map_link>" . __('See on Google Maps', 'hydraforms') . "</a>";
                        return str_replace($token_id, $link, $text);
                        break;
                }

            }
        }

        return $text;
    }
//
}

/**
 * Class TextareaWidget
 * @package Hydra\Widgets
 */
class GmapWidget extends Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'gmap';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $wrapperSet->isRenderable(TRUE);
        $wrapperSet->setLabel($this->fieldRecord->getLabel());

        $itemSet->addField('text', array('search', __('Search', 'hydraforms')))
            ->addAttribute('class', 'search')
            ->setAttribute('id', 'pac-input');

        $itemSet->addField('text', array('latitude', __('Latitude', 'hydraforms')))
            ->addAttribute('class', 'latitude');
        $itemSet->addField('text', array('longitude', __('Longitude', 'hydraforms')))
            ->addAttribute('class', 'longitude');

        $itemSet->addField('markup', array(
            'map_wrapper',
            "<div id=\"map\" style=\"height: 300px; width:100%; \"></div>"
        ));

        $values = $this->getWidgetValues();
        $itemSet->setValue($values['items'][$index]);
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['latitude']) || empty($item['longitude'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        return $items;
    }
}