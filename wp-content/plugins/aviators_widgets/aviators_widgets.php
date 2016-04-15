<?php
/*
Plugin Name:    Aviators Widgets
Description:    General widgets
Version:        1.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'shortcodes/shortcodes.php';

require_once 'widgets/generic.php';
require_once 'widgets/text.php';
require_once 'widgets/hexagon.php';
require_once 'widgets/accordion.php';
require_once 'widgets/features.php';

add_action('widgets_init', 'aviators_widgets_widgets');

function aviators_widgets_widgets() {
    register_widget('Aviators_Widget_Text');
    register_widget('Aviators_Widget_Hexagon');
    register_widget('Aviators_Widget_Accordion');
    register_widget('Aviators_Widget_Features');
}


add_action( 'admin_init', 'aviators_widgets_admin_init' );
function aviators_widgets_admin_init() {
    if(strstr($_SERVER['REQUEST_URI'], 'widgets.php')) {
        wp_enqueue_media();
    }
}