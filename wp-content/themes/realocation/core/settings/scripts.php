<?php

/**
 * Enqueue theme scripts
 */
function aviators_enqueue_files() {
    wp_register_style( 'fontawesome', get_template_directory_uri() . '/assets/libraries/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style( 'fontawesome' );

    wp_register_style( 'raleway', 'http://fonts.googleapis.com/css?family=Raleway:400,700' );
    wp_enqueue_style( 'raleway' );

    // FlexSlider
    wp_register_script( 'flexslider', get_template_directory_uri() . '/assets/libraries/flexslider/jquery.flexslider.js', array('jquery'), '', true );
    wp_enqueue_script( 'flexslider' );
    wp_register_style( 'flexslider', get_template_directory_uri() . '/assets/libraries/flexslider/flexslider.css');
    wp_enqueue_style( 'flexslider' );

    // Primary theme style file
    $css = get_template_directory_uri() . '/assets/css/realocation.css';
    if ( get_theme_mod('general_color', '') != '') {
        $css = get_template_directory_uri() . '/assets/css/variants/' . get_theme_mod('general_color'). '.css';
    }

    wp_register_style( 'realocation',  $css);
    wp_enqueue_style( 'realocation' );


    // Enqueue style.css of the theme
    wp_register_style( 'style', get_stylesheet_directory_uri(). '/style.css' );                                                        
    wp_enqueue_style( 'style' );

    wp_register_style( 'overrides', get_stylesheet_directory_uri(). '/overrides.css' );
    wp_enqueue_style( 'overrides' );


    // JavaScript
    wp_register_script( 'googlemaps3', 'http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true', array('jquery'), '', true);
    wp_register_script( 'infobox', get_template_directory_uri() . '/assets/js/gmap3.infobox.js', array('jquery'), '', true );
    wp_register_script( 'clusterer', get_template_directory_uri() . '/assets/js/gmap3.clusterer.js', array('jquery'), '', true );

    wp_register_script( 'autosize', get_template_directory_uri() . '/assets/js/jquery.autosize.js');
    wp_enqueue_script( 'autosize' );

    wp_register_script( 'imagesloaded', get_template_directory_uri() . '/assets/js/imagesloaded.js');
    wp_enqueue_script( 'imagesloaded' );

    wp_register_script( 'appear', get_template_directory_uri() . '/assets/js/jquery.appear.js');
    wp_enqueue_script( 'appear' );

    wp_register_script( 'map', get_template_directory_uri() . '/assets/js/map.js');
    wp_enqueue_script( 'map' );

    wp_register_script( 'realocation', get_template_directory_uri() . '/assets/js/realocation.js', array('jquery'), '', true );
    wp_enqueue_script( 'realocation' );

    wp_register_script('bootstrap-transition', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js');
    wp_enqueue_script('bootstrap-transition');

    wp_register_script('bootstrap-collapse', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js');
    wp_enqueue_script('bootstrap-collapse');

    wp_register_script('bootstrap-carousel', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/vendor/assets/javascripts/bootstrap/carousel.js');
    wp_enqueue_script('bootstrap-carousel');

    wp_register_script('bootstrap-modal', get_template_directory_uri() . '/assets/libraries/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js');
    wp_enqueue_script('bootstrap-modal');

    wp_register_script('isotope', get_template_directory_uri() . '/assets/libraries/isotope/jquery.isotope.js');
    wp_enqueue_script('isotope');
}

add_action('wp_enqueue_scripts', 'aviators_enqueue_files');