<?php

/*
Plugin Name:    Aviators Taxonomies
Description:    Settings system used in aviators themes
Version:        1.0.1
Author:         Aviators
Author URI:     http://byaviators.com
*/

function aviators_taxonomy_init() {
    $taxonomies = array('types');

    if (!count($taxonomies)) {
        return;
    }

    // enqueue media only on tax page
    if (isset($_GET['taxonomy'])) {
        wp_enqueue_media();
    }

    foreach ($taxonomies as $taxonomy) {
        add_filter('manage_edit-' . $taxonomy . '_columns', 'aviators_taxonomy_column_header');
        add_filter('manage_' . $taxonomy . '_custom_column', 'aviators_taxonomy_table_row', 15, 3);
    }
}

add_action('admin_init', 'aviators_taxonomy_init');

/**
 * Column header filter
 * @param $columns
 * @return mixed
 */
function aviators_taxonomy_column_header($columns) {
    $columns['aviators_taxonomy'] = __('Images', 'aviators');
    return $columns;
}

function aviators_taxonomy_table_row($arg1, $plugin, $term) {
    if ($plugin != 'aviators_taxonomy') {
        return;
    }

    // this for .. only extends the 'posts-filter' which wraps the whole table.
    $form = new \Hydra\Builder('posts-filter', '', \Hydra\Builder::FORM_EXTENDER);

    $fieldset = $form->addField('fieldset', array($term))
        ->isRenderable(FALSE)
        ->isTree(TRUE);

    $id = "image-$term";

    $output = "<div id=$id>";
    $url = aviators_taxonomy_get($term);
    if ($url) {
        $output .= "<img style=\"max-width:70px; height:auto;\" src=" . $url . ">";
    }
    $output .= "</div>";

    $fieldset->addField('markup', array('image', $output));

    $fieldset->addField('text', array('image_url', __('Image Url', 'aviators')))
        ->addAttribute('class', 'hydra-image-url')
        ->setWrapperClass('hidden')
        ->addAjaxAction('#' . $id, 'change')
        ->addAjaxCallback('aviators_taxonomy_image');

    $fieldset->addField('button', array('add_image', __('+', 'aviators')))
        ->addAttribute('class', 'hydra-add-image')
        ->addAttribute('style', 'float:left;');

    $fieldset->addField('button', array('remove_image', __('-', 'aviators')))
        ->addAttribute('class', 'hydra-remove-image')
        ->addAjaxAction('#' . $id, 'click')
        ->addAjaxCallback('aviators_taxonomy_image_remove');

    $form->build();
    print $form->render();
}

/**
 * Save&Load image
 * @param $form
 * @param $valuess
 */
function aviators_taxonomy_image($form, $values) {
    $term = str_replace('[image_url]', '', $values['trigger_element']);
    $image_url = $values[$term]['image_url'];

    $id = "image-$term";
    aviators_taxonomy_save($term, $image_url);
    echo "<div id=$id><img style=\"max-width:70px; height:auto;\" src=" . $image_url . "></div>";
}

/**
 * Remove image
 * @param $form
 * @param $values
 */
function aviators_taxonomy_image_remove($form, $values) {
    $term = str_replace('[remove_image]', '', $values['trigger_element']);
    $id = "image-$term";
    aviators_taxonomy_delete($term);
    echo "<div id=$id></div>";
}

/**
 * @param $term_id
 * @param $url
 */
function aviators_taxonomy_save($term_id, $url) {
    $options = get_option('aviators_taxonomy_images', array());
    $options[$term_id] = $url;
    update_option('aviators_taxonomy_images', $options);
}

/**
 * @param $term_id
 */
function aviators_taxonomy_delete($term_id) {
    $options = get_option('aviators_taxonomy_images', array());
    unset($options[$term_id]);
    update_option('aviators_taxonomy_images', $options);
}

/**
 * @param $term_id
 * @return bool
 */
function aviators_taxonomy_get($term_id) {
    $options = get_option('aviators_taxonomy_images', array());
    return isset($options[$term_id]) ? $options[$term_id] : FALSE;
}

/**
 * @param $term_id
 * @return bool|string
 */
function aviators_taxonomy_get_image($term_id) {
    $src = aviators_taxonomy_get($term_id);
    if ($src) {
        return '<img src=' . $src . '>';
    }

    return false;
}