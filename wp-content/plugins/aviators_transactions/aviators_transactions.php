<?php
/*
Plugin Name:    Aviators Transactions
Description:    PayPal results logging into CPT
Version:        1.0.1
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_transactions.settings.php';
/**
 * Custom post type
 */
add_action('init', 'aviators_transactions_create_post_type');

function aviators_transactions_create_post_type() {
    $labels = array(
        'name' => __('Transactions', 'aviators'),
        'singular_name' => __('Transaction', 'aviators'),
        'add_new' => __('Add new transaction', 'aviators'),
        'add_new_item' => __('Add new transaction', 'aviators'),
        'edit_item' => __('Edit transaction', 'aviators'),
        'new_item' => __('New Transaction', 'aviators'),
        'all_items' => __('All Transactions', 'aviators'),
        'view_item' => __('View Transactions', 'aviators'),
        'search_items' => __('Search transactions', 'aviators'),
        'not_found' => __('No transactions found', 'aviators'),
        'not_found_in_trash' => __('No transactions found in Trash', 'aviators'),
        'parent_item_colon' => '',
        'menu_name' => __('Transactions', 'aviators'),
    );

    register_post_type('transactions',
        array(
            'labels' => $labels,
            'rewrite' => FALSE,
            'supports' => array(),
            'public' => FALSE,
            'query_var' => FALSE,
            'show_ui' => TRUE,
            'has_archive' => FALSE,
            'exclude_from_search' => TRUE,
            'menu_position' => 42,
            'menu_icon' => plugins_url('aviators_transactions/assets/img/icon.png'),
        )
    );
}

function transactions_post_is_paid($post_id) {
    $args = array(
        'post_type' => 'transactions',
        'meta_query' => array(
            array(
                'key' => 'paypal_status',
                'value' => 'paid',
                'compare' => '=',
            ),
            array(
                'key' => 'paypal_status',
                'value' => 'paid',
                'compare' => '=',
            ),
            array(
                'key' => 'payment_type',
                'value' => 'paypal',
                'compare' => '=',
            ),
            array(
                'key' => 'paypal_post_id',
                'value' => $post_id,
                'compare' => '=',
            )
        )
    );

    $query = new WP_Query($args);

    $posts = $query->get_posts();
    if (is_array($posts)) {
        if (count($posts)) {
            return reset($posts);
        }
        else {
            return FALSE;
        }
    }

    return FALSE;
}

new TransactionMetabox();

/**
 * Class TransactionMetabox
 */
