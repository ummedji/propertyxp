<?php

/**
 * Plugin Name: HydraForms Advanced Filters
 * Description: Introduces advanced filtering widget for filters
 * Version: 1.0.3
 */

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'hydraforms_filters', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


if ( file_exists( ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php' ) ) {
    require_once ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php';
}

define('HYDRA_FILTER_DIR', plugin_dir_path(__FILE__));
define('HYDRA_FILTER_URL', plugin_dir_url(__FILE__));

function hydra_filters_widget_definition($definitions) {

    $definitions['range_slider'] = array(
        'name' => __('Range Slider', 'hydraforms'),
        'class' => 'Hydra\Widgets\RangeSliderWidget',
        'file' => plugin_dir_path(__FILE__) . 'widgets/RangeSlider.php',
        'field_types' => array('number'),
        'filter_only' => TRUE,
    );

    $definitions['carousel_select'] = array(
        'name' => __('Carousel Select', 'hydraforms'),
        'class' => 'Hydra\Widgets\CarouselSelectWidget',
        'file' => plugin_dir_path(__FILE__) . 'widgets/CarouselSelect.php',
        'field_types' => array('taxonomy'),
        'filter_only' => TRUE,
    );

    return $definitions;
}
add_filter('hydra_widget_definition', 'hydra_filters_widget_definition', 10);

/**
 * Register range slider related scripts and css
 */
function hydra_filters_register_scripts() {
    wp_register_script('ion_rangeslider', HYDRA_FILTER_URL . '/assets/range_slider/js/ion-rangeSlider/ion.rangeSlider.js', array('jquery', 'filters'), TRUE);
    wp_enqueue_script('ion_rangeslider');

    wp_enqueue_style('ion_rangeslider', HYDRA_FILTER_URL . '/assets/range_slider/css/ion.rangeSlider.css');
    wp_enqueue_style('ion_skinFlat', HYDRA_FILTER_URL . '/assets/range_slider/css/ion.rangeSlider.skinNice.css');

    wp_register_script('bxslider', HYDRA_FILTER_URL . '/assets/bxslider/jquery.bxslider.js', array('jquery'), TRUE);
    wp_enqueue_script('bxslider');

    wp_enqueue_style('bxslider', HYDRA_FILTER_URL . '/assets/bxslider/jquery.bxslider.css');

    wp_register_script('filters', HYDRA_FILTER_URL . '/assets/filters.js', array('jquery'), array(), TRUE);
    wp_enqueue_script('filters');
}

add_action('wp_enqueue_scripts', 'hydra_filters_register_scripts');
add_action('admin_init', 'hydra_filters_register_scripts');
