<?php

/**
 * @note: With current setup of the framework, we should never process more than one item.
 * As there is no shopping cart only direct payment for product.
 * Note that this function does rely on this fact ...ehm "fact"
 * @param $payment_setup
 * @return array
 */
function aviators_package_payment_setup($payment_setup) {
    $post = $payment_setup['post'];


    if ($post->post_type != 'package') {
        // not our concern, leave intact
        return $payment_setup;
    }

    $data = aviators_package_get_data($post->ID);
    $price = isset($data['price']) ? $data['price'] : 0;
    $tax = isset($data['tax']) ? $data['tax'] : 0;
    $amount = $price + $tax;

    $description = sprintf(__('Subscription for %s', 'aviators'), $post->post_title);

    $payment_setup += array(
        'description'         => $description,
        'invoice_number'      => '',
        'max_failed_payments' => 1,
        // Price
        'amount'              => $amount,
        'initial_amount'      => 0,
        'average_amount'      => $amount,
        'tax_amount'          => 0,
        // Temporal Details
        'start_date'          => date( 'Y-m-d\TH:i:s', time() + ( 24 * 60 * 60 ) ),
        'period'              => isset($data['period']) ? $data['period'] : 'Month',
        'frequency'           => '1',
        'total_cycles'        => '0', // well this will be unlimited by default
        // Trial Period
        'trial_amount'        => '0.00',
        'trial_period'        => isset($data['trial_period']) ? $data['trial_period'] : 'Month',
        'trial_frequency'     => '0',
        'trial_total_cycles'  => '0',
        // Miscellaneous
        'add_to_next_bill'    => true,
    );

    return $payment_setup;
}
add_filter('aviators_transaction_payment_setup', 'aviators_package_payment_setup');

//function test_profile() {
//    $profile = aviators_package_get_payment_profile(1921);
//    var_dump($profile);
//}
//add_action('init', 'test_profile');

/**
 * Get single subscription profile for particular transaction
 * @param $transaction_id
 * @return array
 */
function aviators_package_get_payment_profile($transaction_id) {
    $profile_id = get_post_meta($transaction_id, 'paypal_profile_id', true);
    $subscription = aviators_transaction_create_dummy_subscription();
    return $subscription->get_profile_details($profile_id);
}


/**
 * @param $profile
 * @return bool
 */
function aviators_package_is_paid($profile) {

    // according to paypal recurring payments documentation this should be all that needs to be done if payments are ok
    // @todo however there are still some doubts how will it be when just partial payments are done and so on.
    if($profile['STATUS'] != 'Active') {
        return false;
    }

    return true;
}

//manage_subscription_status