class TransactionMetabox {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'addMetabox'));
        add_action('save_post', array($this, 'saveMeta'));
    }

    public function addMetabox() {
        add_meta_box(
            'aviators_transaction_metabox', // $id
            'Transaction data', // $title
            array($this, 'renderForm'), // $callback
            'transactions', // $page
            'normal', // $context
            'high'
        );
    }

    public function renderForm() {
        $this->renderData();
        $form = $this->getForm();
        print $form->render();
    }

    private function renderData() {
        $data = $this->getData();
        $post = get_post($data['paypal_post_id']);
        include 'templates/table.php';
    }

    private function getData() {
        global $post;

        if (!$post) {
            $meta = array();
        }
        else {
            $meta = get_post_meta($post->ID);
        }

        $values = array();
        foreach ($meta as $index => $meta) {
            $values[$index] = reset($meta);
        }

        return $values;
    }

    private function getForm() {
        $values = $this->getData();

        $form = new \Hydra\Builder('form-transaction', '/submit/form-transaction', \Hydra\Builder::FORM_EXTENDER);


        $form->addField('text', array('paypal_cost', __('Cost', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('paypal_post_id', __('Post ID', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('paypal_user_id', __('User ID', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('paypal_payer_id', __('Payer ID', 'aviators')));

        $form->addField('text', array('paypal_status', __('Status', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('paypal_token', __('Token', 'aviators')))
            ->addValidator('required');
        $form->addField('text', array('payment_type', __('Payment Type', 'aviators')))
            ->addValidator('required');

        $form->setValues($values);
        $form->build();

        return $form;
    }

    function saveMeta($post_id) {
        $form = $this->getForm();

        if ($form->validate()) {
            $values = $form->getValues();
            update_post_meta($post_id, 'paypal_cost', $values['paypal_cost']);
            update_post_meta($post_id, 'paypal_post_id', $values['paypal_post_id']);
            update_post_meta($post_id, 'paypal_user_id', $values['paypal_user_id']);
            update_post_meta($post_id, 'paypal_payer_id', $values['paypal_payer_id']);
            update_post_meta($post_id, 'paypal_status', $values['paypal_status']);
            update_post_meta($post_id, 'token', $values['token']);
            update_post_meta($post_id, 'payment_type', $values['payment_type']);
        }
    }
}

/**
 * @param $post_id
 * @return mixed
 */
function aviators_transaction_get_by_post_id($post_id) {
    $query = new WP_Query(array(
        'post_type' => 'transactions',
        'meta_query' => array(
            array(
                'key' => 'paypal_post_id',
                'value' => $post_id,
            ),
            array(
                'key' => 'payment_type',
                'value' => 'package',
            ),
            array(
                'key' => 'expired',
                'value' => FALSE,
            )
        )
    ));

    $results = $query->get_posts();

    if ($results) {
        return reset($results);
    }

    return $post_id;
}

/**
 * Payment gateway
 */
function aviators_transaction_paypal_payment_gateway() {

    require_once 'libraries/paypal-digital-goods/paypal-digital-goods.class.php';
    require_once 'libraries/paypal-digital-goods/paypal-configuration.class.php';
    require_once 'libraries/paypal-digital-goods/paypal-purchase.class.php';
    require_once 'libraries/paypal-digital-goods/paypal-subscription.class.php';

    // @todo sandbox -> live
    if (aviators_settings_get('transaction', 'paypal', 'paypal_enviroment') == 'sandbox') {
        $username = aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_name');
        $password = aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_password');
        $signature = aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_signature');
    }
    else {
        $username = aviators_settings_get('transaction', 'paypal', 'paypal_live_name');
        $password = aviators_settings_get('transaction', 'paypal', 'paypal_live_password');
        $signature = aviators_settings_get('transaction', 'paypal', 'paypal_live_signature');
        PayPal_Digital_Goods_Configuration::environment('live');
    }

    $currency = aviators_settings_get('transaction', 'paypal', 'currency');

    PayPal_Digital_Goods_Configuration::username($username);
    PayPal_Digital_Goods_Configuration::password($password);
    PayPal_Digital_Goods_Configuration::signature($signature);
    PayPal_Digital_Goods_Configuration::currency($currency);


    PayPal_Digital_Goods_Configuration::business_name(get_bloginfo('name'));
}


/**
 * @return bool
 */
function aviators_transaction_configuration_set() {
    static $configurationSet;

    if (isset($configurationSet)) {
        return $configurationSet;
    }

    // submission system

    if (aviators_settings_get('transaction', 'submissions', 'submission_system') != 'free') {
        if (aviators_settings_get('transaction', 'paypal', 'paypal_enviroment') == 'sandbox') {

            if (!aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_name') ||
                !aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_password') ||
                !aviators_settings_get('transaction', 'paypal', 'paypal_sandbox_signature')
            ) {
                $configurationSet = FALSE;
                aviators_add_message(__('Your paypal - sandbox enviroment is not configured properly. Disabling payments', 'aviators'), 'warning');
                return $configurationSet;
            }
        }

        if (aviators_settings_get('transaction', 'paypal', 'paypal_enviroment') == 'live') {
            if (!aviators_settings_get('transaction', 'paypal', 'paypal_live_name') ||
                !aviators_settings_get('transaction', 'paypal', 'paypal_live_password') ||
                !aviators_settings_get('transaction', 'paypal', 'paypal_live_signature')
            ) {
                $configurationSet = FALSE;
                aviators_add_message(__('Your paypal - live enviroment is not configured properly. Disabling payments', 'aviators'), 'warning');
                return $configurationSet;
            }
        }
        $configurationSet = TRUE;
    }
    return $configurationSet;
}

/**
 * Get dummy object of PayPal purchase
 * @return PayPal_Purchase
 */
function aviators_transaction_create_dummy_purchase() {
    aviators_transaction_paypal_payment_gateway();
    aviators_transaction_set_return_paths(0);
    return new PayPal_Purchase();
}

/**
 * Get dummy object of PayPal subscription
 * @return PayPal_Subscription
 */
function aviators_transaction_create_dummy_subscription() {
    aviators_transaction_paypal_payment_gateway();

    aviators_transaction_set_return_paths(0);

    return new PayPal_Subscription();
}

function aviators_transaction_set_return_paths($post_id) {

    PayPal_Digital_Goods_Configuration::return_url(plugins_url('aviators_transactions/aviators_transactions.return.php?paypal=paid&post_id=' . $post_id));
    PayPal_Digital_Goods_Configuration::cancel_url(plugins_url('aviators_transactions/aviators_transactions.return.php?paypal=cancel&post_id=' . $post_id));
    PayPal_Digital_Goods_Configuration::notify_url(plugins_url('aviators_transactions/aviators_transactions.return.php?paypal=notify&post_id=' . $post_id));
}

/**
 * @param $post_id
 * @return PayPal_Purchase
 */
function aviators_transaction_paypal_purchase($post_id) {

    aviators_transaction_paypal_payment_gateway();
    aviators_transaction_set_return_paths($post_id);

    $post = get_post($post_id);

    // prepare default setup and send it to plugins to fill in the appropriate data
    $payment_setup = array(
        'name' => get_bloginfo('name'),
        'post' => $post,
        'type' => aviators_settings_get('transaction', 'submissions', 'submission_system'),
    );


    $payment_setup = apply_filters('aviators_transaction_payment_setup', $payment_setup);
    unset($payment_setup['post']);


    switch ($payment_setup['type']) {
        case "package":
            return new PayPal_Subscription($payment_setup);
            break;
        case "paypal":
        default:
            return new PayPal_Purchase($payment_setup);
            break;
    }
}


/**
 * @param $has_permission
 * @param $post_type
 * @param $post_id
 * @param $action
 * @param $payment_system
 * @return bool
 */
function aviators_transaction_check_permission($has_permission, $post_type, $post_id, $action, $payment_system, $type) {
    // not to be handled as direct paypal payment, return intact value
    if ($payment_system != 'paypal') {
        return $has_permission;
    }

    switch ($action) {
        case "publish":
            $has_permission = transactions_post_is_paid($post_id);

            if (!$has_permission && $type == 'perform') {
                $post = get_post($post_id);
                aviators_add_message(sprintf(__('You need to pay for %s if you wish to publish it', 'aviators'), $post->post_title));
            }
            break;
    }

    return (bool)$has_permission;
}
add_filter('aviators_submission_has_permission', 'aviators_transaction_check_permission', 10, 6);

/**
 * @param $post_id
 */
function aviators_transaction_paypal_button_link($post_id) {
    $post = get_post($post_id);

    if (is_user_logged_in()) {
        if($post->post_type == 'package') {
            if (!aviators_packages_is_package_active()) {
                $args = aviators_transaction_paypal_purchase($post_id)->get_buy_button();
                return $args['href'];
            } else {
                return false;
            }
        } else {
            $args = aviators_transaction_paypal_purchase($post_id)->get_buy_button();
            return $args['href'];
        }
    } else {
        return false;
    }
}

function aviators_transaction_paypal_button_text($post_id) {
    $post = get_post($post_id);
    if (is_user_logged_in()) {
        if($post->post_type == 'package') {
            if (aviators_packages_is_package_active()) {
                return __('Already Purchased', 'aviators');
            } else {
                return __('Purchase', 'aviators');
            }
        }
    } else {
        return __('Register First', 'aviators');
    }

    return false;
}

/**
 * Utility function - check if transaction is in expired state
 * @param $transaction_id
 * @return bool
 */
function aviators_transaction_is_expired($transaction_id) {
    return get_post_meta($transaction_id, 'expired', true);
}

/**
 * Utility function - used mainly for packages
 * Sets expired flag to true, that will result in ignoring the attached package
 * @param $transaction_id
 */
function aviators_transaction_disable($transaction_id) {
    update_post_meta($transaction_id, 'expired', true);
}

/**
 * Utility function - used mainly for packages
 * Sets expired flag to false, that means package will be still active
 * @param $transaction_id
 */
function aviators_transaction_enable($transaction_id) {
    update_post_meta($transaction_id, 'expired', false);
}