<?php
/*
Plugin Name:    Aviators Landlords
Description:    Simple landlords storage
Version:        1.0.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

/**
 * Custom post type
 */
function aviators_landlords_create_post_type() {
    $labels = array(
        'name' => __('Landlords', 'aviators'),
        'singular_name' => __('Landlord', 'aviators'),
        'add_new' => __('Add New', 'aviators'),
        'add_new_item' => __('Add New Landlord', 'aviators'),
        'edit_item' => __('Edit Landlord', 'aviators'),
        'new_item' => __('New Landlord', 'aviators'),
        'all_items' => __('All Landlords', 'aviators'),
        'view_item' => __('View Landlord', 'aviators'),
        'search_items' => __('Search Landlord', 'aviators'),
        'not_found' => __('No landlords found', 'aviators'),
        'not_found_in_trash' => __('No landlords found in Trash', 'aviators'),
        'parent_item_colon' => '',
        'menu_name' => __('Landlords', 'aviators'),
    );

    register_post_type('landlord',
        array(
            'labels' => $labels,
            'supports' => array('title'),
            'public' => FALSE,
            'show_ui' => TRUE,
            'rewrite' => FALSE,
            'menu_position' => 42,
            'menu_icon' => plugins_url('aviators_landlords/assets/img/icon.png'),
        )
    );
}

add_action('init', 'aviators_landlords_create_post_type');