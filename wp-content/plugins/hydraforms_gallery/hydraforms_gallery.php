<?php
/**
 * Plugin Name: HydraForms Gallery
 * Description: Hydraforms gallery formatters and widgets
 * Version: 1.0.6
 */

$plugin_dir = basename(dirname(__FILE__));
define('HYDRA_GALLERY_URL', plugin_dir_url(__FILE__));

load_plugin_textdomain( 'hydraforms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// require hydra
require_once ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php';

// formatter definitions
function hydra_gallery_formatter_definition($definitions) {

    $definitions['flexslider_gallery'] = array(
        'name' => __('FlexSlider Gallery', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\FlexSliderFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => false,
        'no_filter' => true,
    );


    $definitions['carousel_gallery'] = array(
        'name' => __('Carousel Gallery', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\CarouselFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => true,
        'no_filter' => true,
    );

    $definitions['cycle_gallery'] = array(
        'name' => __('Cycle Gallery', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\CycleFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => false,
        'no_filter' => true,
    );

    $definitions['cycle_gallery_detail'] = array(
        'name' => __('Cycle Gallery Detail', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\DetailCycleFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => false,
        'no_filter' => true,
    );

    $definitions['bx_featured_cars'] = array(
        'name' => __('Bx Gallery Featured Cars', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\BxGalleryFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => false,
        'no_filter' => true,
    );

    $definitions['cycle_gallery_row'] = array(
        'name' => __('Row Gallery Best Deals', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gallery\RowCycleFormatter',
        'file' => plugin_dir_path(__FILE__) . 'Gallery.php',
        'field_types'=> array('image'),
        'group' => false,
        'no_filter' => true,
    );


    return $definitions;
}
add_filter('hydra_formatter_definition', 'hydra_gallery_formatter_definition', 10);

function pragmaticmates_gallery_load_scripts() {

    wp_register_script( 'cycle', HYDRA_GALLERY_URL.'/assets/cycle.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'cycle' );

    wp_register_script( 'gall', HYDRA_GALLERY_URL.'/assets/gall.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'gall' );

    wp_register_script( 'bx', HYDRA_GALLERY_URL . '/assets/jquery.bxslider.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'bx' );


}
add_action('wp_enqueue_scripts', 'pragmaticmates_gallery_load_scripts');
