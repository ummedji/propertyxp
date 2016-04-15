<?php
/*
Plugin Name:    Aviators Properties
Description:    Adds Properties CPT and couple of widgets for displaying the Properties
Version:        1.2.5
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_properties.settings.php';
require_once 'aviators_properties.widgets.php';
require_once 'aviators_properties.sort.php';
require_once 'aviators_properties.submission.php';

/**
 * Custom post type
 */
add_action('init', 'aviators_properties_create_post_type');

function aviators_properties_create_post_type() {
    $labels = array(
        'name' => __('Properties', 'aviators'),
        'singular_name' => __('Property', 'aviators'),
        'add_new' => __('Add New Property', 'aviators'),
        'add_new_item' => __('Add New Property', 'aviators'),
        'edit_item' => __('Edit Property', 'aviators'),
        'new_item' => __('New Property', 'aviators'),
        'all_items' => __('All Properties', 'aviators'),
        'view_item' => __('View Property', 'aviators'),
        'search_items' => __('Search Property', 'aviators'),
        'not_found' => __('No Properties found', 'aviators'),
        'not_found_in_trash' => __('No Properties found in Trash', 'aviators'),
        'parent_item_colon' => '',
        'menu_name' => __('Properties', 'aviators'),
    );

    register_post_type('property',
        array(
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'comments'),
            'public' => TRUE,
            'has_archive' => TRUE,
            'rewrite' => array('slug' => __('properties', 'aviators')),
            'menu_icon' => plugins_url('aviators_properties/assets/img/icon.png'),
            'menu_position' => 42,
            'categories' => array(),
        )
    );
}

/**
 * Custom taxonomies
 */
add_action('init', 'aviators_properties_create_taxonomies', 0);

function aviators_properties_create_taxonomies() {
    $property_types_labels = array(
        'name' => __('Types', 'aviators'),
        'singular_name' => __('Type', 'aviators'),
        'search_items' => __('Search Types', 'aviators'),
        'all_items' => __('All Types', 'aviators'),
        'parent_item' => __('Parent Type', 'aviators'),
        'parent_item_colon' => __('Parent Type:', 'aviators'),
        'edit_item' => __('Edit Type', 'aviators'),
        'update_item' => __('Update Type', 'aviators'),
        'add_new_item' => __('Add New Type', 'aviators'),
        'new_item_name' => __('New Type', 'aviators'),
        'menu_name' => __('Types', 'aviators'),
    );

    register_taxonomy('types', 'property', array(
        'labels' => $property_types_labels,
        'hierarchical' => TRUE,
        'query_var' => 'type',
        'rewrite' => array('slug' => __('property-type', 'aviators')),
        'public' => TRUE,
        'show_ui' => TRUE,
    ));

    $property_contract_types_labels = array(
        'name' => __('Contract Types', 'aviators'),
        'singular_name' => __('Contract Type', 'aviators'),
        'search_items' => __('Search Contract Types', 'aviators'),
        'all_items' => __('All Contract Types', 'aviators'),
        'parent_item' => __('Parent Contract Type', 'aviators'),
        'parent_item_colon' => __('Parent Contract Type:', 'aviators'),
        'edit_item' => __('Edit Contract Type', 'aviators'),
        'update_itm' => __('Update Contract Type', 'aviators'),
        'add_new_item' => __('Add New Contract Type', 'aviators'),
        'new_item_name' => __('New Contract Type', 'aviators'),
        'menu_name' => __('Contract Types', 'aviators'),
    );

    register_taxonomy('contract_types', 'property', array(
        'labels' => $property_contract_types_labels,
        'hierarchical' => TRUE,
        'query_var' => 'contract-type',
        'rewrite' => array('slug' => __('contract-type', 'aviators')),
        'public' => TRUE,
        'show_ui' => TRUE,
    ));

    $property_amenities_labels = array(
        'name' => __('Amenities', 'aviators'),
        'singular_name' => __('Amenity', 'aviators'),
        'search_items' => __('Search Amenity', 'aviators'),
        'all_items' => __('All Amenities', 'aviators'),
        'parent_item' => __('Parent Amenity', 'aviators'),
        'parent_item_colon' => __('Parent Amenity:', 'aviators'),
        'edit_item' => __('Edit Amenity', 'aviators'),
        'update_itm' => __('Update Amenity', 'aviators'),
        'add_new_item' => __('Add New Amenity', 'aviators'),
        'new_item_name' => __('New Amenity', 'aviators'),
        'menu_name' => __('Amenities', 'aviators'),
    );

    register_taxonomy('amenities', 'property', array(
        'labels' => $property_amenities_labels,
        'hierarchical' => TRUE,
        'query_var' => 'amenity',
        'rewrite' => array('slug' => __('amenities', 'aviators')),
        'public' => TRUE,
        'show_ui' => TRUE,
        'show_admin_column' => TRUE,
    ));

    $property_locations_labels = array(
        'name' => __('Locations', 'aviators'),
        'singular_name' => __('Location', 'aviators'),
        'search_items' => __('Search Location', 'aviators'),
        'all_items' => __('All Locations', 'aviators'),
        'parent_item' => __('Parent Location', 'aviators'),
        'parent_item_colon' => __('Parent Location:', 'aviators'),
        'edit_item' => __('Edit Location', 'aviators'),
        'update_itm' => __('Update Location', 'aviators'),
        'add_new_item' => __('Add New Location', 'aviators'),
        'new_item_name' => __('New Location', 'aviators'),
        'menu_name' => __('Locations', 'aviators'),
    );

    register_taxonomy('locations', 'property', array(
        'labels' => $property_locations_labels,
        'hierarchical' => TRUE,
        'query_var' => 'location',
        'rewrite' => array('slug' => __('location', 'aviators')),
        'public' => TRUE,
        'show_ui' => TRUE,
        'show_admin_column' => TRUE,
    ));
}

