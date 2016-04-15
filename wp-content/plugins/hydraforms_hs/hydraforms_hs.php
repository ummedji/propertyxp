<?php
/**
 * Plugin Name: HydraForms Hierarchical Select
 * Description: Hierarchy Selector Field
 * Version: 1.0.7
 */

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'hydraforms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// require hydra
require_once ABSPATH . '/wp-content/plugins/hydraforms/hydraforms.php';

function hydra_hs_field_definition($definitions) {
    $definitions['hierarchy_select'] = array(
        'name' => __('Hierarchical Select', 'hydraforms'),
        'class' => 'Hydra\Plugins\HierarchySelect\TaxonomyHierarchyDefinition',
        'file' => plugin_dir_path(__FILE__) . 'HierarchySelect.php',
        'default_widget' => 'hierarchy_select_widget',
        'default_formatter' => 'hierarchy_select_formatter'
    );

    return $definitions;
}
add_filter('hydra_field_definition', 'hydra_hs_field_definition', 10);


function hydra_hs_widget_definition($definitions) {
    $definitions['hierarchy_select_widget'] = array(
        'name' => __('Hierarchical select', 'hydraforms'),
        'class' => 'Hydra\Plugins\HierarchySelect\HierarchySelectWidget',
        'file' => plugin_dir_path(__FILE__) . 'HierarchySelect.php',
        'field_types' => array('hierarchy_select'),
        'no_filter' => true,
        'filer_only' => false,
    );

    return $definitions;
}
add_filter('hydra_widget_definition', 'hydra_hs_widget_definition', 10);


function hydra_hs_formatter_definition($definitions) {
    $definitions['hierarchy_select_formatter'] = array(
        'name' => __('Taxonomy Hierarchy'),
        'class' => 'Hydra\Plugins\HierarchySelect\HierarchySelectFormatter',
        'file' => plugin_dir_path(__FILE__) . 'HierarchySelect.php',
        'field_types'=> array('hierarchy_select'),
        'group' => FALSE,
    );

    return $definitions;
}
add_filter('hydra_formatter_definition', 'hydra_hs_formatter_definition', 10);
