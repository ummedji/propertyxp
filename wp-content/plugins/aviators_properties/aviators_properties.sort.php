<?php


/**
 * Get sorting for property page
 * @param $page_id
 * @return \Hydra\Builder
 */
function aviators_properties_sort_get_form($page_id) {
    $settings = aviators_settings_get('property', $page_id);

    // @todo, at the moment doesnt support multiple sort on a page
    $sort = new \Hydra\Builder('sort');


    $return_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $sort->addField('hidden', array('return_url', $return_url));

    $sorting_options = _aviators_settings_get_sortable_options($settings['sort_options']);

    $sort->addField('select', array('orderby', __('Sort By', 'aviators')))
        ->setOptions($sorting_options)
        ->addAttribute('class', 'trigger-submit')
        ->setDefaultValue($settings['sort_default']);

    $sort->addField('select', array('order', __('Order', 'aviators')))
        ->setOptions(array('DESC' => __('Descending', 'aviators'), 'ASC' => __('Ascending', 'aviators')))
        ->setDefaultvalue($settings['sort_order_default'])
        ->addAttribute('class', 'trigger-submit');

    $sort->setValues($_GET);
    $sort->addOnSuccess('aviators_properties_sort_form_submit');
    $sort->build();

    return $sort;
}

/**
 * @param $form
 * @param $values
 */
function aviators_properties_sort_form_submit($form, $values) {
    $return_url = $values['return_url'];
    $url_params = parse_url($return_url);

    $query_params = array();

    if (isset($url_params['query'])) {
        parse_str($url_params['query'], $query_params);
        $return_url = str_replace('?' . $url_params['query'], '', $return_url);
    }

    $values = $form->clearSubmitValues($values);
    unset($values['return_url']);

    // merge
    $query_params = array_merge($query_params, $values);

    $return_url = $return_url . '?' . build_query($query_params);
    $form->setRedirect($return_url);
}


/**
 *
 */
function aviators_properties_sort_get_query_args($page_id, &$query_args) {

    $values = $_GET;
    if (!isset($values['orderby'])) {
        $values['orderby'] = aviators_settings_get('property', $page_id, 'sort_default');
    }

    if (!isset($values['order'])) {
        $values['order'] = aviators_settings_get('property', $page_id, 'sort_order_default');
    }

    $query_args['order'] = $values['order'];

    switch ($values['orderby']) {
        case 'title';
            $query_args['orderby'] = 'title';
            break;
        case 'created':
            $query_args['orderby'] = 'date';
            break;
        default:
            // hydra fields!
            $fieldModel = new HydraFieldModel();
            $field = $fieldModel->load($values['orderby']);

            if ($field) {
                $machine_name = $field->field_name . '_0_value';

                $query_args['orderby'] = 'meta_value_num';
                $query_args['meta_key'] = $machine_name;
            }

            break;
    }

}

function aviators_properties_filter_get_query_args($page_id, &$query_args) {
    $pager = aviators_settings_get('property', $page_id, 'pager');
    $contract_types = aviators_settings_get('property', $page_id, 'contract_types');
    $types = aviators_settings_get('property', $page_id, 'types');

    if (isset($contract_types) && $contract_types) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'contract_types',
            'terms' => array_keys($contract_types),
        );
    }

    if (isset($types) && $types) {

        $query_args['tax_query'][] = array(
            'taxonomy' => 'types',
            'terms' => array_keys($types),
        );
    }

    if ($pager) {
        $query_args['posts_per_page'] = $pager;
    }

}
function aviators_properties_get_isotope_filter_terms($taxonomy, $page_id) {
    $allowed_terms = aviators_settings_get('property', $page_id, $taxonomy);
    $results = array();

    $terms = get_terms($taxonomy);

    foreach($terms as $term) {
        if($allowed_terms && in_array($term->term_id, array_keys($allowed_terms))) {
            $results[$term->slug] = $term->name;
        } else {
            $results[$term->slug] = $term->name;
        }

    }


    return $results;
}

function aviators_properties_append_term_classes($taxonomy, $post_id = NULL) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $class = '';
    $terms = wp_get_post_terms($post_id, $taxonomy);
    if (count($terms)) {
        foreach ($terms as $term) {
            $class .= ' property-' . $term->slug;
        }
    }

    return $class;
}