/**
 * Get most recent Properties
 *
 * @return array()
 */
function aviators_properties_get_most_recent($count = 3, $shuffle = FALSE) {
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => $count,
    );

    if ($shuffle) {
        $args['orderby'] = 'rand';
    }

    $query = new WP_Query($args);
    return _aviators_properties_prepare($query);
}

/**
 * Ger Properties for map
 */
function aviators_properties_get_for_map() {
    $filtered_properties = array();
    $properties = aviators_properties_get_most_recent(9999);

    foreach ($properties as $property) {
        if (isset($property->meta['hf_property_map']['items']) && isset($property->meta['hf_property_map']['items'])) {
            $field_property = reset($property->meta['hf_property_map']['items']);
            if (!empty($field_property['latitude']) && is_numeric($field_property['latitude']) && !empty($field_property['longitude']) && is_numeric($field_property['longitude'])) {
                $filtered_properties[] = $property;
            }
        }
    }


    return $filtered_properties;
}

/**
 * Prepare meta information for Properties
 *
 * @return array()
 */
function _aviators_properties_prepare(WP_Query $query) {
    $results = array();

    foreach ($query->posts as $property) {
        $property->meta = get_post_meta($property->ID, '', TRUE);
        $property->location = wp_get_post_terms($property->ID, 'locations');
        $property->types = wp_get_post_terms($property->ID, 'types');
        $results[] = $property;

        foreach ($property->meta as $key => $meta) {
            if (isset($meta[0])) {
                if (is_serialized($meta[0])) {
                    $data = @unserialize($meta[0]);

                    if ($data) {
                        $property->meta[$key] = $data;
                    }
                }
            }
        }
    }


    return $results;
}

/**
 * Open graph support for Property post type
 */
add_action('wp_head', 'aviators_properties_open_graph');
function aviators_properties_open_graph() {
    if (!is_singular('property')) {
        return;
    }
    ?>
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:type" content="article">
    <meta property="og:image" content="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>">
    <meta property="og:url" content="<?php the_permalink(get_the_ID()); ?>">
<?php
}

/**
 * Get image by term ID
 *
 * @return string
 */
function aviators_properties_get_term_image($term_id) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    if(aviators_taxonomy_get($term_id)) {
        return "<img src=" . aviators_taxonomy_get($term_id) . ">";
    }
    return NULL;
}


function aviators_submission_property_action_add() {
    $submission_page = _aviators_submission_get_submission_page();
    return array(
        'link' => get_permalink($submission_page),
        'icon_class' => 'fa fa-plus',
        'btn_class' => 'btn btn-primary',
        'text' => __('Add new', 'aviators'),
    );
}


