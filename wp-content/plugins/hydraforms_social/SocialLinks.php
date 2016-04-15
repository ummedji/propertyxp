<?php

namespace Hydra\Plugins\Social;

use Hydra\Formatter;
use Hydra\Definitions;
use Hydra\Builder;
use Hydra\Widgets;

class SocialLinksDefinition extends Definitions\FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'social_links';
    }

    protected function definitionSpecificFields($fieldSet) {
        $fieldSet->removeField('placeholder');

        $socialField = $fieldSet->addField('checkboxes', array('social', __('Social Links', 'hydraforms')))
            ->setOptions(array(
                'facebook' => __('Facebook', 'hydraforms'),
                'twitter' => __('Twitter', 'hydraforms'),
                'linked_in' => __('Linked In', 'hydraforms'),
                'gplus' => __('Google+', 'hydraforms'),
            ))->setDefaultValue(array(
                    'facebook' => TRUE,
                    'twitter' => TRUE,
                    'linked_in' => TRUE,
                    'gplus' => TRUE,
                )
            );
    }

    public function getMapping() {
        $mapping = array(
            'facebook' => array(
                'title' => __('Facebook', 'hydraforms'),
                'icon' => 'fa fa-facebook',
            ),
            'twitter' => array(
                'title' => __('Twitter', 'hydraforms'),
                'icon' => 'fa fa-twitter',
            ),
            'linked_in' => array(
                'title' => __('Linked In', 'hydraforms'),
                'icon' => 'fa fa-linkedin',
            ),
            'gplus' => array(
                'title' => __('Google+', 'hydraforms'),
                'icon' => 'fa fa-google-plus',
            )
        );

        return $mapping;
    }

    public function getTokenDefinition() {
        return array(
            'facebook' => array(
                'name' => 'facebook',
                'title' => __('Facebook Link', 'hydraforms'),
            ),
            'twitter' => array(
                'name' => 'twitter',
                'title' => __('Twitter Link', 'hydraforms'),
            ),
            'linked_in' => array(
                'name' => 'linked_in',
                'title' => __('Linked In', 'hydraforms'),
            ),
            'gplus' => array(
                'name' => 'gplus',
                'title' => __('Google Plus', 'hydraforms'),
            )
        );
    }
}

/**
 * Class SocialLinks
 * @package Hydra\Widgets
 */
class SocialLinksWidget extends Widgets\Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'social_links_widget';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $fieldRecord = $this->getFieldRecord();

        $social_links = array();
        if (isset($fieldRecord->attributes['social'])) {
            $social_links = $fieldRecord->attributes['social'];
        }
        $mapping = $this->getFieldDefinition()->getMapping();

        if (count($social_links)) {
            foreach ($social_links as $index => $value) {
                if ($value) {
                    $itemSet->addField('text', array($index, $mapping[$index]['title']));
                }
            }
        }
    }

    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items = array(), $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => &$item) {
            if (!count($item)) {
                unset($items[$key]);
                continue;
            }

            foreach ($item as $index => $social) {
                if (empty($social)) {
                    unset($item[$index]);
                }
            }
        }

        return $items;
    }
}

class SocialLinksFormatter extends Formatter\Formatter {
    public function __construct() {
        $this->name = 'social_links';
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
        $meta->social = $view->field->attributes['social'];
        $defManager = new Definitions\DefinitionManager();
        $definition = $defManager->createDefinition($view->field->field_type);

        $meta->mapping = $definition->getMapping();
        return parent::renderItems($view, $meta, $settings, $items);
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

        if(!isset($meta->social) || (is_array($meta->social) && !count($meta->social)) || !$meta->social) {
            return '';
        }

        foreach ($meta->social as $social) {
            if (isset($item[$social])) {
                $output .= "<a href=" . $item[$social] . "><i class=\"" . $meta->mapping[$social]['icon'] . "\"></i></a>";
            }
        }

         $output .= '</div>';

        return $output;
    }

    /**
     * @param $parentElement
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentElement, $settings, $field) {
        parent::getSettingsForm($parentElement, $settings, $field);
        $parentElement->removeField('suffix');
        $parentElement->removeField('prefix');
    }

    public function getTokenDefinition() {
        return array();
    }

}






