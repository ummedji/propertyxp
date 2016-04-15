<?php

function aviators_calculator_settings_definition($definitions) {
    $definitions['calculator'] = array(
        'title' => __('Calculator', 'aviators'),
        'callback' => 'aviators_calculator_settings',
        'tabs' => array(
            'mortgage' => array(
                'title' => __('Mortgage', 'aviators'),
            ),
        ),
    );

    return $definitions;
}
add_filter('aviators_settings_definition', 'aviators_calculator_settings_definition', 10, 1);

function aviators_calculator_settings_defaults($defaults) {
    $defaults['calculator'] = array(
        'mortgage' => array(
            'currency' => '$',
            'display_taxes' => 1,
            'display_insurance' => 1,
            'display_month_table' => 1,
            'display_year_table' => 1,
            'display_total_table' => 1,
            'interest_color' => '#39b54a',
            'taxes_color' => '#B5AE51',
            'insurance_color' => '#ffffff',
        ),

    );

    return $defaults;
}
add_filter('aviators_settings_defaults', 'aviators_calculator_settings_defaults', 10, 1);

function aviators_calculator_settings($form, $tab) {
    switch($tab) {
        case 'mortgage':
            $form->addField('text', array('currency', __('Currency Sign', 'aviators')));

            $form->addField('checkbox', array('display_taxes', __('Display Taxes', 'aviators')));
            $form->addField('checkbox', array('display_insurance', __('Display Insurance', 'aviators')));

            // interval tables
            $form->addField('checkbox', array('display_month_table', __('Display Monthly payments table', 'aviators')));
            $form->addField('checkbox', array('display_year_table', __('Display Yearly payments table', 'aviators')));
            $form->addField('checkbox', array('display_total_table', __('Display Total payments table', 'aviators')));

            $form->addField('text', array('interest_color', __('Interest Color', 'aviators')))
                ->setDefaultValue('#39b54a');
            $form->addField('text', array('taxes_color', __('Taxes Color', 'aviators')))
                ->setDefaultValue('#B5AE51');
            $form->addField('text', array('insurance_color', __('Insurance Color', 'aviators')))
                ->setDefaultValue('#ffffff');


            $form->addField('text', array('home_price', __('Home Price Default', 'aviators')))
                ->addAttribute('placeholder', __('Value of your home', 'aviators'));

            $form->addField('text', array('down_price', __('Down Price Default', 'aviators')))
                ->addAttribute('placeholder', __('Value of your savings', 'aviators'));

            $form->addField('text', array('interest_rate', __('Interest Rate Default', 'aviators')))
                ->addDecorator('suffix', array('%'))
                ->addAttribute('placeholder', __('Enter loan interest rate', 'aviators'));

            $form->addField('text', array('loan_term', __('Loan Term Default', 'aviators')))
                ->addDecorator('suffix', array(__('Months', 'aviators')))
                ->addAttribute('placeholder', __('Number of months', 'aviators'));

            $form->addField('text', array('taxes', __('Taxes Default', 'aviators')))
                ->addDecorator('suffix', array('%'));

            $form->addField('text', array('insurance', __('Insurance Default', 'aviators')))
                ->addDecorator('suffix', array('/year'))
                ->addAttribute('placeholder', __('Insurance per Year', 'aviators'));

            break;
    }
}

function aviators_calculators_mt_setting($name = null) {
    return aviators_settings_get('calculator', 'mortgage', $name);
}


