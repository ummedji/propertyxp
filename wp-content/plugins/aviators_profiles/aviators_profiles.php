<?php
/*
Plugin Name:    Aviators Profiles
Description:    Profile for users registering through front end
Version:        1.1.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_profiles.settings.php';
/**
 * Custom post type
 */
add_action('init', 'aviators_profiles_create_post_type');

function aviators_profiles_create_post_type() {
    $labels = array(
        'name' => __('Profiles', 'aviators'),
        'singular_name' => __('Profile', 'aviators'),
        'add_new' => __('Add New Profile', 'aviators'),
        'add_new_item' => __('Add New Profile', 'aviators'),
        'edit_item' => __('Edit Profile', 'aviators'),
        'new_item' => __('New Profile', 'aviators'),
        'all_items' => __('All Profile', 'aviators'),
        'view_item' => __('View Profile', 'aviators'),
        'search_items' => __('Search Profile', 'aviators'),
        'not_found' => __('No profiles found', 'aviators'),
        'not_found_in_trash' => __('No profiles found in Trash', 'aviators'),
        'parent_item_colon' => '',
        'menu_name' => __('Profiles', 'aviators'),
    );

    register_post_type('profile',
        array(
            'labels' => $labels,
            'supports' => false,
            'public' => TRUE,
            'show_ui' => TRUE,
            'has_archive' => TRUE,
            'rewrite' => array('slug' => __('profiles', 'aviators')),
            'menu_position' => 42,
            'menu_icon' => plugins_url('aviators_profiles/assets/img/icon.png'),
            'categories' => array(),
        )
    );
}

/**
 * Registration page callback - logic before rendering
 */
function aviators_profile_register_page() {
    if (is_user_logged_in()) {
        aviators_add_message(__('You are already logged in.', 'aviators'), 'warning');
    }
    // cant register
    if (!get_option('users_can_register')) {
        aviators_add_message(__('Site configuration does not allow registration.', 'aviators'), 'warning');
    }
}

/**
 * Check if currently logged user can edit particular profile
 */
function aviators_profile_can_edit() {
    // is admin
    if (current_user_can('manage_options')) {
        return TRUE;
    }

    // is author
    if (get_current_user_id() == get_the_author_meta('id')) {
        return TRUE;
    }

    return FALSE;
}

/**
 * Render actions for profile, if user has permission
 */
function aviators_profile_tabs() {
    if (aviators_profile_can_edit()) {
        $actions = _aviators_profile_tab_links();

        // well, there should not be any reason to include this more than once
        include_once 'templates/tabs.php';
    }
}

/**
 * Get links for managing profile - this is STRICTLY, related to frontend submission, not backend
 */
function _aviators_profile_tab_links() {
    $action = isset($_GET['action']) ? $_GET['action'] : 'view';
    $links = array(
        'view' => array(
            'title' => __('View', 'aviators'),
            'link' => get_permalink(get_the_ID()),
            'active' => $action == 'view',
        ),
        'edit' => array(
            'title' => __('Edit', 'aviators'),
            'link' => get_permalink(get_the_ID()) . '?action=edit',
            'active' => $action == 'edit',
        )
    );

    return $links;
}


/**
 * Get profile page
 * @return mixed
 */
function _aviators_profile_get_profile_page() {

    $pages = get_posts(array(
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-profile.php',
    ));
    $index_page = reset($pages);
    return $index_page;
}

/**
 * @param $user_id
 * @return mixed
 */
function _aviators_profile_get_user_profile_id($user_id) {

    $pages = get_posts(array(
        'post_type' => 'profile',
        'post_author' => $user_id
    ));

    $profile_page = reset($pages);
    return $profile_page;
}

/**
 * Applying filter for processing frontend submission
 *
 * @param $arguments
 */