function aviators_submission_property_action_delete_confirm($post_id) {
    $index_page = _aviators_submission_get_index_page();
    return array(
        'link' => get_permalink($index_page) . '?' . http_build_query(array(
                'id' => $post_id,
                'action' => 'delete',
                'confirm' => 'yes'
            )),
        'icon_class' => 'icon icon-normal-mark-cross',
        'btn_class' => 'btn btn-danger',
        'text' => __('Delete', 'aviators'),
    );
}

function _aviators_submission_get_index_page() {

    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-submissions.php',
        'numberposts' => -1,
    ));
    $index_page = reset($pages);
    return $index_page;
}

function _aviators_submission_get_submission_page() {
    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-property-submission.php',
        'numberposts' => -1,
    ));
    $submission_page = reset($pages);
    return $submission_page;
}



function aviators_property_enqueue_script() {
    wp_enqueue_media();
    wp_enqueue_script('gmap', 'http://maps.googleapis.com/maps/api/js?v=3&sensor=true&ver=3.7.1&libraries=places');
    wp_enqueue_script('geolocation', HYDRA_URL . 'assets/geolocation.js', 'gmap');
}

add_action('wp_enqueue_scripts', 'aviators_property_enqueue_script');


/**
 * Adds javascript code to fire the map
 */

function aviators_properties_init_map($instance = NULL) {

    if ($instance == NULL && !empty($GLOBALS['map_widget_instance'])) {
        $instance = $GLOBALS['map_widget_instance'];
    }
    $properties = aviators_properties_get_for_map($instance);

    $contents = '';
    foreach ( $properties as $property ) {
        ob_start();
        include aviators_get_content_template('property', 'map', false);
        $content = ob_get_clean();

        $content = str_replace(array("\r\n", "\n", "\t"), "", $content);
        $content = addslashes($content);
        $contents .= "'$content',";
    }
    $contents = trim($contents, ',');
    ?>


    <script type="text/javascript">
        (function ($) {
            var map = $('#map').aviators_map({
                <?php if(aviators_get_active_map_style()): ?>
                styles: <?php print aviators_get_active_map_style(); ?>,
                <?php endif;?>
                locations: new Array(<?php foreach ($properties as $property) : ?>[<?php $mapPosition = get_post_meta( $property->ID, 'hf_property_map', TRUE ); echo $mapPosition['items'][0]['latitude']; ?>, <?php echo $mapPosition['items'][0]['longitude']; ?>]<?php if ( end( $properties ) != $property ) : ?>, <?php endif; ?><?php endforeach; ?>),
                types: new Array(<?php foreach ( $properties as $property ) : ?>'<?php $terms = wp_get_object_terms( $property->ID, 'types', TRUE); if (!empty($terms['slug'])) { echo $terms[ 'slug' ]; } ?>'<?php if ( end( $properties ) != $property ) : ?>, <?php endif; ?><?php endforeach; ?>),
                contents: new Array(<?php print $contents; ?>),
                images: new Array(<?php foreach ( $properties as $property ): $flag = hydra_render_field($property->ID, 'flag', 'grid'); ?>'<?php if (!empty($flag)): ?><div class="label"><?php echo str_replace(array("\r\n", "\n", "\t"), "", strip_tags($flag)); ?></div><?php endif;?><?php $type_terms = wp_get_object_terms( $property->ID, 'types', TRUE); if(isset($type_terms[0])) { echo aviators_properties_get_term_image($type_terms[0]->term_id); } ?>'<?php if ( end( $properties ) != $property ) : ?>, <?php endif; ?><?php endforeach; ?>),
                transparentMarkerImage: '<?php echo get_template_directory_uri(); ?>/assets/img/marker-transparent.png',
                transparentClusterImage: '<?php echo get_template_directory_uri(); ?>/assets/img/cluster-transparent.png',
                zoom: <?php echo $instance['zoom']; ?>,
                filterForm: '.map-filter-form',
                center: {
                    latitude: <?php echo $instance['latitude']; ?>,
                    longitude: <?php echo $instance['longitude']; ?>
                },
                enableGeolocation: <?php echo $instance['enable_geolocation'] ? 'true' : 'false'; ?>
            });
        })(jQuery);
    </script>
    <?php

    unset($GLOBALS['map_widget_instance']);
}

