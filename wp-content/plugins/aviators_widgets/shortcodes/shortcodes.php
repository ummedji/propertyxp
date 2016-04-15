<?php

function stat_shortcode( $attributes, $content = null ) {
    extract(shortcode_atts(array(
        'number' => 1000,
    ), $attributes));

    ob_start();
    include 'templates/stat.php';
    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'stat', 'stat_shortcode');

/**
 * Button Shortcode
 * @param $attributes
 * @param null $content
 * @return string
 */
function button_shortcode( $attributes, $content = null) {
    extract(shortcode_atts(array(
        'style' => 'white',
        'title' => 'Button',
        'href' => '#',
        'alt' => '#',
    ), $attributes));

    $class = 'btn-' . $style;

    return "<a href=$href alt=$alt class=$class>" . do_shortcode($content) . "</a>";
}
add_shortcode( 'button', 'button_shortcode');

/** Hex Element Shortcode
 * @param $attributes
 * @param null $content
 * @return string
 */
function hex_shortcode( $attributes, $content = null ) {
    extract(shortcode_atts(array(
        'title' => '',
        'icon' => 'fa fa-check',
    ), $attributes));

    ob_start();
    include 'templates/hex.php';
    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'hex', 'hex_shortcode');

function row_shortcode( $attributes, $content = null ) {
    $output = "<div class=row>";
    $output .= do_shortcode($content);
    $output .= "</div>";

    return $output;
}
add_shortcode( 'row', 'row_shortcode' );


/**
 * Bootstrap Columns Shortcode
 * @param $attributes - $cols
 * @param null $content
 * @return string
 */
function columns_shortcode( $attributes, $content = null) {
    extract($attributes);

    $class = 'col-sm-' . $cols;
    if(isset($off)) {
        $class .= ' col-sm-offset-' . $off;
    }
    $output = "<div class=\"$class\">";
    $output .= do_shortcode($content);
    $output .= "</div>";

    return $output;
}
add_shortcode( 'columns', 'columns_shortcode' );


/**
 * Feature Element Shortcode
 * @param $attributes - $icon, $title
 * @param null $content
 * @return string
 */
function feature_shortcode( $attributes, $content = null ) {
    extract($attributes);

    ob_start();
    include 'templates/feature.php';
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'feature', 'feature_shortcode' );


/**
 * FAQ style Element Shortcode
 * @param $attributes
 * @param null $content
 * @return string
 */
function panel_shortcode( $attributes, $content = null ) {
    static $panel_index;

    extract(shortcode_atts(array(
        'title' => '',
        'open' => 0,
    ), $attributes));

    // we need to prevent having not unique identifier - static variable is our decision :)
    if(empty($panel_index)) {
        $panel_index = 0;
    }
    $panel_index++;

    ob_start();
    include 'templates/panel.php';
    $output = ob_get_clean();

    return $output;
}
add_shortcode( 'panel', 'panel_shortcode' );


function panels_shortcode( $attributes, $content = null ) {
    $output = '<div class="panel-group" id="accordion">';
    $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}
add_shortcode( 'panels', 'panels_shortcode' );