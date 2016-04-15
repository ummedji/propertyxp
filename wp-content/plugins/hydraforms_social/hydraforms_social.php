<?php
/**
 * Plugin Name: HydraForms Social
 * Description: Social links integration
 * Version: 1.0.8
 */

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'hydraforms_social', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// require hydra
require_once ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php';

function hydra_social_field_definition($definitions) {
    $definitions['social_links'] = array(
        'name' => __('Social Links', 'hydraforms'),
        'class' => 'Hydra\Plugins\Social\SocialLinksDefinition',
        'file' => plugin_dir_path(__FILE__) . 'SocialLinks.php',
        'default_widget' => 'social_links_widget',
        'default_formatter' => 'social_links_formatter'
    );

    return $definitions;
}
add_filter('hydra_field_definition', 'hydra_social_field_definition', 10);


function hydra_social_widget_definition($definitions) {
    $definitions['social_links_widget'] = array(
        'name' => __('Social links', 'hydraforms'),
        'class' => 'Hydra\Plugins\Social\SocialLinksWidget',
        'file' => plugin_dir_path(__FILE__) . 'SocialLinks.php',
        'field_types' => array('social_links'),
        'no_filter' => true,
        'filer_only' => false,
    );

    return $definitions;
}
add_filter('hydra_widget_definition', 'hydra_social_widget_definition', 10);


function hydra_social_formatter_definition($definitions) {
    $definitions['social_links_formatter'] = array(
        'name' => __('SocialLinks'),
        'class' => 'Hydra\Plugins\Social\SocialLinksFormatter',
        'file' => plugin_dir_path(__FILE__) . 'SocialLinks.php',
        'field_types'=> array('social_links'),
        'group' => FALSE,
    );

    return $definitions;
}
add_filter('hydra_formatter_definition', 'hydra_social_formatter_definition', 10);