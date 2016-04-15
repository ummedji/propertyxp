<?php
/*
Plugin Name:    Aviators Agencies
Description:    Agencies post type definition
Version:        1.1.1
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once ABSPATH . 'wp-content/plugins/aviators_widgets/widgets/generic.php';
require_once 'widgets/agencies.php';
require_once 'aviators_agencies.submission.php';

/**
 * Custom post type
 */
add_action( 'init', 'aviators_agency_create_post_type' );

function aviators_agency_create_post_type() {
  $labels = array(
    'name'               => __( 'Agencies', 'aviators' ),
    'singular_name'      => __( 'Agency', 'aviators' ),
    'add_new'            => __( 'Add New Agency', 'aviators' ),
    'add_new_item'       => __( 'Add New Agency', 'aviators' ),
    'edit_item'          => __( 'Edit Agency', 'aviators' ),
    'new_item'           => __( 'New Agency', 'aviators' ),
    'all_items'          => __( 'All Agency', 'aviators' ),
    'view_item'          => __( 'View Agency', 'aviators' ),
    'search_items'       => __( 'Search Agency', 'aviators' ),
    'not_found'          => __( 'No agencies found', 'aviators' ),
    'not_found_in_trash' => __( 'No agencies found in Trash', 'aviators' ),
    'parent_item_colon'  => '',
    'menu_name'          => __( 'Agencies', 'aviators' ),
  );

  register_post_type( 'agency',
    array(
      'labels'        => $labels,
      'supports'      => array( 'title', 'editor', 'thumbnail', ),
      'public'        => true,
      'show_ui'       => true,
      'has_archive'   => true,
      'rewrite'       => array( 'slug' => __( 'agencies', 'aviators' ) ),
      'menu_position' => 42,
      'menu_icon'   => plugins_url( 'aviators_agencies/assets/img/icon.png'),
      'categories'    => array( ),
    )
  );
}

add_action('widgets_init', 'aviators_agencies_widgets');
function aviators_agencies_widgets() {
    register_widget('Agency_Widget');
}