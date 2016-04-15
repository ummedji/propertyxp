<?php
/**
 * Plugin Name: HydraForms Google Map
 * Description: Provides definition, formatter and widgets to work with google map
 * Version: 1.0.6
 */

// @todo - for current purposes only definition and widget + not implement js as it comes from theme and there will be unnecessary duplication

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'hydraforms_gmap', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// require hydra
require_once ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php';

function hydra_gmap_field_definition($definitions) {
    $definitions['gmap'] = array(
        'name' => __('Map Position', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gmap\GmapDefinition',
        'file' => plugin_dir_path(__FILE__) . 'Gmap.php',
        'default_widget' => '',
        'default_formatter' => '',
    );

    return $definitions;
}
add_filter('hydra_field_definition', 'hydra_gmap_field_definition', 10);

// formatter definitions
function hydra_gmap_widget_definition($definitions) {
    $definitions['gmap'] = array(
        'name' => __('Map Selector', 'hydraforms'),
        'class' => 'Hydra\Plugins\Gmap\GmapWidget',
        'file' => plugin_dir_path(__FILE__) . 'Gmap.php',
        'field_types'=> array('gmap'),
        'group' => FALSE,
        'filter_only' => false,
        'no_filter' => true,
    );

    return $definitions;
}
add_filter('hydra_widget_definition', 'hydra_gmap_widget_definition', 10);