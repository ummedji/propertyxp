<?php

/*
Plugin Name:    Aviators Submission
Description:    Settings system used in aviators themes
Version:        1.1.3
Author:         Aviators
Author URI:     http://byaviators.com
*/

/**
 * This plugin will take care of permission and integration between transactions and frontend submission
 * Also provides utility functions for management of multiple post types trough frontend submission
 * Provides settings and configurations hooks
 */
require_once 'aviators_submission.submission.php';
require_once 'aviators_submission.settings.php';


/**
 * Render submission types tabs with linking to proper submission index
 */
function aviators_submission_tabs() {
    $tabs = array();
    $options = aviators_submission_get_all_submission_types();
    $enabled_types = aviators_submission_get_enabled_submission_types();

    if(aviators_settings_get('transaction', 'submissions', 'submission_system') == 'package') {
        $enabled_types['package'] = 'package';
        $options['package'] = __('Package', 'aviators');
    }

    foreach ($enabled_types as $enabled_type) {
        if ($page = aviators_submission_get_submission_page($enabled_type, 'index')) {
            $tabs[$enabled_type] = array(
                'title' => $options[$enabled_type],
                'page' => $page,
            );
        }
    }

    include_once 'templates/tabs.php';
}

/**
 * @return array
 */
function aviators_submission_get_all_submission_types() {
    return array(
        'property' => __('Properties', 'aviators'),
        'agent' => __('Agents', 'aviators'),
        'agency' => __('Agencies', 'aviators'),
    );
}


/**
 * @param $post_type
 * @param bool $index
 */
function aviators_submission_get_submission_page($post_type, $index = TRUE) {
    $meta_value = 'page-submission-' . $post_type . '.php';
    if ($index) {
        $meta_value = 'page-submission-' . $post_type . '-index.php';
    }

    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => $meta_value,
    ));

    if ($pages) {
        return reset($pages);
    }

    return FALSE;
}


/**
 * @param $type
 * @return bool
 */
function aviators_submission_check_submission_type_dependencies($type) {
    $enabled_types = aviators_settings_get('submission', 'general', 'enabled_types');

    if (!in_array($type, $enabled_types)) {
        return FALSE;
    }

    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-submission-' . $type . '-index.php',
    ));

    $submission_page = reset($pages);

    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-submission-' . $type . '.php',
    ));
    $add_page = reset($pages);


    if ($add_page && $submission_page) {
        return TRUE;
    }

    return FALSE;
}


function aviators_submission_get_enabled_submission_types() {
    return aviators_settings_get('submission', 'general', 'enabled_types');
}


/**
 * Add new item
 * @param $post_type
 * @return array
 */
function aviators_submission_add($post_type) {
    $submission_page = aviators_submission_get_submission_page($post_type, FALSE);

    return array(
        'link' => get_permalink($submission_page),
        'icon_class' => 'fa fa-plus',
        'btn_class' => 'btn btn-primary',
        'text' => __('Add new', 'aviators'),
    );
}


function aviators_submission_messages($post_type) {
    do_action('aviators_submission_messages', $post_type);
}

/**
 * Frontend submission button actions
 * @param $post_type
 * @param $post_id
 * @return mixed|void
 */
function aviators_submission_actions($post_type, $post_id) {
    $submission_page = aviators_submission_get_submission_page($post_type, FALSE);
    $index_page = aviators_submission_get_submission_page($post_type);

    $links['view'] = array(
        'link' => get_permalink($post_id),
        'icon_class' => 'fa fa-eye',
        'btn_class' => 'btn btn-primary btn-inversed btn-small',
        'text' => __('View', 'aviators'),
    );

    $links['edit'] = array(
        'link' => get_permalink($submission_page) . '?' . http_build_query(array('id' => $post_id, 'action' => 'edit')),
        'icon_class' => 'fa fa-pencil',
        'btn_class' => 'btn btn-primary btn-inversed btn-small',
        'text' => __('Edit', 'aviators'),
    );
    $post = get_post($post_id);

    if ($post->post_status != 'publish') {
        // can only publish if posts are free or is paid
        if (aviators_submission_can_publish_post($post_type, $post_id, 'show')) {
            $links['publish'] = array(
                'link' => get_permalink($index_page) . '?' . http_build_query(array(
                        'id' => $post_id,
                        'action' => 'publish'
                    )),
                'icon_class' => 'fa fa-check-square',
                'btn_class' => 'btn btn-primary btn-inversed btn-small',
                'text' => __('Publish', 'aviators'),
            );
        }
    }
    else {
        $links['unpublish'] = array(
            'link' => get_permalink($index_page) . '?' . http_build_query(array(
                    'id' => $post_id,
                    'action' => 'unpublish'
                )),
            'icon_class' => 'fa fa-ban',
            'btn_class' => 'btn btn-primary btn-inversed btn-small',
            'text' => __('Unpublish', 'aviators'),
        );
    }

    $links['delete'] = array(
        'link' => get_permalink($index_page) . '?' . http_build_query(array('id' => $post_id, 'action' => 'delete')),
        'icon_class' => 'fa fa-trash-o',
        'btn_class' => 'btn btn-primary btn-inversed btn-small',
        'text' => __('Delete', 'aviators'),
    );


    // lets allow plugins to hook in
    $links = apply_filters('aviators_submission_actions', $links, $post_type);
    return $links;
}

