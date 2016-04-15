<?php

/**
 * Settings definition callback
 * @param $definitions
 * @return mixed
 */
function realocation_settings_definition($definitions) {

    $definitions['analytics'] = array(
        'title' => __('Analytics', 'aviators'),
        'callback' => 'realocation_settings',
        'tabs' => array(
            'analytics' => array(
                'title' => __('Google analytics', 'aviators'),
            ),
        ),
    );
    return $definitions;
}
add_filter('aviators_settings_definition', 'realocation_settings_definition', 10, 1);

/**
 * Settings implementation
 * @param $form
 * @param $tab
 */
function realocation_settings($form, $tab) {
    switch ($tab) {
        case 'analytics':
            $form->addField('text', array('code', __('Tracking Code', 'aviators')))
                ->setAttribute('placeholder', 'UA-00000000-0');
            $form->addField('text', array('name', __('Domain', 'aviators')))
                ->setAttribute('placeholder', 'domainname.com');

            break;
    }
}

function realocation_ga_has_tracking() {
    if(!function_exists('aviators_settings_get')) {
        return false;
    }

    if(aviators_settings_get('analytics', 'analytics', 'code') && aviators_settings_get('analytics', 'analytics', 'name')) {
        return true;
    }

    return false;
}

function realocation_ga_get_tracking() {
    if(realocation_ga_has_tracking()) {
        return array(
            'code' => aviators_settings_get('analytics', 'analytics', 'code'),
            'name' => aviators_settings_get('analytics', 'analytics', 'name'),
        );
    }

    return false;
}