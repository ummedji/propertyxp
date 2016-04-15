<?php

define('AVIATORS_SEPARATOR_NAME', 'separator-aviators');

/**
 * Register nav menus
 */
function aviators_menus() {
    register_nav_menu('main', __('Main', 'aviators'));
    register_nav_menu('header', __('Header', 'aviators'));
    register_nav_menu('anonymous', __('Anonymous user', 'aviators'));
    register_nav_menu('authenticated', __('Authenticated user', 'aviators'));
}
add_action('init', 'aviators_menus');

/**
 * Parent menu items class
 */
function aviators_menus_parent_class( $items ) {
    $parents = array();

    foreach ($items as $item) {
        if ($item->menu_item_parent && $item->menu_item_parent > 0) {
            $parents[] = $item->menu_item_parent;
        }
    }

    foreach ($items as $item) {
        if (in_array( $item->ID, $parents)) {
            $item->classes[] = 'menuparent';
        }
    }

    return $items;
}
add_filter('wp_nav_menu_objects', 'aviators_menus_parent_class');


function aviators_add_admin_menu_separator($position) {
    global $menu;

    $index = 0;
    if ( is_array( $menu ) ) {
        foreach ( $menu as $offset => $section ) {
            if ( substr( $section[2], 0, 9 ) == 'separator' ) {
                $index++;
            }

            if ( $offset >= $position ) {
                $menu[$position] = array( '', 'read', AVIATORS_SEPARATOR_NAME, '', 'wp-menu-separator' );
                break;
            }
        }

        ksort( $menu );
    }
}

/**
 * Change revolution slider position and icon, if exists
 */
add_action( 'admin_menu', 'aviators_admin_menu' );
function aviators_admin_menu() {
    global $menu;

    foreach ($menu as $index => $value) {
        if ($value['2'] == 'revslider') {
            $menu[$index][4] = str_replace('menu-icon-generic ', '', $menu[$index][4]);
            $menu[$index][6] = get_template_directory_uri() . '/assets/img/revslider.png';
        }
    }
}

/**
 * Change default order of menu items in admin
 */

function aviators_custom_menu_order_enable() {
    return true;
}

function aviators_custom_menu_order($menu_ord) {
    aviators_add_admin_menu_separator(40);

    global $menu;

    $positions = array();
    foreach ( $menu as $index => $value ) {
        $positions[] = $value[2];
    }

    return aviators_move_revslider_into_aviators( $positions );
}


function aviators_move_revslider_into_aviators( $positions ) {
    $aviators_separator_position = null;
    $rest_separator_position = null;
    $revslider_position = null;

    foreach ( $positions as $index => $value ) {
        if ( $value == AVIATORS_SEPARATOR_NAME ) {
            $aviators_separator_position = $index;
        }

        // Look for another separators
        if ( $value === "" || strpos( $value, 'separator' ) === 0) {
            // Save the rest separator index
            if ( !empty( $aviators_separator_position ) ) {
                if ( $index > $aviators_separator_position ) {
                    if ( empty( $rest_separator_position ) ) {
                        $rest_separator_position = $index;
                    }
                }
            }
        }

        if ( $value == 'revslider' ) {
            $revslider_position = $index;
        }
    }

    if ( !empty( $aviators_separator_position ) && !empty( $rest_separator_position ) && !empty( $revslider_position ) ) {
        unset($positions[$revslider_position]);

        $chunks = array_chunk( $positions, $rest_separator_position );
        $chunks[0][] = 'revslider';

        return array_merge($chunks[0], $chunks[1]);
    }

    return $positions;
}

add_filter( 'custom_menu_order', 'aviators_custom_menu_order_enable' );
add_filter( 'menu_order', 'aviators_custom_menu_order' );