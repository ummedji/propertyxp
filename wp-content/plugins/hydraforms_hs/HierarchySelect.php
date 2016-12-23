<?php

namespace Hydra\Plugins\HierarchySelect;

use Hydra\Formatter;
use Hydra\Definitions;
use Hydra\Builder;
use Hydra\Widgets;

class TaxonomyHierarchyDefinition extends Definitions\FieldDefinition {

    public function __construct(Builder $builder = NULL, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'hierarchy_select';
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


    public function getOptions($fieldRecord, $index = 0, $all = FALSE, $flat = FALSE) {
        static $taxonomyHierarchyValues;

        if (!isset($fieldRecord->attributes) || !isset($fieldRecord->attributes['taxonomy'])) {
            return array();
        }

        // prevent fetching multiple times from database on same request
        // simplest cache there is
        if (isset($taxonomyHierarchyValues[$fieldRecord->attributes['taxonomy']])) {
            $all_terms = $taxonomyHierarchyValues[$fieldRecord->attributes['taxonomy']];
        }
        else {
            $all_terms = get_terms($fieldRecord->attributes['taxonomy'], array('get' => 'all', 'hierarchical' => TRUE));
        }

        $options = array();

        foreach ($all_terms as $term) {
            if ($flat) {
                $options[$term->term_id] = $term->name;
            }
            else {
                $options[$term->parent][$term->term_id] = $term->name;
            }
        }


        if ($all) {
            return $options;
        }

        return $options[$index];
    }


    public function getOptionsClasses($fieldRecord) {
        if (!isset($fieldRecord->attributes) || !isset($fieldRecord->attributes['taxonomy'])) {
            return FALSE;
        }

        // prevent fetching multiple times from database on same request
        // simplest cache there is
        if (isset($taxonomyHierarchyValues[$fieldRecord->attributes['taxonomy']])) {
            $all_terms = $taxonomyHierarchyValues[$fieldRecord->attributes['taxonomy']];
        }
        else {
            $all_terms = get_terms($fieldRecord->attributes['taxonomy'], array('get' => 'all', 'hierarchical' => TRUE));
        }

        $options = array();
        foreach ($all_terms as $term) {
            $options[$term->term_id] = $term->parent;
        }

        return $options;
    }

    public function getTokenDefinition() {
        return array(
            'country' => array(
                'title' => __('Level 1', 'hydraforms'),
                'name' => 'country',
                'description' => __('Display 1. Level as plain text', 'hydraforms')
            ),
            'country_link' => array(
                'title' => __('Level 1 Link', 'hydraforms'),
                'name' => 'country_link',
                'description' => __('Display 1. Level as link', 'hydraforms')
            ),
            'location' => array(
                'title' => __('Level 2', 'hydraforms'),
                'name' => 'location',
                'description' => __('Display 3. Level as plain text', 'hydraforms')
            ),
            'location_link' => array(
                'title' => __('Level 2 Link', 'hydraforms'),
                'name' => 'location_link',
                'description' => __('Display 2. Level as link', 'hydraforms')
            ),
            'sublocation' => array(
                'title' => __('Level 3', 'hydraforms'),
                'name' => 'sublocation',
                'description' => __('Display 3. Level as plain text', 'hydraforms')
            ),
            'sublocation_link' => array(
                'title' => __('Level 3 Link', 'hydraforms'),
                'name' => 'sublocation_link',
                'description' => __('Display 3. Level as link', 'hydraforms')
            ),
            'all' => array(
                'title' => __('All', 'hydraforms'),
                'name' => 'all',
                'description' => __('Display all levels as plain text', 'hydraforms'),
            ),
            'all_links' => array(
                'title' => __('All as links', 'hydraforms'),
                'name' => 'all_links',
                'description' => __('Display all levels as taxonomy term links', 'hydraforms'),
            ),
        );
    }

    public function replaceToken($fieldRecord, $token_id, $column, $value, $text) {

        if (isset($value['items'][0])) {
            $value = $value['items'][0];


            $taxonomy = $fieldRecord->attributes['taxonomy'];
            $terms = array(
                'country' => isset($value['country']) ? get_term($value['country'], $taxonomy) : false,
                'location' => isset($value['location']) ? get_term($value['location'], $taxonomy) : false,
                'sublocation' => isset($value['sublocation']) ? get_term($value['sublocation'], $taxonomy) : false,
            );

            switch ($column) {
                case 'country':
                case 'location':
                case 'sublocation':
                    if (!is_wp_error($terms[$column]) && $terms[$column]) {
                        $text = str_replace($token_id, $terms[$column]->name, $text);
                    } else {
                        $text = str_replace($token_id, '', $text);
                    }
                    break;
                case 'country_link':
                case 'location_link':
                case 'sublocation_link':
                    $parts = explode('_', $column);
                    if(!is_wp_error($terms[$parts[0]]) && $terms[$parts[0]]) {
                        $link = $this->getTermLink($terms[$parts[0]]);
                        $text = str_replace($token_id, $link, $text);
                    } else {
                        $text = str_replace($token_id, '', $text);
                    }
                    break;
                case 'all':
                    $names = array();
                    foreach($terms as $term) {
                        if(!is_wp_error($term) && $term) {
                            $names[] = $term->name;
                        }
                    }
                    $replace = implode(', ', $names);
                    $text = str_replace($token_id, $replace, $text);
                    break;
                case 'all_links':
                    $links = array();
                    foreach($terms as $term) {
                        if(!is_wp_error($term) && $term) {
                            $link = $this->getTermLink($term);
                            if($link) {
                                $links[] = $link;
                            }
                        }
                    }
                    $replace = implode(', ', $links);
                    $text = str_replace($token_id, $replace, $text);
                    break;
            }
        }

        return $text;
    }

    private function getTermLink($term) {
        if (!is_wp_error($term) && $term) {
            $link = get_term_link($term);

            return "<a href=$link>" . $term->name . "</a>";
        }

        return '';
    }
}


/**
 * Class SelectWidget
 * @package Hydra\Widgets
 */
class HierarchySelectWidget extends Widgets\Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'hierarchy_select_widget';
    }

    public function isCardinalityAllowed() {
        return FALSE;
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $fields = array();
        $itemSet->addAttribute('class', 'location');
        $widgetValues = $this->getWidgetValues();
        $widgetSettings = $this->getWidgetSettings();


        if (!isset($this->fieldRecord->attributes['taxonomy'])) {
            $itemSet->addField('markup', array('message', __('Select taxonomy.', 'hydraforms')));
            return;
        }

        $options = $this->fieldDefinition->getOptions($this->fieldRecord, 0, TRUE);
        $classes = $this->fieldDefinition->getOptionsClasses($this->fieldRecord);
        $settings = $this->fieldRecord->attributes;

        // level settings
        $levels = 3;
        if (isset($widgetSettings['levels'])) {
            $levels = $widgetSettings['levels'];
        }

        $countryOptions[''] = __('- ANY -', 'hydraforms');
        $countryOptions += $options[0];

        $first_level = $itemSet->addField('select', array('country', $widgetSettings['level_1_label']))
            ->setOptions($countryOptions)
            ->addAttribute('class', 'hierarchy-level-1 form-group');

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $first_level->addValidator('required');
        }

        $locationOptions[''] = __(' City ', 'hydraforms');
        if ($options) {
            foreach ($options[0] as $key => $countryOption) {
                if (isset($options[$key]) && is_array($options[$key])) {
                    foreach ($options[$key] as $index => $term) {
                        $locationOptions[$index] = $term;
                    }
                }
            }
        }

        // second level enabled
        if ($levels >= 2) {
            $itemSet->addField('select', array('location', $widgetSettings['level_2_label']))
                ->setOptions($locationOptions)
                ->setOptionsClasses($classes)
                ->addAttribute('class', 'hierarchy-level-2 form-group');

            $sublocationOptions[''] = __(' Location ', 'hydraforms');
            foreach ($locationOptions as $key => $locationOption) {
                if (isset($options[$key]) && is_array($options[$key])) {
                    foreach ($options[$key] as $index => $term) {
                        $sublocationOptions[$index] = $term;
                    }
                }
            }
        }

        // third level enabled
        if ($levels > 2) {
            $itemSet->addField('select', array('sublocation', $widgetSettings['level_3_label']))
                ->setOptions($sublocationOptions)
                ->setOptionsClasses($classes)
                ->addAttribute('class', 'hierarchy-level-3 form-group');
        }
        if (!empty($widgetValues['items'])) {
            $itemSet->setValue($widgetValues['items'][0]);
        }
    }

    public function composeCondition($filterField, $conditionField, $condition, $value) {
        $metaArgs = array();

        if (isset($value[$condition->col]) && !empty($value[$condition->col])) {
            $metaArgs = array(
                'key' => $filterField->field_name . '_%_' . $condition->col,
                'compare' => '=',
                'value' => $value[$condition->col],
            );
        }

        return $metaArgs;
    }

    public function allowedConditions() {
        // range slider support only in between condition - obviously
        return array(
            'country' => array(
                'equals' => __('Equals', 'hydraforms'),
            ),
            'location' => array(
                'equals' => __('Equals', 'hydraforms'),
            ),
            'sublocation' => array(
                'equals' => __('Equals', 'hydraforms'),
            ),
        );
    }

    public function getSettingsForm($parentForm, \HydraFieldRecord $field) {
        $parentForm->addField('select', array('levels', __('Levels', 'hydraforms')))
            ->setOptions(array(1 => 1, 2 => 2, 3 => 3))
            ->setDefaultValue(3)
            ->setDescription(__('Number of nesting levels', 'hydraforms'));

        $parentForm->addField('text', array('level_1_label', __('Level 1 Label', 'hydraforms')))
            ->setDefaultValue('Level 1');
        $parentForm->addField('text', array('level_2_label', __('Level 2 Label', 'hydraforms')))
            ->setDefaultValue('Level 2');
        $parentForm->addField('text', array('level_3_label', __('Level 3 Label', 'hydraforms')))
            ->setDefaultValue('Level 3');

        parent::getSettingsForm($parentForm, $field);
        $parentForm->removeField('placeholder');
        $parentForm->removeField('prefix');
        $parentForm->removeField('suffix');

        $settingsValues = $this->getWidgetSettings();
        $parentForm->setValue($settingsValues);
    }

    public function getDefaultSettings() {
        return array(
            'level_1_label' => 'Level 1',
            'level_2_label' => 'Level 2',
            'level_3_label' => 'Level 3',
        );
    }

    /**
     * @param \HydraFieldRecord $fieldRecord
     * @param $post
     * @param $values
     */
    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['country'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        $terms = array();
        switch ($fieldRecord->field_type) {
            case 'hierarchy_select':
                $attributes = $fieldRecord->attributes;
                $vocabularyName = $attributes['taxonomy'];

                if (count($items)) {
                    foreach ($items['items'] as $item) {
                        $terms += $item;
                    }
                }
                break;
        }

        if (!$post) {
            return $items;
        }
        wp_set_post_terms($post->ID, $item, $vocabularyName);

        return $items;
    }

}


