<?php


/**
 * Applying filter for processing frontend submission
 * @param $arguments
 */
function aviators_submission_process_form($arguments) {
    $form = $arguments['form'];
    $form->addOnValidation('aviators_submission_form_validate', NULL);
    $form->addOnSuccess('aviators_submission_form_submit', NULL);

    return $arguments;
}
add_filter('hydra_frontend_submission_form', 'aviators_submission_process_form', 10, 1);



/**
 * Validation callback
 * @param $form
 * @param $values
 */
function aviators_submission_form_validate($form, $values) {

}

/**
 * Submission callback
 * @param $form
 * @param $values
 */
function aviators_submission_form_submit($form, $values) {
    $post_type = $values['post_type'];

    if(!in_array($post_type, array('property', 'agent', 'agency'))) {
        return;
    }

    //updated
    if(isset($values['id']) && !empty($values['id'])) {
        $form->addSuccessMessage(_(sprintf('%s was successfully updated.', $values['post_title'])));
    } else {
        //created
        $form->addSuccessMessage(_(sprintf('%s was successfully created.', $values['post_title'])));
    }

    $index_page = aviators_submission_get_submission_page($post_type, 'index');
    $form->setRedirect(get_permalink($index_page->ID));
}


/**
 * @note: With current setup of the framework, we should never process more than one item.
 * As there is no shopping cart only direct payment for product.
 * Note that this function does rely on this fact ...ehm "fact"
 * @param $payment_setup
 */
function aviators_submission_payment_setup($payment_setup) {

    $post = $payment_setup['post'];

    // we are handling only post types with enabled frontend submission
    if(!in_array($post->post_type, aviators_submission_get_enabled_submission_types())) {
        return $payment_setup;
    }

    $post_meta = get_post_meta($post->ID);

    // @todo this comes from settings
    $price = aviators_settings_get('transaction', 'paypal', $post->post_type . '_payment');
    $tax = aviators_settings_get('transaction', 'paypal', $post->post_type . '_tax');

    $payment_setup['amount'] = $price + $tax;
    $payment_setup['tax_amount'] = $tax;

    $item = array(
        'item_name' => $post->post_title,
        'item_description' => '',
        'item_amount' => $price,
        'item_tax' => $tax,
        'item_quantity' => 1,
        'item_number' => $post->ID,
    );

    $payment_setup['items'][0] = $item;
    return $payment_setup;
}
add_filter('aviators_transaction_payment_setup', 'aviators_submission_payment_setup');

/**
 * Process the data from payment before they are saved
 * In this case we need to alter the payment type value to 'package'
 * @param $data
 * @return mixed
 */
function aviators_submission_payment_save($data) {
    // we are handling only post types with enabled frontend submission
    if(in_array(get_post_type($data['paypal_post_id']), aviators_submission_get_enabled_submission_types())) {
        $type = get_post_type($data['paypal_post_id']);
        $data['payment_type'] = 'paypal';

        $price = aviators_settings_get('transaction', 'paypal', $type . '_payment');
        $tax = aviators_settings_get('transaction', 'paypal', $type . '_tax');
        $price = $price + $tax;
        $data['paypal_cost'] = $price;
    }
    return $data;
}
add_filter('aviators_transaction_before_save', 'aviators_submission_payment_save');
