<?php
/*
Plugin Name:    Aviators Packages
Description:    Packages for selling agents, properties, agencies
Version:        1.0.1
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_packages.settings.php';
require_once 'aviators_packages.shortcodes.php';
require_once 'aviators_packages.metabox.php';
require_once 'aviators_packages.paypal.php';

/**
 * Custom post type
 */
add_action('init', 'aviators_packages_create_post_type');
function aviators_packages_init() {
    aviators_packages_disable_inactive_packages();
    aviators_packages_create_post_type();
}

/**
 * Post Type definition
 */
function aviators_packages_create_post_type() {
    $labels = array(
        'name' => __('Packages', 'aviators'),
        'singular_name' => __('Package', 'aviators'),
        'add_new' => __('Add new package', 'aviators'),
        'add_new_item' => __('Add new package', 'aviators'),
        'edit_item' => __('Edit package', 'aviators'),
        'new_item' => __('New package', 'aviators'),
        'all_items' => __('All packages', 'aviators'),
        'view_item' => __('View packages', 'aviators'),
        'search_items' => __('Search packages', 'aviators'),
        'not_found' => __('No transactions found', 'aviators'),
        'not_found_in_trash' => __('No transactions found in Trash', 'aviators'),
        'parent_item_colon' => '',
        'menu_name' => __('Packages', 'aviators'),
    );

    register_post_type(
        'package',
        array(
            'labels' => $labels,
            'supports' => array(),
            'public' => TRUE,
            'query_var' => FALSE,
            'show_ui' => TRUE,
            'has_archive' => TRUE,
            'rewrite' => array('slug' => __('packages', 'aviators')),
            'exclude_from_search' => TRUE,
            'menu_position' => 42,
            'menu_icon' => plugins_url('aviators_packages/assets/img/icon.png'),
        )
    );
}


function aviators_packages_disable_inactive_packages() {
    //@todo - this also does not count with some 'free posts' option
    // find all package related transaction with still active flag

    // check only once per 4 hours, not to overload each request with package checks
    if(get_option('aviators_package_check', 0) + 2160 > time()) {
        return;
    }
    update_option('aviators_package_check', time());

    $query = new WP_Query(array(
        'post_type' => 'transactions',
        'meta_query' => array(
            array(
                'key' => 'expired',
                'value' => false,
            ),
            array(
                'key' => 'payment_type',
                'value' => 'package',
            )
        )
    ));

    $transactions = $query->get_posts();

    // nothing more to do, this system probably does not have any packages
    if (!count($transactions)) {
        return;
    }

    foreach ($transactions as $transaction) {
        try {
            $paypal_profile = aviators_package_get_payment_profile($transaction->ID);
            // something went wrong oO
            if($paypal_profile) {
                return;
            }
            // even if there are more packages, on each run one package will be disabled
            // Do not disable right away, give 2 days for time so they can buy the package before un-publishing everything
            $user_id = $transaction->paypal_post_id;
            $package = aviators_package_get_package_by_user(get_post_meta($user_id, 'paypal_user_id', TRUE));
            if (!aviators_package_is_paid($paypal_profile)) {
                // package is in not paid status, disable the transaction
                aviators_transaction_disable($transaction->ID);
                $post_types = array('agent', 'property', 'agency');

                if (!$package) {
                    // A. User has no active package
                    // A. 1 Find all posts related to his account and disable those
                    foreach ($post_types as $post_type) {
                        aviators_packages_disable_oldest_posts($user_id, $post_type, 1000);
                    }
                }
                else {
                    // B. User has different package active, but it might be smaller package
                    $package_data = aviators_package_get_data($package->ID);
                    // B. 1 Check how many posts does this active package allow, and compare it with currently active posts
                    foreach ($post_types as $post_type) {
                        $diff = aviators_package_get_active_posts($user_id, $post_type) - $package_data[$post_type];
                        if ($diff > 0) {
                            // B. 2 Disable the oldest posts.
                            aviators_packages_disable_oldest_posts($user_id, $post_type, $diff);
                        }
                    }
                }
            } else {
                // package is in not paid status, disable the transaction
                aviators_transaction_disable($transaction->ID);
            }
        } catch (Exception $e) {
            // there was an exception, however we still need to check the rest of the packages, one exception cannot stop exection!
            continue;
        }
    }
}
add_action('init', 'aviators_packages_disable_inactive_packages');

/**
 * Check if package for particular user is active
 */
function aviators_packages_is_package_active($post_id = null, $user_id = null) {

    if($post_id == null) {
        $post_id = get_the_ID();
    }

    if($user_id == null) {
        $user_id = get_current_user_id();
    }

    $query = new WP_Query(array(
        'post_type' => 'transactions',
        'meta_query' => array(
            array(
                'key' => 'expired',
                'value' => FALSE,
            ),
            array(
                'key' => 'payment_type',
                'value' => 'package',
            ),
            array(
                'key' => 'paypal_post_id',
                'value' => $post_id,
            ),
            array(
                'key' => 'paypal_user_id',
                'value' => $user_id,
            )
        )
    ));

    if($query->get_posts()) {
        return true;
    }

    return false;
}

/**
 * Boolean check if package is among featured packages
 * Simple utility function
 * @param null $post_id
 * @return bool
 */