class HierarchySelectFormatter extends Formatter\Formatter {

    public function __construct() {
        $this->name = 'hierarchy_select_formatter';
    }

    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }

        $defManager = new Definitions\DefinitionManager();
        $definition = $defManager->createDefinition($view->field->field_type);

        $meta->options = $definition->getOptions($view->field, 0, TRUE, TRUE);

        $terms = get_terms($view->field->attributes['taxonomy'], array('get' => 'all'));

        foreach ($terms as $term) {
            $meta->terms[$term->term_id] = $term;
        }

        foreach ($items as $delta => $item) {
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        }

        return $output;
    }

    /**
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        $output = '';
        $indexes = array(
            'country',
            'location',
            'sublocation',
        );

        $options = $meta->options;
        $terms = $meta->terms;

        $output .= "<div class=\"field-item field-item-$delta\">";
        $output .= "<div class=field-value>";

        $locationsRender = array();

        foreach ($indexes as $index) {
            if (!isset($item[$index])) {
                continue;
            }

            $term_id = $item[$index];

            if (isset($options[$term_id])) {
                if (isset($settings['link_bool']) && $settings['link_bool']) {
                    $locationsRender[] = "<a href=\"" . get_term_link(
                            $terms[$term_id]
                        ) . "\">" . $options[$term_id] . "</a>";
                }
                else {
                    $locationsRender[] = $options[$term_id];
                }
            }
        }

        $output .= implode(', ', $locationsRender);
        $output .= "</div>";
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

        $parentElement->addField('checkbox', array('link_bool', __('Link to taxonomy page', 'hydraforms')))
            ->setDefaultValue(FALSE);

        $parentElement->removeField('suffix');
        $parentElement->removeField('prefix');
    }
}