function aviators_properties_map_detail() {

    ?>

    <?php $mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);

    ?>

    <?php if (!empty($mapPosition['items'][0]['latitude']) && !empty($mapPosition['items'][0]['longitude'])) : ?>
        <?php $type_terms = wp_get_object_terms( get_the_ID(), 'types', TRUE); ?>

        <script type="text/javascript">
            (function ($) {
                var map = $('#map-property').aviators_map({
                    locations: new Array([<?php echo $mapPosition['items'][0]['latitude']; ?>,<?php echo $mapPosition['items'][0]['longitude']; ?>]),
                    contents: new Array(''),
                    types: new Array('apartment'),
                    images: new Array('<?php if(isset($type_terms[0])) { echo aviators_properties_get_term_image($type_terms[0]->term_id); } ?>'),
                    transparentMarkerImage: '<?php echo get_template_directory_uri(); ?>/assets/img/marker-transparent.png',
                    transparentClusterImage: '<?php echo get_template_directory_uri(); ?>/assets/img/markers/cluster-transparent.png',
                    pixelOffsetX: 50,
                    pixelOffsetY: -60,
                    disableClickEvent: true,
                    openAllInfoboxes: true,
                    zoom: 16,
                    center: {
                        latitude: <?php echo $mapPosition['items'][0]['latitude']; ?>,
                        longitude: <?php echo $mapPosition['items'][0]['longitude']; ?>
                    },
                    mapMoveCenter: {
                        x: 5,
                        y: -25
                    }
                });
            })(jQuery);
        </script>
    <?php endif; ?>
<?php
}


function aviators_properties_pre_render() {
    if(isset($_GET['map_filter']) && $_GET['map_filter'] == 'on') {
        $filter = hydra_form_filter(str_replace('hydraform-', '', $_GET['form_id']));
        $query_args = $filter->getQueryArray();

        $query_args['numberposts'] = -1;
        $query_args['suppress_filters'] = FALSE;
        $properties = get_posts($query_args);

        $locations = array();
        $types = array();
        $contents = array();


        foreach($properties as $property) {
            ob_start();

            include aviators_get_content_template('property', 'map', false);
            $content = ob_get_clean();

            $content = str_replace(array("\r\n", "\n", "\t"), "", $content);
            $content = trim($content, ',');

            $contents[] = base64_encode($content);

            $mapPosition = get_post_meta( $property->ID, 'hf_property_map', TRUE );
            $locations[] = array($mapPosition['items'][0]['latitude'], $mapPosition['items'][0]['longitude']);

            $type_terms = wp_get_object_terms( $property->ID, 'types', TRUE);
            if(isset($type_terms[0])) {
                $images[] = aviators_properties_get_term_image($type_terms[0]->term_id);
            } else {
                $images[] = '';
            }

            $terms = wp_get_object_terms( $property->ID, 'types', TRUE);
            if (!empty($terms['slug'])) {
                $types[] = $terms['slug'];
            } else {
                $types[] = 'default';
            }
        }

        $data = array(
            'locations' => $locations,
            'types' => $types,
            'contents' => $contents,
            'images' => $images,
        );

        print json_encode($data);
        exit();
    }
}
add_action('aviators_pre_render', 'aviators_properties_pre_render');

function aviators_properties_enqueue_form($form, $form_name) {

    if($form_name != 'hydraform-enquire_form') {
        return;
    }

    $fieldDb = new HydraFieldModel();
    $agentReferenceFields = $fieldDb->loadOptionsByFieldType('reference', 'agent');

    if(!count($agentReferenceFields)) {
        return;
    }

    // nasty way how to setup agent context for property
    foreach($agentReferenceFields as $id => $fieldName) {
        $field = $fieldDb->load($id);
        $agents = get_posts(array('post_type' => 'agent'));

        foreach($agents as $agent) {
            $meta = $field->loadMeta($agent->ID);

            if($meta->value) {
                if(in_array(get_the_ID(), $meta->value['items']['0']['value'])) {
                    $tokens = $form->getField('tokens');
                    $value = $tokens->getValue();
                    $tokens->setValue($value . ',' . $agent->ID);
                    break;
                }
            }
        }
    }
}
add_action('hydraforms_form_alter', 'aviators_properties_enqueue_form', 10, 2);