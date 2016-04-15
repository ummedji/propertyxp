<?php


/**
 * Utility function to get featured image url resized by aqua_resizer
 * @param null $post_id
 * @param int $width
 * @param int $height
 * @return array|bool|string
 */
function aviators_get_featured_image($post_id = null, $width = 540, $height = 400) {
    if(!$post_id) {
        $post_id = get_the_ID();
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);
    if(!$thumbnail_id) {
        return false;
    }

    $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id($post_id));
    if($width == null || $height == null) {
        return $thumbnail_url;
    }

    return aq_resize( $thumbnail_url, $width, $height, true, true, true );
}
