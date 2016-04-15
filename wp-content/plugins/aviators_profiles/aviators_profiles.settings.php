<?php

function aviators_profile_settings_definition($definitions) {
    $definitions['profile'] = array(
        'title' => __('Profile & Registration', 'aviators'),
        'callback' => 'aviators_profile_settings',
        'tabs' => array(
            'register' => array(
                'title' => __('Profile & Registration', 'aviators'),
            ),
        ),
    );

    return $definitions;
}
add_filter('aviators_settings_definition', 'aviators_profile_settings_definition', 10, 1);

function aviators_profile_settings_defaults($defaults) {
    // @todo
    $defaults['profile'] = array(
        'register' => array(
            'register' => 1,
            'disabled_fields' => array(),
            'password' => 1,
        ),
    );

    return $defaults;
}
add_filter('aviators_settings_defaults', 'aviators_profile_settings_defaults', 10, 1);

function aviators_profile_settings($form, $tab) {
    switch($tab) {
        case 'register':
            $form->addField('checkbox', array('register', __('Registration profile', 'aviators')))
                ->setDescription(__('Include profile form as part of registration', 'aviators'));

            $form->addField('checkbox', array('password', __('Enable password', 'aviators')))
                ->setDescription(__('Include password select as part of registration', 'aviators'));

            $options = aviators_profile_field_options();
            $form->addField('checkboxes', array('disabled_fields', __('Exclude from registration form', 'aviators')))
                ->setOptions($options);

            break;
    }
}


function aviators_profile_field_options() {
    $dbModel = new HydraFieldModel();
    $options = $dbModel->loadByPostTypeOptions('profile', 'field_name');
    return $options;
}