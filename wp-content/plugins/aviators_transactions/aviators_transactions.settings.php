<?php

function aviators_transaction_settings_definition($definitions) {
    $definitions['transaction'] = array(
        'title' => __('Payment System', 'aviators'),
        'callback' => 'aviators_transaction_settings',
        'tabs' => array(
            'paypal' => array(
                'title' => __('Paypal', 'aviators'),
            ),
            'submissions' => array(
                'title' => __('Submission', 'aviators'),
            )
        ),
    );

    return $definitions;
}

add_filter('aviators_settings_definition', 'aviators_transaction_settings_definition', 10, 1);


/**
 * Property defaults
 * @param $defaults
 * @return mixed
 */
function aviators_transaction_settings_defaults($defaults) {
    $defaults['transaction'] = array(
        'paypal' => array(
            'currency' => 'USD',
        ),
    );

    return $defaults;
}
add_filter('aviators_settings_defaults', 'aviators_transaction_settings_defaults', 10, 1);

function aviators_transaction_settings($form, $tab) {
    switch ($tab) {
        case 'paypal':
            $form->addField('select', array('paypal_enviroment', 'Enviroment'))
                ->setOptions(array(
                    'sandbox' => 'Sandbox',
                    'live' => 'Live',
                ))
                ->setDescription('Sandbox account is used purely for testing purposes', 'aviators');

            $form->addField('text', array('paypal_live_name', __('Username', 'aviators')))
                ->setDescription(__('This information is obtained from your paypal account', 'aviators'));
            $form->addField('text', array('paypal_live_password', __('Password', 'aviators')))
                ->setDescription(__('This information is obtained from your paypal account', 'aviators'));
            $form->addField('text', array('paypal_live_signature', __('Signature', 'aviators')))
                ->setDescription(__('This information is obtained from your paypal account', 'aviators'));

            $form->addField('text', array('paypal_sandbox_name', __('Sandbox Username', 'aviators')));
            $form->addField('text', array('paypal_sandbox_password', __('Sandbox Password', 'aviators')));
            $form->addField('text', array('paypal_sandbox_signature', __('Sandbox Signature', 'aviators')));

            $form->addField('text', array('currency', __('Currency', 'aviators')))
                ->setDefaultValue('USD');

            $form->addField('text', array('property_payment', __('Property publishing fee', 'aviators')))
                ->setDefaultvalue('10')
                ->addValidator('numeric');
            $form->addField('text', array('property_tax', __('Property publishing taxes', 'aviators')))
                ->setDefaultvalue('0')
                ->addValidator('numeric');

            $form->addField('text', array('agent_payment', __('Agent publishing fee', 'aviators')))
                ->setDefaultvalue('15')
                ->addValidator('numeric');
            $form->addField('text', array('agent_tax', __('Agent publishing taxes', 'aviators')))
                ->setDefaultvalue('0')
                ->addValidator('numeric');

            $form->addField('text', array('agency_payment', __('Agency publishing fee', 'aviators')))
                ->setDefaultvalue('20')
                ->addValidator('numeric');

            $form->addField('text', array('agency_tax', __('Agency publishing taxes', 'aviators')))
                ->setDefaultvalue('0')
                ->addValidator('numeric');

            break;
        case 'submissions':
            $form->addField('select', array('submission_system', __('Submission system', 'aviators')))
                ->setOptions(array(
                    'free' => __('Free', 'aviators'),
                    'paypal' => __('Paypal', 'aviators'),
                    'package' => __('Packages', 'aviators'),
            ));
            // package
            break;
    }
}