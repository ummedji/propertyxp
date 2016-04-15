<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

// transaction is always created, to have some sort of logging but they can fail..
$transaction_id = wp_insert_post(array(
    'post_title' => 'Transaction ' . mysql2date(get_option('date_format'), date("Y-m-d H:i:s")),
    'post_type' => 'transactions',
    'post_status' => 'publish',
));

// default transaction data to be saved
$transaction_data = array(
    'paypal_status' => $_GET['paypal'],
    'paypal_user_id' => get_current_user_id(),
    'paypal_cost' => 0,
    'paypal_status' => $_GET['paypal'],
    'paypal_post_id' => $_GET['post_id'],
    'paypal_token' => $_GET['token'],
    'paypal_payer_id' => isset($_GET['PayerID']) ? $_GET['PayerID'] : 0,
    'payment_type' => '',
    'expired' => FALSE,
);

switch ($_GET['paypal']) {
    case 'paid':
        aviators_add_message(__('Paypal transaction was successful.', 'aviators'), 'success');

        $paypalPurchase = aviators_transaction_paypal_purchase($_GET['post_id']);

        // final request to start off subscription
        if($paypalPurchase instanceof PayPal_Subscription) {
            $data = $paypalPurchase->start_subscription();
            // one more important information we are getting
            $transaction_data['paypal_profile_id'] = $data['PROFILEID'];
            // there are more information but we don't really require them
        }

        // final request to finish off payment
        if($paypalPurchase instanceof PayPal_Purchase) {
            $paypalPurchase->process();
        }


        // alter the data of transaction before saving them
        $transaction_data = apply_filters('aviators_transaction_before_save', $transaction_data);
        foreach ($transaction_data as $index => $value) {
            update_post_meta($transaction_id, $index, $value);
        }

        break;
    case 'cancel':
        aviators_add_message(__('Paypal transaction was canceled.', 'aviators'), 'danger');
        break;
    case 'notify':
        // @todo - what does notify mean ?
        break;
    default:
        aviators_add_message(__('Payment failed, please contact site administrator for more information', 'aviators'), 'danger');
        break;
}

// redirect home
// @todo add redirect to appropriate page
return wp_redirect(home_url());