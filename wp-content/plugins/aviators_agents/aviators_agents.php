<?php
/*
Plugin Name:    Aviators Agents
Description:    Agency
Version:        1.1.1
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once ABSPATH . 'wp-content/plugins/aviators_widgets/widgets/generic.php';

require_once 'widgets/agents.php';
require_once 'aviators_agents.settings.php';
require_once 'aviators_agents.submission.php';

/**
 * Custom post type definition call
 */
add_action( 'init', 'aviators_agent_create_post_type' );

function aviators_agent_create_post_type() {
  $labels = array(
    'name'               => __( 'Agents', 'aviators' ),
    'singular_name'      => __( 'Agent', 'aviators' ),
    'add_new'            => __( 'Add New Agent', 'aviators' ),
    'add_new_item'       => __( 'Add New Agent', 'aviators' ),
    'edit_item'          => __( 'Edit Agent', 'aviators' ),
    'new_item'           => __( 'New Agent', 'aviators' ),
    'all_items'          => __( 'All Agent', 'aviators' ),
    'view_item'          => __( 'View Agent', 'aviators' ),
    'search_items'       => __( 'Search Agent', 'aviators' ),
    'not_found'          => __( 'No agents found', 'aviators' ),
    'not_found_in_trash' => __( 'No agents found in Trash', 'aviators' ),
    'parent_item_colon'  => '',
    'menu_name'          => __( 'Agents', 'aviators' ),
  );

  register_post_type( 'agent',
    array(
      'labels'        => $labels,
      'supports'      => array( 'title', 'editor', 'thumbnail', ),
      'public'        => true,
      'show_ui'       => true,
      'has_archive'   => true,
      'rewrite'       => array( 'slug' => __( 'agents', 'aviators' ) ),
      'menu_position' => 42,
      'menu_icon'   => plugins_url( 'aviators_agents/assets/img/icon.png'),
      'categories'    => array( ),
    )
  );
}

/**
 * Custom taxonomies
 */
add_action('init', 'aviators_agents_create_taxonomies', 0);

function aviators_agents_create_taxonomies() {

    $agent_types_labels = array(
        'name' => __('Types', 'aviators'),
        'singular_name' => __('Type', 'aviators'),
        'search_items' => __('Search Types', 'aviators'),
        'all_items' => __('All Types', 'aviators'),
        'parent_item' => __('Parent Type', 'aviators'),
        'parent_item_colon' => __('Parent Type:', 'aviators'),
        'edit_item' => __('Edit Type', 'aviators'),
        'update_itm' => __('Update Type', 'aviators'),
        'add_new_item' => __('Add New Type', 'aviators'),
        'new_item_name' => __('New Type', 'aviators'),
        'menu_name' => __('Types', 'aviators'),
    );

    register_taxonomy('agent-types', 'agent', array(
        'labels' => $agent_types_labels,
        'hierarchical' => TRUE,
        'query_var' => 'agent-type',
        'rewrite' => array('slug' => __('agent-type', 'aviators')),
        'public' => TRUE,
        'show_ui' => TRUE,
    ));
}

add_action('widgets_init', 'aviators_agents_widgets');
function aviators_agents_widgets() {
    register_widget('Agents_Widget');
}