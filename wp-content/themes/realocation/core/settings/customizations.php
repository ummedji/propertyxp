<?php

function aviators_get_active_map_style() {
    $style = get_theme_mod('general_map_style');

    $styles = array(
        1 => '[{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}]',
        2 => '[{"stylers":[{"visibility":"off"}]},{"featureType":"road","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"road.arterial","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"road.highway","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"landscape","stylers":[{"visibility":"on"},{"color":"#f3f4f4"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#7fc8ed"}]},{},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#83cead"}]},{"elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"weight":0.9},{"visibility":"off"}]}]',
        3 => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]}]',
        4 => '[{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}]',
        5 => '[{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]},{},{"featureType":"road.highway","stylers":[{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road"},{},{"featureType":"landscape","stylers":[{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]}]',
        6 => '[{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"},{"lightness":20}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#a1cdfc"},{"saturation":30},{"lightness":49}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#f49935"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#fad959"}]}]',
        7 => '[{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]',
        8 => '[{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#b5cbe4"}]},{"featureType":"landscape","stylers":[{"color":"#efefef"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#83a5b0"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bdcdd3"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e3eed3"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]',
        9 => '[{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]',
    );

    if (isset($_GET['map_style'])) {
        $style = $_GET['map_style'];
    }

    return isset($styles[$style]) ? $styles[$style] : FALSE;
}