function aviators_frontend_profile_process($arguments) {
    if ($arguments['type'] == 'profile') {
        $form = $arguments['form'];
        $values = $form->getValues();
        $form->addField('text', array('name', __('Username', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('mail', __('Mail', 'aviators')))
            ->addValidator('required');

        if(aviators_settings_get('profile', 'register', 'password')) {
            $form->addField('password', array('password', __('Password', 'aviators')))
                ->addValidator('required');
            $form->addField('password', array('password_check', __('Retype Password', 'aviators')))
                ->addValidator('required');
        }

        if (isset($values['username'])) {
            $field = $form->getField('username');
            $field->setAttribute('readonly', 'readonly');
        }

        $form->addOnValidation('aviators_validate_profile');
        // add as first of success callbacks
        $form->addOnSuccess('aviators_before_submit_profile', NULL, 'top');
        // add as last of success callbacks
        $form->addOnSuccess('aviators_after_submit_profile', NULL);
    }

    return $arguments;
}
add_filter('hydra_frontend_submission_form', 'aviators_frontend_profile_process', 11, 1);

/**
 * Validation callback if user data filled in profile are correct
 * @param $form
 * @param $values
 * @return array
 */

function aviators_validate_profile($form, $values) {
    $messages = array();

    if (!$values['id']) {
        if (email_exists($values['mail'])) {
            $messages[] = array(__('Email address you provided is already registered in our system', 'aviators'), 'mail');
        }
    }

    if (!filter_var($values['mail'], FILTER_VALIDATE_EMAIL)) {
        $messages[] = array(__('Email address you provided is not valid', 'aviators'), 'mail');
    }

    if(isset($values['name'])) {
        if (username_exists($values['name'])) {
            $messages[] = array(__('Username you provided is already registered in our system', 'aviators'), 'name');
        }
    }

    if(aviators_settings_get('profile', 'register', 'password')) {
        if((isset($values['password']) && isset($values['password_check'])) && ($values['password'] != $values['password_check'])) {
            $messages[] = array(__('Passwords do not match', 'aviators'), 'password');
        }
    }

    return $messages;
}

/**
 * Before submitting data to profile, create actual user
 * @param $form
 * @param $values
 */
function aviators_before_submit_profile($form, $values) {
    // Register user
    if (!$values['post_id'] && isset($values['name'])) {
        $result = aviators_profile_new_user(
            $values['name'],
            $values['mail'],
            $values
        );

        $form->setValue('user_id', $result);
    }
}

/**
 * Associate the created profile with user
 * @param $form
 * @param $values
 */
function aviators_after_submit_profile($form, $values) {
    if($values['id']) {
        $post = get_post($values['id']);
    } else {
        $post = get_post($values['post_id']);
    }

    // associate author
    if (empty($values['id'])) {
        if (isset($values['user_id'])) {
            $post->post_title = $values['name'];
            $post->post_author = $values['user_id'];
            $post->post_status = 'publish';
        }

        if(aviators_settings_get('profile', 'register', 'password')) {
            wp_set_password( $values['password'], $values['user_id'] );
            $form->addSuccessMessage(__('You have been successfully registered. You can now log in.', 'aviators'));
        } else {
            $form->addSuccessMessage(__('You have been successfully registered. You will receive an e-mail with your password.', 'aviators'));
        }
    }
    else {
        $form->addSuccessMessage(__('Your have updated your profile.', 'aviators'));

    }

    $form->setRedirect(site_url());
    wp_update_post((array) $post);
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function aviators_profile_new_user( $user_login, $user_email, $values ) {
    $errors = new WP_Error();

    $sanitized_user_login = sanitize_user( $user_login );
    /**
     * Filter the email address of a user being registered.
     *
     * @since 2.1.0
     *
     * @param string $user_email The email address of the new user.
     */
    $user_email = apply_filters( 'user_registration_email', $user_email );

    // Check the username
    if ( $sanitized_user_login == '' ) {
        $errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
    } elseif ( ! validate_username( $user_login ) ) {
        $errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
        $sanitized_user_login = '';
    } elseif ( username_exists( $sanitized_user_login ) ) {
        $errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
    }

    // Check the e-mail address
    if ( $user_email == '' ) {
        $errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
    } elseif ( ! is_email( $user_email ) ) {
        $errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
        $user_email = '';
    } elseif ( email_exists( $user_email ) ) {
        $errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
    }

    /**
     * Fires when submitting registration form data, before the user is created.
     *
     * @since 2.1.0
     *
     * @param string   $sanitized_user_login The submitted username after being sanitized.
     * @param string   $user_email           The submitted email.
     * @param WP_Error $errors               Contains any errors with submitted username and email,
     *                                       e.g., an empty field, an invalid username or email,
     *                                       or an existing username or email.
     */
    do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

    /**
     * Filter the errors encountered when a new user is being registered.
     *
     * The filtered WP_Error object may, for example, contain errors for an invalid
     * or existing username or email address. A WP_Error object should always returned,
     * but may or may not contain errors.
     *
     * If any errors are present in $errors, this will abort the user's registration.
     *
     * @since 2.1.0
     *
     * @param WP_Error $errors               A WP_Error object containing any errors encountered
     *                                       during registration.
     * @param string   $sanitized_user_login User's username after it has been sanitized.
     * @param string   $user_email           User's email.
     */
    $errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

    if ( $errors->get_error_code() )
        return $errors;

    if(isset($values['password'])) {
        $user_pass = 'your password';
    } else {
        $user_pass = wp_generate_password( 12, false );
    }

    $user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
    if ( ! $user_id || is_wp_error( $user_id ) ) {
        $errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
        return $errors;
    }
    update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

    $user = get_userdata( $user_id );
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
    $message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";
    wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

    $message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
    $message .= sprintf(__('Password: %s'), $user_pass) . "\r\n";
    $message .= wp_login_url() . "\r\n";
    wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);

    return $user_id;
}