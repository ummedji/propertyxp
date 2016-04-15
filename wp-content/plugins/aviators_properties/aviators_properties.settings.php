<?php

function aviators_properties_get_supported_pages() {
    $supported_pages = array();
    $supported_pages = apply_filters('aviators_property_supported_page_type', $supported_pages);
    return $supported_pages;
}

/**
 * Settings definition callback
 * @param $definitions
 * @return mixed
 */
function aviators_property_settings_definition($definitions) {
    $definitions['property'] = array(
        'title' => __('Properties', 'aviators'),
        'callback' => 'aviators_property_settings',
        'tabs' => array(
            'archive' => array(
                'title' => __('Archive', 'aviators'),
            ),
        ),
    );

    $supported_pages = aviators_properties_get_supported_pages();
    if (!count($supported_pages)) {
        return $definitions;
    }

    foreach ($supported_pages as $page_id => $page_title) {
        $definitions['property']['tabs'][$page_id] = array(
            'title' => $page_title
        );
    }

    return $definitions;
}

add_filter('aviators_settings_definition', 'aviators_property_settings_definition', 10, 1);

/**
 * Property defaults
 * @param $defaults
 * @return mixed
 */
function aviators_property_settings_defaults($defaults) {
    $display_options = aviators_settings_get_property_display_options();
    $display_keys = array_keys($display_options);
    $default_display_option = reset($display_keys);

    $defaults['property'] = array(
        'archive' => array(
            'title' => __('Properties', 'aviators'),
            'display_type' => $default_display_option,
        ),
    );

    return $defaults;
}

add_filter('aviators_settings_defaults', 'aviators_property_settings_defaults', 10, 1);

/**
 * Settings implementation
 * @param $form
 * @param $tab
 */
function aviators_property_settings($form, $tab) {
    $supported_pages = aviators_properties_get_supported_pages();

    switch ($tab) {
        case 'archive':
            $form->addField('text', array('title', __('Archive title', 'aviators')))
                ->setDefaultValue(__('Properties', 'aviators'));

            $form->addField('select', array('display_type', __('Default Archive display', 'aviators')))
                ->setOptions(aviators_settings_get_property_display_options());

            _aviators_settings_sorting_settings($form);
            break;
        default:
            if (in_array($tab, array_keys($supported_pages))) {
                $options = array();

                for ($i = 1; $i <= 30; $i++) {
                    $options[$i] = $i;
                }

                $markup = "<a href=" . get_permalink($tab) . ">" . __('Go to page display', 'aviators') . "</a>";
                $form->addField('markup', array('markup', $markup));

                $form->addField('checkbox', array('disable_sidebar', __('Disable sidebar', 'aviators')));

                $form->addField('select', array('display_type', __('Display Style', 'aviators')))
                     ->setOptions(array(
                        'grid' => __('Grid', 'aviators'),
                        'row' => __('Row', 'aviators'),
                        'isotope' => __('Isotope', 'aviators'),
                    ));

                $form->addField('select', array('isotope_taxonomy', __('Isotope Taxonomy Filter', 'aviators')))
                    ->setOptions(
                        array('types' => __('Types', 'aviators'), 'contract_types' => __('Contract Types', 'aviators'))
                    );

                $form->addField('checkbox', array('display_pager', __('Display pager', 'aviators')))
                    ->setDefaultValue(1);

                $form->addField('select', array('pager', __('Items per Page', 'aviators')))
                    ->setOptions($options)
                    ->setDefaultValue(10);

                $terms = get_terms(array('types', 'contract_types'), array('get' => 'all'));

                $options = _aviators_properties_taxonomy_term_options('types', $terms);
                $form->addField('checkboxes', array('types', __('Filter by Type', 'aviators')))
                    ->setOptions($options);


                $options = _aviators_properties_taxonomy_term_options('contract_types', $terms);
                $form->addField('checkboxes', array('contract_types', __('Filter by Contract Type', 'aviators')))
                    ->setOptions($options);

                _aviators_settings_sorting_settings($form);

            }
            break;
    }
}

function _aviators_settings_sorting_settings($form) {

    $sortableOptions = _aviators_settings_get_sortable_options();
    $form->addField('checkbox', array('sort', __('Include Sorting', 'aviators')));
    $form->addField('checkboxes', array('sort_options', __('Sorting fields', 'aviators')))
        ->setOptions($sortableOptions);

    $form->addField('select', array('sort_default', __('Default sort by', 'aviators')))
        ->setOptions($sortableOptions);

    $form->addField('select', array('sort_order_default', __('Default sort order by', 'aviators')))
        ->setOptions(array('ASC' => __('Ascending', 'aviators'), 'DESC' => __('Descending', 'aviators')));
}
/**
 * Simple helper that provides available field options to sort by
 * @param $allowed
 * @return array
 */
function _aviators_settings_get_sortable_options($allowed = array()) {
    $fieldModel = new HydraFieldModel();

    $sortableOptions = array(
        'title' => __('Title', 'aviators'),
        'created' => __('Date', 'aviators')
    );
    $sortableOptions += $fieldModel->loadOptionsByFieldType('number', 'property');

    if(count($allowed)) {
        $sortableOptionsFiltered = array();

        foreach($sortableOptions as $key => $sortableOption) {
            if(in_array($key, $allowed)) {
                $sortableOptionsFiltered[$key] = $sortableOption;
            }
        }

        return $sortableOptionsFiltered;
    }

    return $sortableOptions;
}

function aviators_settings_get_property_display_options() {
    $db = new \HydraViewModel();
    $displayTypes = $db->loadByPostType('agent');
    $options = array();

    foreach ($displayTypes as $displayType) {
        $options[$displayType->name] = $displayType->label;
    }

    return $options;
}

function _aviators_properties_taxonomy_term_options($vocabulary, $terms) {
    $options = array();

    if (is_array($terms) && count($terms)) {
        foreach ($terms as $term) {
            if ($term->taxonomy == $vocabulary) {
                $options[$term->term_id] = $term->name;
            }
        }
    }

    return $options;
}