/**
 * Create delete confirmation link
 * @param $post_type
 * @param $post_id
 * @return array
 */
function aviators_submission_action_delete_confirm($post_type, $post_id) {
    $index_page = aviators_submission_get_submission_page($post_type);

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

function aviators_submission_permission_check() {
    if(!is_user_logged_in()) {
        aviators_add_message(__('You are not allowed to access this page as anonymous user. Please sign in before.', 'aviators'), 'danger');
        $redirect = aviators_settings_get('submission', 'general', 'redirect');

        if($redirect) {
            wp_redirect($redirect);
        } else {
            wp_redirect(home_url());
        }
        exit();
    }
}

/**
 * Check if TOS is enabled for particular content type
 * @param $type
 * @return bool
 */
function aviators_submission_tos_enabled($type) {
    $enabled_tos = aviators_settings_get('submission', 'tos', 'enabled_tos');
    if($enabled_tos) {
        if(in_array($type, $enabled_tos)) {
            return true;
        }
    }
    return false;
}

/**
 * Retrieve page containing terms and services for content type, if enabled
 * @param $type
 * @return bool|null|WP_Post
 */
function aviators_submission_get_tos($type) {
    if(!aviators_submission_tos_enabled($type)) {
        return false;
    }

    $page_id = aviators_settings_get('submission', 'tos', $type);
    if($page_id) {
        $page = get_post($page_id);
        return $page;
    }

    return false;
}

/**
 * Process frontend submission actions
 */
function aviators_submission_process_actions() {
    if (isset($_GET['id'])) {
        $post = get_post($_GET['id']);

        // no post - no action
        if (!$post) {
            return;
        }
        $user = wp_get_current_user();
        // no access
        if ($user->ID != $post->post_author) {
            return;
        }


        switch ($_GET['action']) {
            case "publish":
                // can only publish if posts are free or is paid
                if (aviators_submission_can_publish_post($post->post_type, $post->ID, 'perform')) {
                    if ($post->post_status != "publish") {
                        aviators_add_message(sprintf(__('Post "%s" was successfully published', 'aviators'), $post->post_title), 'success');
                        $post->post_status = "publish";
                        wp_update_post((array) $post);
                    }
                }
                else {
                    aviators_add_message(__('You can not publish this post.', 'aviators'), 'danger');
                }
                break;
            case "unpublish":
                if ($post->post_status != "draft") {
                    aviators_add_message(sprintf(__('Post "%s" was successfully unpublished', 'aviators'), $post->post_title), 'warning');
                    $post->post_status = "draft";
                    wp_update_post((array) $post);
                }
                break;
            case "delete":
                if ($post) {
                    $link = aviators_submission_action_delete_confirm($post->post_type, $_GET['id']);

                    if (isset($_GET['confirm'])) {
                        wp_delete_post($post->ID);
                        aviators_add_message(sprintf(__("%s was successfully deleted", 'aviators'), $post->post_title), 'success');
                    }
                    else {
                        $output = __('Do you really want to delete this post: ', 'aviators');
                        $output .= " <b>" . $post->post_title . "</b>";
                        $output .= "<a href=" . $link['link'] . " class=\"btn btn-primary btn-small btn-inversed\"><i class=\"fa fa-trash-o\"></i><b>" . __('Yes, delete', 'aviators') . "</b></a>";
                        aviators_add_message($output, 'warning');
                    }
                }
                break;
        }
    }
}


/**
 * @param $post_type
 * @param $post_id
 * @return bool
 */
function aviators_submission_can_publish_post($post_type, $post_id, $type = 'perform') {
    $transaction_system = aviators_settings_get('transaction', 'submissions', 'submission_system');

    // no need to invoke any filters if submissions are for free
    if($transaction_system == 'free') {
        return true;
    }

    $permission = false;
    $permission = apply_filters('aviators_submission_has_permission', $permission, $post_type, $post_id, 'publish', $transaction_system, $type);
    return $permission;
}
