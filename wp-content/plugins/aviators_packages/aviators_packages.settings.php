<?php

function aviators_package_get_supported_pages() {
    $supported_pages = array();
    $supported_pages = apply_filters('aviators_package_supported_page_type', $supported_pages);
    return $supported_pages;
}


function aviators_packages_settings_definition($definitions) {
    $definitions['package'] = array(
        'title' => __('Packages', 'aviators'),
        'callback' => 'aviators_packages_settings',
        'tabs' => array(
            'archive' => array(
                'title' => __('Archive', 'aviators'),
            )
        ),
    );

    $supported_pages = aviators_package_get_supported_pages();
    if (!count($supported_pages)) {
        return $definitions;
    }

    foreach ($supported_pages as $page_id => $page_title) {
        $definitions['package']['tabs'][$page_id] = array(
            'title' => $page_title
        );
    }

    return $definitions;
}

add_filter('aviators_settings_definition', 'aviators_packages_settings_definition', 10, 1);


function aviators_packages_settings($form, $tab) {
    $supported_pages = aviators_package_get_supported_pages();

    switch ($tab) {
        case 'archive':
            $form->addField('text', array('title', __('Archive title', 'aviators')))
                ->setDefaultValue(__('Packages', 'aviators'));

            $form->addField('select', array('number', __('Number of packages in one line', 'aviators')))
                ->setOptions(array(3=>3, 4=>4));

            $form->addField('checkbox', array('merged', __('Merged', 'aviators')))
                ->setDescription(__('If checked, there will be no space between packages', 'aviators'));

            $fieldset = $form->addField('fieldset', array('weight', __('Weight', 'aviators')));
            $fieldset->addDecorator('table');

            $packages = get_posts(array('post_type' => 'package', 'posts_per_page' => -1));
            foreach($packages as $package) {
                $fieldset->addField('select', array($package->ID, $package->post_title . ' -  Order'))
                    ->setOptions(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9));
            }
            break;
        default:
            if(in_array($tab, array_keys($supported_pages))) {
                $markup = "<a href=" . get_permalink($tab) . ">" . __('Go to page display', 'aviators') . "</a>";
                $form->addField('markup', array('markup', $markup));

                $form->addField('select', array('title_position', __('Title Position')))
                    ->setOptions(array('left' => 'Left', 'right' => 'Right', 'center' => 'Center'));

                $form->addField('checkbox', array('disable_sidebar', __('Disable sidebar', 'aviators')));

                $form->addField('select', array('number', __('Number of packages in one line', 'aviators')))
                    ->setOptions(array(3=>3, 4=>4));

                $form->addField('checkbox', array('merged', __('Merged', 'aviators')))
                    ->setDescription(__('If checked, there will be no space between packages', 'aviators'));

                $fieldset = $form->addField('fieldset', array('weight', __('Weight', 'aviators')));
                $fieldset->addDecorator('table');

                $packages = get_posts(array('post_type' => 'package', 'posts_per_page' => -1));
                foreach($packages as $package) {
                    $fieldset->addField('select', array($package->ID, $package->post_title . ' -  Order'))
                        ->setOptions(array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9));
                }

            }
            break;
    }
}