function aviators_package_is_featured($post_id = null) {
    if($post_id == null) {
        $post_id = get_the_ID();
    }

    $data = aviators_package_get_data($post_id);
    if(isset($data['featured'])) {
        return (bool)$data['featured'];
    } else {
        return false;
    }
}

/**
 * @param $user_id
 * @param $post_type
 * @param $number
 */
function aviators_packages_disable_oldest_posts($user_id, $post_type, $number) {
    $query = new WP_Query(array(
        'post_type' => $post_type,
        'author' => $user_id,
        'post_status' => 'publish',
        'order' => 'ASC',
        'orderby' => 'date',
        'posts_per_page' => $number,
    ));

    $posts = $query->get_posts();
    if (!count($posts)) {

    }

    // un-publish
    foreach ($posts as $post) {
        wp_update_post(array('ID' => $post->ID, 'post_status' => 'draft'));
    }
}


/**
 * Get Active package for user
 * @param null $user_id
 * @return bool|null|WP_Post
 */
function aviators_package_get_package_by_user($user_id = NULL) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }


    // @todo - add condition for active results only ( based on date )
    $query = new WP_Query(array(
        'post_type' => 'transactions',
        'meta_query' => array(
            array(
                'key' => 'paypal_user_id',
                'value' => $user_id,
            ),
            array(
                'key' => 'payment_type',
                'value' => 'package',
            ),

        )
    ));

    $results = $query->get_posts();

    // we need to filter out only the active ones and also order them by price
    // The the most expensive package should be the active one ( If there is some chance that someone bought 2 packages
    // at the same time ..)
    $package = FALSE;
    if ($results) {

        foreach ($results as $result) {
            $transaction = reset($results);
            $package_id = get_post_meta($transaction->ID, 'paypal_post_id', TRUE);

            // package is still active
            // there is already one package loaded, we just need to check if current one is more expensives
            if ($package) {
                if (get_post_meta($package_id, 'price', TRUE) > get_post_meta($package->ID, 'price', TRUE)) {
                    // yes, it is more expensive and still active, thus enabled !
                    $package = get_post($package_id);
                }
            }
            else {
                $package = get_post($package_id);
            }
        }
    }

    return $package;
}

function aviators_package_get_package_data($user_id = NULL) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    // load package type first
    // $package = aviators_package_get_package_by_user($user_id);

    $active_properties = aviators_package_get_active_posts($user_id, 'property');

    $active_agents = aviators_package_get_active_posts($user_id, 'agent');
    $active_agencies = aviators_package_get_active_posts($user_id, 'agency');

    return array(
        'active_properties' => $active_properties,
        'active_agents' => $active_agents,
        'active_agencies' => $active_agencies,
    );
}

/**
 * Get number of posts published by author
 * @param $user_id
 * @param $post_type
 * @return array
 */
function aviators_package_get_active_posts($user_id, $post_type) {
    $query = new WP_Query(array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'author' => $user_id,
    ));

    return $query->get_posts();
}

/**
 * @param $has_permission
 * @param $post_type
 * @param $post_id
 * @param $action
 * @param $payment_system
 * @param $type
 * @return bool
 */
function aviators_package_check_permission($has_permission, $post_type, $post_id, $action, $payment_system, $type = 'perform') {
    // not to be handled as package, return intact value
    if ($payment_system != 'package') {
        return $has_permission;
    }

    // no permission - no active package
    if(!aviators_package_get_package_by_user()) {
        return false;
    }

    switch ($action) {
        case "publish":
            $post = get_post($post_id);

            if ($post->post_status == 'publish') {
                // well, it is already publish, no reason to display warning messages
                return TRUE;
            }

            $has_permission = !aviators_package_is_limit_reached($post_type);

            break;
    }

    return $has_permission;
}

add_filter('aviators_submission_has_permission', 'aviators_package_check_permission', 10, 5);


function aviators_package_is_limit_reached($post_type) {
    $active_posts = aviators_package_get_active_posts(get_current_user_id(), $post_type);
    $package = aviators_package_get_package_by_user();
    $package_data = aviators_package_get_data($package->ID);

    if (count($active_posts) < $package_data[$post_type]) {
        return FALSE;
    }

    return TRUE;
}

/**
 * Get nicely formatted meta-data for package
 * @param $id
 * @return array
 */
function aviators_package_get_data($id) {
    $meta = get_post_meta($id);

    $values = array();
    if(is_array($meta) && count($meta)) {
        foreach ($meta as $index => $meta) {
            $values[$index] = reset($meta);
        }
    }

    return $values;
}

/**
 * Process the data from payment before they are saved
 * In this case we need to alter the payment type value to 'package'
 * @param $data
 * @return mixed
 */
function aviators_package_payment_save($data) {
    if (get_post_type($data['paypal_post_id']) == 'package') {
        $price = get_post_meta($data['paypal_post_id'], 'price', TRUE) + get_post_meta($data['paypal_post_id'], 'tax', TRUE);

        $data['payment_type'] = 'package';
        $data['paypal_cost'] = $price;
        $data['expired'] = FALSE;
    }

    return $data;
}

add_filter('aviators_transaction_before_save', 'aviators_package_payment_save');
