<?php

/**
 * Load Archive template
 * @param null $post_type
 * @return string
 */
function aviators_get_archive_template($post_type = null, $include = true) {
    return aviators_get_template('archive', $post_type, $include);
}

/**
 * Load content template
 * @param null $post_type
 * @param null $post_format
 * @return string
 */
function aviators_get_content_template($post_type, $post_format = null, $include = true) {
    return aviators_get_template('content', $post_type, $post_format, $include);
}


/**
 * Modified get_template_part function which creates more distinct names for templates
 * Allows for greater granularity
 * @param null $page
 * @param null $post_type
 * @param null $post_format
 * @return string
 */
function aviators_get_template($page = 'content', $post_type = null, $post_format = null, $include = true) {
    // Templates will be attempted to be loaded in the order they are added to this array

    $templates = array();

    // Get post type
    if(!$post_type) {
        $post_type = get_post_type();
    }

    // Get post format
    if(!$post_format) {
        $post_format = get_post_format();
    }

    if ( $post_format ) {
        // First check for something like content-post-audio.php (blog post using audio post format)
        $templates[] = "{$page}-{$post_type}-{$post_format}.php";
    }

    // If that doesn't exist, check simply for content-audio.php (shorter but may conflict with post type name)
    if($post_format) {
        $templates[] = "{$page}-{$post_format}.php";
    }

    // If no friendly post type template, load content-ctc_post_type.php, using the actual post type name
    if($post_type) {
        $templates[] = "{$page}-{$post_type}.php";
    }

    // If all else fails, use the plain vanilla template
    // Dont want to use for archive as there might be a infinite loop
    if($page == 'content') {
        $templates[] = "{$page}.php";
    }

    // array with highest priority on most granular template path
    $locations = array(
        get_stylesheet_directory() . "/templates/{$post_type}",
        get_stylesheet_directory() . "/templates/",
        get_stylesheet_directory(),
        get_template_directory()
    );


    $located = aviators_get_content_template_path($templates, $locations);

    if ( $located && $include ) {
        include $located;
    }

    return $located;
}

function aviators_get_content_template_path($templates, $locations) {
    foreach ( $templates as $template_name ) {
        if ( !$template_name ) {
            continue;
        }
        foreach( $locations as $location ) {
            $path = $location . '/' . $template_name;

            if ( file_exists($path) ) {
                return $path;
            }
        }
    }

    return false;
}