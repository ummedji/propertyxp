<?php

/**
 * Register plugins
 */
add_action( 'tgmpa_register', 'aviators_register_required_plugins' );


function aviators_register_required_plugins() {
    $plugins = array(
        array(
            'name'                  => 'Revolution Slider',
            'slug'                  => 'revslider',
            'source'                => get_stylesheet_directory() . '/core/plugins/revslider.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'HydraForms',
            'slug'                  => 'hydraforms',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '0.8.3',
        ),
        array(
            'name'                  => 'HydraForms Filters',
            'slug'                  => 'hydraforms_filters',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms_filters.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.3',
        ),
        array(
            'name'                  => 'HydraForms Gallery',
            'slug'                  => 'hydraforms_gallery',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms_gallery.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.5',
        ),
        array(
            'name'                  => 'HydraForms Social',
            'slug'                  => 'hydraforms_social',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms_social.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.7',
        ),
        array(
            'name'                  => 'HydraForms Hierarchy Select',
            'slug'                  => 'hydraforms_hs',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms_hs.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.8',
        ),
        array(
            'name'                  => 'HydraForms Gmap',
            'slug'                  => 'hydraforms_gmap',
            'source'                => get_stylesheet_directory() . '/core/plugins/hydraforms_gmap.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.5',
        ),
        array(
            'name'                  => 'Aviators Settings',
            'slug'                  => 'aviators_settings',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_settings.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.1.0',
        ),
        array(
            'name'                  => 'Aviators Widgets',
            'slug'                  => 'aviators_widgets',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_widgets.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Aviators Taxonomy',
            'slug'                  => 'aviators_taxonomy',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_taxonomy.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.1',
        ),
        array(
            'name'                  => 'Aviators Properties',
            'slug'                  => 'aviators_properties',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_properties.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.2.4',
        ),
        array(
            'name'                  => 'Aviators Agencies',
            'slug'                  => 'aviators_agencies',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_agencies.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.1.1',
        ),

        array(
            'name'                  => 'Aviators Agents',
            'slug'                  => 'aviators_agents',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_agents.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.1.1',
        ),

        array(
            'name'                  => 'Aviators Packages',
            'slug'                  => 'aviators_packages',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_packages.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.1',
        ),

        array(
            'name'                  => 'Aviators Transactions',
            'slug'                  => 'aviators_transactions',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_transactions.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.0',
        ),
        array(
            'name'                  => 'Aviators Submissions',
            'slug'                  => 'aviators_submission',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_submission.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.1.1',
        ),
        array(
            'name'                  => 'Aviators Profile',
            'slug'                  => 'aviators_profiles',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_profiles.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.1.0'
        ),
        array(
            'name'                  => 'Aviators Calculator',
            'slug'                  => 'aviators_calculator',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_calculator.zip',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.0'
        ),
        array(
            'name'                  => 'Aviators Landlords',
            'slug'                  => 'aviators_landlords',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_landlords.zip',
            'required'              => false,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.0',
        ),
        array(
            'name'                  => 'Aviators Utils',
            'slug'                  => 'aviators_utils',
            'source'                => get_stylesheet_directory() . '/core/plugins/aviators_utils.zip',
            'required'              => false,
            'force_activation'      => true,
            'force_deactivation'    => false,
            'version'               => '1.0.0',
        ),
        array(
            'name'      => 'Wordpress Importer',
            'slug'      => 'wordpress-importer',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),
        array(
            'name'      => 'Widget Data - Setting Import/Export Plugin',
            'slug'      => 'widget-settings-importexport',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),

        array(
            'name'      => 'Breadcrumb NavXT',
            'slug'      => 'breadcrumb-navxt',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),
        array(
            'name'      => 'Widget Logic',
            'slug'      => 'widget-logic',
            'required'              => true,
            'force_activation'      => true,
            'force_deactivation'    => false,
        ),
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'              => false,
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
    );

    $config = array(
        'domain'            => 'aviators',          // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                          // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',                // Default parent menu slug
        'parent_url_slug'   => 'themes.php',                // Default parent URL slug
        'menu'              => 'install-required-plugins',  // Menu slug
        'has_notices'       => true,                        // Show admin notices or not
        'is_automatic'      => true,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', 'aviators' ),
            'menu_title'                                => __( 'Install Plugins', 'aviators' ),
            'installing'                                => __( 'Installing Plugin: %s', 'aviators' ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', 'aviators' ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', 'aviators' ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', 'aviators' ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'aviators' ), // %1$s = dashboard link
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );
}
