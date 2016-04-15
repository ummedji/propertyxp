<?php

/**
 * Settings definition callback
 * @param $definitions
 * @return mixed
 */
function aviators_agent_settings_definition($definitions) {
    $definitions['agent'] = array(
        'title' => __('Agents', 'aviators'),
        'callback' => 'aviators_agent_settings',
        'tabs' => array(
            'archive' => array(
                'title' => __('Archive', 'aviators'),
            ),
        ),
    );

    return $definitions;
}
add_filter('aviators_settings_definition', 'aviators_agent_settings_definition', 10, 1);

/**
 * Property defaults
 * @param $defaults
 * @return mixed
 */
function aviators_agent_settings_defaults($defaults) {
    $display_options = aviators_settings_get_agent_display_options();

    $display_keys = array_keys($display_options);
    $default_display_option = reset($display_keys);

    $defaults['agent'] = array(
        'archive' => array(
            'title' => __('Agents', 'aviators'),
            'display_type' => $default_display_option,
        ),
    );

    return $defaults;
}
add_filter('aviators_settings_defaults', 'aviators_agent_settings_defaults', 10, 1);

/**
 * Settings implementation
 * @param $form
 * @param $tab
 */
function aviators_agent_settings($form, $tab) {
    switch($tab) {
        case 'archive':
            $form->addField('text', array('title', __('Archive title', 'aviators')))
                ->setDefaultValue(__('Properties', 'aviators'));

            $form->addField('select', array('display_type', __('Default Archive display', 'aviators')))
                ->setOptions(aviators_settings_get_agent_display_options());
            break;
    }
}

function aviators_settings_get_agent_display_options() {
    $db = new \HydraViewModel();
    $displayTypes = $db->loadByPostType('agent');
    $options = array();

    foreach($displayTypes as $displayType) {
        $options[$displayType->name] = $displayType->label;
    }

    return $options;
}

function _aviators_settings_agent_display_items_mapping() {
    $mapping = array(
        'grid' => 3,
        'row' => 1,
        'detail' => 1,
    );

    return $mapping;
}