<?php

require_once 'widgets/map.php';
require_once 'widgets/properties.php';
require_once 'widgets/properties_carousel.php';
require_once 'widgets/properties_slider.php';

add_action('widgets_init', 'aviators_properties_widgets');
function aviators_properties_widgets() {
    register_widget('PropertiesCarousel_Widget');
    register_widget('Properties_Widget');
    register_widget('PropertiesSlider_Widget');
    register_widget('Map_Widget');
}