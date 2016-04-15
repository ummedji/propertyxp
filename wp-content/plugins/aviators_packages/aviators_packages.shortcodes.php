<?php

/**
 * Package Shortcode
 * @param $attributes
 * @param null $content
 * @return string
 */
function package_shortcode($attributes, $content = NULL) {
    extract(shortcode_atts(array(), $attributes));

    ob_start();
    include 'templates/package.php';
    $output = ob_get_clean();

    $strip_list = array('br');
    foreach ($strip_list as $tag)
    {
        $output = preg_replace('/<\/?' . $tag . '(.|\s)*?>/', '', $output);
    }

    return do_shortcode($output);
}
add_shortcode('package', 'package_shortcode');

/**
 * Package - Single Item Shortcode
 * @param $attributes
 * @param null $content
 * @return string
 */
function package_item_shortcode($attributes, $content = NULL) {
    extract(shortcode_atts(array(
        'flag' => 'active'
    ), $attributes));

    ob_start();
    include 'templates/package_item.php';
    $output = ob_get_clean();
    return do_shortcode($output);
}
add_shortcode('package_item', 'package_item_shortcode');