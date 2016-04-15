<?php

/**
 * Settings definition
 * @param $definitions
 * @return mixed
 */
function aviators_submission_settings_definition($definitions) {
    $definitions['submission'] = array(
        'title' => __('Submissions', 'aviators'),
        'callback' => 'aviators_submission_settings',
        'tabs' => array(
            'general' => array(
                'title' => __('General', 'aviators'),
            ),
            'tos' => array(
                'title' => __('Terms and Conditions', 'aviators'),
            )
        ),
    );

    return $definitions;
}

add_filter('aviators_settings_definition', 'aviators_submission_settings_definition', 10, 1);

/**
 * Default settings definition
 * @param $defaults
 * @return array
 */
function aviators_submission_settings_defaults($defaults) {
    $defaults['submission'] = array(
        'general' => array(
            'enabled_types' => array(
                'property' => 'property',
                'agent' => 'agent',
                'agency' => 'agency',
            ),
            'redirect' => home_url(),
        )
    );

    return $defaults;
}
add_filter('aviators_settings_defaults', 'aviators_submission_settings_defaults', 10, 1);

/**
 * Settings form definitions
 * @param $form
 * @param $tab
 */
function aviators_submission_settings($form, $tab) {
    switch ($tab) {
        case 'general':
            $options = aviators_submission_get_all_submission_types();

            $enabled_types = aviators_settings_get('submission', 'general', 'enabled_types');
            foreach ($enabled_types as $type => $title) {
                if (!aviators_submission_check_submission_type_dependencies($type)) {
                    $type_name = $options[$type];
                    $message = "<div class=\"alert alert-warning\">";
                    $message .= sprintf('%s does <strong>NOT</strong> meet the requirements for frontend submission. Please ensure you have <strong>pages</strong> with templates <strong>%s</strong> and <strong>%s</strong> created.',
                        $type_name, $type_name . ' Submission Form', $type_name . ' Submission Index');
                    $message .= "</div><br />";

                    $form->addField('markup', array('message_type', $message));
                }
            }

            $form->addField('checkboxes', array('enabled_types', __('Frontend Submission Types', 'aviators')))
                ->setOptions($options);

            $form->addField('select', array('submission_index', __('Default active Tab', 'aviators')))
                ->setOptions($enabled_types);

            $form->addField('checkbox', array('display_link', __('Display Link', 'aviators')));

            $form->addField('text', array('redirect', __('Redirect Path', 'aviators')))
                ->setDescription(__('Redirect url when user has not permission to access', 'aviators'));

            break;
        case 'tos':
            $options = aviators_submission_get_all_submission_types();
            $form->addField('checkboxes', array('enabled_tos', __('Enable Terms and Conditions', 'aviators')))
                ->setOptions($options);

            $enabled_types = aviators_settings_get('submission', 'tos', 'enabled_tos');

            $page_options = array();
            $pages = get_posts(array('post_type' => 'page'));

            foreach ($pages as $page) {
                $page_options[$page->ID] = $page->post_title;
            }

            if ($enabled_types) {
                foreach ($enabled_types as $index => $enabled_type) {
                    $form->addField('select', array($index, $options[$enabled_type]))
                        ->setOptions($page_options)
                        ->setDescription(__('Page containing terms and conditions text', 'aviators'));
                }
            }
            break;
        default:
            break;
    }
}

