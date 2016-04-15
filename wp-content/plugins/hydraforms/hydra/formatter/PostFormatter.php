<?php

namespace Hydra\Formatter;

class PostFormatter extends Formatter {

    public function __construct() {
        $this->name = 'post';
    }

    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }

        foreach ($items as $delta => $item) {
            $output .= $this->renderItemPost($view, $meta, $delta, $settings, $item);
        }

        return $output;
    }

    public function renderItemPost($view, $meta, $delta, $settings, $item) {
        $output = '';
        // This formatter cannot live without theme support
        // it is unfortunate, but its nice also, because i can use word "symbiosis"
        // It is SYMBIOSIS between theme and hydra post reference... neat
        $output = apply_filters( 'hydra_post_reference_item_render', $view, $meta, $delta, $settings, $item);
        return $output;
    }

    /**
     * @param $parentElement
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentElement, $settings, $field) {
        parent::getSettingsForm($parentElement, $settings, $field);
        $parentElement->removeField('class');
        $parentElement->removeField('columns');
        $parentElement->removeField('prefix');
        $parentElement->removeField('suffix');

        $field_settings = $field->attributes;
        $db = new \HydraViewModel();
        $displayTypes = $db->loadByPostType($field_settings['post_type']);
        $options = array();

        foreach($displayTypes as $displayType) {
            $options[$displayType->name] = $displayType->label;
        }

        $parentElement->addField('select', array('display_type', __('Display', 'hydraforms')))
            ->setOptions($options)
            ->setDescription(__('This displays are enabled for selected referenced post type', 'hydraforms'));
    }
}