function aviators_customizations($wp_customize) {

    /****************************************************************************
     * GENERAL
     ****************************************************************************/
    $wp_customize->add_section('general', array('title' => __('General', 'aviators'), 'priority' => 0));

    $wp_customize->add_setting('general_map_style', array('default' => 'wide'));
    $wp_customize->add_control('general_map_style', array(
        'type' => 'select',
        'label' => __('Map Style', 'aviators'),
        'section' => 'general',
        'settings' => 'general_map_style',
        'priority' => 0,
        'choices' => array(
            '' => __('Default Map Style', 'aviators'),
            '1' => __('Style 1', 'aviators'),
            '2' => __('Style 2', 'aviators'),
            '3' => __('Style 3', 'aviators'),
            '4' => __('Style 4', 'aviators'),
            '5' => __('Style 5', 'aviators'),
            '6' => __('Style 6', 'aviators'),
            '7' => __('Style 7', 'aviators'),
            '8' => __('Style 8', 'aviators'),
            '9' => __('Style 9', 'aviators'),
        )
    ));

    $wp_customize->add_setting('general_color', array('default' => ''));
    $wp_customize->add_control('general_color', array(
        'type' => 'select',
        'label' => __('Color', 'aviators'),
        'section' => 'general',
        'settings' => 'general_color',
        'priority' => 0,
        'choices' => array(
            '' => __('Default', 'aviators'),
            'red' => __('Red', 'aviators'),
            'pink' => __('Pink', 'aviators'),
            'blue' => __('Blue', 'aviators'),
            'green' => __('Green', 'aviators'),
            'cyan' => __('Cyan', 'aviators'),
            'purple' => __('Purple', 'aviators'),
            'orange' => __('Orange', 'aviators'),
            'brown' => __('Brown', 'aviators'),
        )
    ));

    // Logo
    $wp_customize->add_setting('general_logo', array('default' => NULL));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'general_logo', array(
        'label' => __('Logo', 'aviators'),
        'section' => 'general',
        'settings' => 'general_logo',
        'priority' => 0
    )));

    // Layout
    $wp_customize->add_setting('general_layout', array('default' => 'wide'));
    $wp_customize->add_control('general_layout', array(
        'type' => 'select',
        'label' => __('Layout', 'aviators'),
        'section' => 'general',
        'settings' => 'general_layout',
        'priority' => 0,
        'choices' => array(
            'layout-wide' => __('Wide', 'aviators'),
            'layout-boxed' => __('Boxed', 'aviators'),
        )
    ));

    // Header
    $wp_customize->add_setting('header_variant', array('default' => 'header-dark'));
    $wp_customize->add_control('header_variant', array(
        'type' => 'select',
        'label' => __('Header Variant', 'aviators'),
        'section' => 'general',
        'settings' => 'header_variant',
        'priority' => 0,
        'choices' => array(
            'header-dark' => __('Dark', 'aviators'),
            'header-light' => __('Light', 'aviators'),
        )
    ));

    // Map
    $wp_customize->add_setting('map_navigation_variant', array('default' => 'map-navigation-dark'));
    $wp_customize->add_control('map_navigation_variant', array(
        'type' => 'select',
        'label' => __('Map Filter Variant', 'aviators'),
        'section' => 'general',
        'settings' => 'map_navigation_variant',
        'priority' => 0,
        'choices' => array(
            'map-navigation-dark' => __('Dark', 'aviators'),
            'map-navigation-light' => __('Light', 'aviators'),
        )
    ));

    // Footer
    $wp_customize->add_setting('footer_variant', array('default' => 'footer-dark'));
    $wp_customize->add_control('footer_variant', array(
        'type' => 'select',
        'label' => __('Footer Variant', 'aviators'),
        'section' => 'general',
        'settings' => 'footer_variant',
        'priority' => 0,
        'choices' => array(
            'footer-dark' => __('Dark', 'aviators'),
            'footer-light' => __('Light', 'aviators'),
        )
    ));

    // Background pattern
    $wp_customize->add_setting('background_pattern', array('default' => 'pattern-cloth-alike'));
    $wp_customize->add_control('background_pattern', array(
        'type' => 'select',
        'label' => __('Background Pattern', 'aviators'),
        'section' => 'general',
        'settings' => 'background_pattern',
        'priority' => 0,
        'choices' => array(
            "pattern-cloth-alike" => "cloth-alike",
            "pattern-corrugation" => "corrugation",
            "pattern-diagonal-noise" => "diagonal-noise",
            "pattern-dust" => "dust",
            "pattern-fabric-plaid" => "fabric-plaid",
            "pattern-farmer" => "farmer",
            "pattern-grid-noise" => "grid-noise",
            "pattern-lghtmesh" => "lghtmesh",
            "pattern-pw-maze-white" => "pw-maze-white",
            "pattern-none" => "none",
            "pattern-cloth-alike-dark" => "cloth-alike",
            "pattern-corrugation-dark" => "corrugation",
            "pattern-diagonal-noise-dark" => "diagonal-noise",
            "pattern-dust-dark" => "dust",
            "pattern-fabric-plaid-dark" => "fabric-plaid",
            "pattern-farmer-dark" => "farmer",
            "pattern-grid-noise-dark" => "grid-noise",
            "pattern-lghtmesh-dark" => "lghtmesh",
            "pattern-pw-maze-white-dark" => "pw-maze-white",
            "pattern-none-dark" => "none"
        )
    ));

    // Enable customizer
    $wp_customize->add_setting('general_enable_customizer', array('default' => NULL));
    $wp_customize->add_control('general_enable_customizer', array(
        'type' => 'checkbox',
        'label' => __('Enable Customizer', 'aviators'),
        'section' => 'general',
        'settings' => 'general_enable_customizer',
        'priority' => 0
    ));

    // Enable top bar
    $wp_customize->add_setting('general_topbar_is_enabled', array('default' => NULL));
    $wp_customize->add_control('general_topbar_is_enabled', array(
        'type' => 'checkbox',
        'label' => __('Enable Topbar', 'aviators'),
        'section' => 'general',
        'settings' => 'general_topbar_is_enabled',
        'priority' => 0
    ));
}


add_action('customize_register', 'aviators_customizations');

function aviators_customizations_script() {
    wp_enqueue_script('customizations', get_template_directory_uri() . '/assets/js/customizations.js',
        array('jquery', 'customize-preview'), '', TRUE
    );
}

add_action('customize_preview_init', 'aviators_customizations_script');

