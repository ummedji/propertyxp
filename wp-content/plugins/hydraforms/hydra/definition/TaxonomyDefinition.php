<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;


class TaxonomyDefinition extends FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'taxonomy';
    }

    protected function definitionSpecificFields($fieldSet) {

        $options = array();
        $taxonomies = get_taxonomies(array('public' => TRUE), 'objects');

        foreach ($taxonomies as $taxonomy) {
            $options[$taxonomy->name] = $taxonomy->labels->name;
        }

        if (isset($options['post_format'])) {
            unset($options['post_format']);
        }

        $fieldSet->addField('select', array('taxonomy', 'Taxonomies'))
            ->setOptions($options);
    }

    public function getOptions($fieldRecord) {
        if (!isset($fieldRecord->attributes) || !isset($fieldRecord->attributes['taxonomy'])) {
            return FALSE;
        }

        ob_start();

        wp_list_categories(
            array(
                'taxonomy' => $fieldRecord->attributes['taxonomy'],
                'hide_empty' => FALSE,
                'style' => 'none',
                'walker' => new testWalker($fieldRecord),
            )
        );

        $options = array();
        $output = ob_get_clean();

        $options[0] = '----';
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            if (!empty($line)) {
                list($key, $value) = explode('|', $line);
                $options[$key] = $value;
            }
        }

        return $options;
    }

    public function getTokenDefinition() {
        return array(
            'value' => array(
                'title' => __('Term ID', 'hydraforms'),
                'description' => __('Taxonomy term ID', 'hydraforms'),
                'name' => 'value',
            ),
            'title' => array(
                'title' => __('Term Title', 'hydraforms'),
                'description' => __('Taxonomy term title as raw text', 'hydraforms'),
                'name' => 'title',
            ),
            'link' => array(
                'title' => __('Term Link', 'hydraforms'),
                'description' => __('Taxonomy term title as link to taxonomy page', 'hydraforms'),
                'name' => 'link',
            ),
        );
    }

    public function replaceToken($fieldRecord, $token_id, $column, $value, $text) {

        if (!isset($value['items'][0]) || !isset($value['items'][0]['value'])) {
            return $text;
        }

        $tid = $value['items'][0]['value'];
        $settings = $fieldRecord->attributes;

        $result = array();

        if (is_array($tid)) {
            foreach ($tid as $id) {
                $result[] = $this->processToken($token_id, $column, $settings, $id, $value);
            }
        }
        else {
            $result[] = $this->processToken($token_id, $column, $settings, $tid, $value);
        }

        $result = implode(', ', $result);
        $text = str_replace($token_id, $result, $text);
        return $text;
    }

    private function processToken($token_id, $column, $settings, $tid, $value) {
        $term = get_term($tid, $settings['taxonomy']);

        switch ($column) {
            case 'value':
                return $tid;
                break;
            case 'link':
                if (!is_wp_error($term)) {
                    $link = get_term_link($term, $settings['taxonomy']);
                    return "<a href=$link>" . $term->name . "</a>";
                }

                break;
            case 'title':
                if (!is_wp_error($term)) {
                    return $term->name;
                }
                break;
        }
    }
}


class testWalker extends \Walker {
    // vars
    var $tree_type = 'category',
        $db_fields = array('parent' => 'parent', 'id' => 'term_id');


    // construct
    function __construct($field) {
        $this->field = $field;
    }


    // start_el
    function start_el(&$output, $term, $depth = 0, $args = array(), $current_object_id = 0) {

        $output .= $term->term_id . '|' . $term->name . "\n";
    }


    //end_el
    function end_el(&$output, $term, $depth = 0, $args = array()) {
    }


    // start_lvl
    function start_lvl(&$output, $depth = 0, $args = array()) {
    }


    // end_lvl
    function end_lvl(&$output, $depth = 0, $args = array()) {
    }

}