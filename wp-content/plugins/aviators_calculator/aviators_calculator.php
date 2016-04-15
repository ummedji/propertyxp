<?php
/*
Plugin Name:    Aviators Calculator
Description:    Mortgage and Affordibility calculator
Version:        1.0.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_calculator.settings.php';

function aviators_calculator_mortgage_shortcode($attributes, $content = NULL) {
    extract(shortcode_atts(array(), $attributes));

    if(isset($_GET['mortgage'])) {
        $values = $_GET['mortgage'];
    } else {
        $values = aviators_calculators_mt_setting();
    }

    $results = aviators_calculator_results($values);

    $data = array();

    if ($results['interest']) {
        $data = array(
            array(
                'value' => $results['interest'],
                'title' => __('Interest', 'aviators'),
                'index' => 'interest',
                'color' => aviators_calculators_mt_setting('interest_color'),
            ),
        );
    }

    if ($results['taxes']) {
        $data[] = array(
            'value' => $results['taxes'],
            'index' => 'taxes',
            'title' => __('Taxes', 'aviators'),
            'color' => aviators_calculators_mt_setting('taxes_color'),
        );
    }

    if ($results['insurance']) {
        $data[] = array(
            'value' => $results['insurance'],
            'title' => __('Insurance', 'aviators'),
            'index' => 'insurance',
            'color' => aviators_calculators_mt_setting('insurance_color'),
        );
    }

    $js_array = json_encode($data);
    $form = aviators_calculator_mortgage_form();
    $currency = aviators_calculators_mt_setting('currency');

    $monthly_summary = 0;
    foreach ($data as $item) {
        $monthly_summary += $item['value'];
    }

    ob_start();
    include 'templates/mortgage_calculator.php';
    return ob_get_clean();
}

add_shortcode('mortgage_calculator', 'aviators_calculator_mortgage_shortcode');

/**
 * @param $data
 */
function aviators_calculator_monthly_table($data) {
    if (empty($data)) {
        return;
    }
    $currency = aviators_calculators_mt_setting('currency');
    $title = __('Monthly payments', 'aviators');
    $footer_title = __('Total per Month:', 'aviators');
    $total_summary = 0;
    foreach ($data as $item) {
        $total_summary += $item['value'];
    }

    include 'templates/mortgage_table.php';
}

/**
 * @param $data
 */
function aviators_calculator_yearly_table($data) {
    if (empty($data)) {
        return;
    }
    $currency = aviators_calculators_mt_setting('currency');
    $title = __('Yearly payments', 'aviators');
    $footer_title = __('Total per Year:', 'aviators');

    $months = 12;
    $total_summary = 0;
    foreach ($data as $index => $item) {
        $data[$index]['value'] *= $months;
        $total_summary += $data[$index]['value'];
    }

    include 'templates/mortgage_table.php';
}

/**
 * @param $data
 */
function aviators_calculator_total_table($data) {
    if (empty($data)) {
        return;
    }

    $currency = aviators_calculators_mt_setting('currency');
    $title = __('Total payments', 'aviators');
    $footer_title = __('Total:', 'aviators');

    if(isset($_GET['mortgage'])) {
        $months = $_GET['mortgage']['loan_term'];
    } else {
        $months = aviators_calculators_mt_setting('loan_term');
    }
    $total_summary = 0;
    foreach ($data as $index => $item) {
        $data[$index]['value'] *= $months;
        $total_summary += $data[$index]['value'];
    }


    include 'templates/mortgage_table.php';
}

/**
 * Add javascript rendering
 */
function aviators_calculator_enqueue_script() {
    wp_enqueue_script('aviators_calculator', plugins_url() . '/aviators_calculator/aviators_calculator.js', array('jquery'));
    wp_enqueue_style('aviators_calculator', plugins_url() . '/aviators_calculator/aviators_calculator.css');
}

add_action('wp_enqueue_scripts', 'aviators_calculator_enqueue_script'); // wp_enqueue_scripts action hook to link only on the front-end

function aviators_calculator_mortgage_form() {
    $form = new \Hydra\Builder('mortgage');

    $url = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $url = parse_url($url);

    $currency = aviators_calculators_mt_setting('currency');
    $form->addField('hidden', array('return', $url['path']));

    $form->addField('text', array('home_price', __('Principal', 'aviators')))
        ->addDecorator('prefix', array($currency))
        ->addValidator('required')
        ->addAttribute('placeholder', __('Value of your home', 'aviators'));

    $form->addField('text', array('down_price', __('Down Price', 'aviators')))
        ->addValidator('required')
        ->addDecorator('prefix', array($currency))
        ->addAttribute('placeholder', __('Value of your savings', 'aviators'));

    $form->addField('text', array('interest_rate', __('Interest Rate', 'aviators')))
        ->addValidator('required')
        ->addDecorator('suffix', array('%'))
        ->addAttribute('placeholder', __('Enter loan interest rate', 'aviators'));

    $form->addField('text', array('loan_term', __('Loan Term', 'aviators')))
        ->addValidator('required')
        ->addDecorator('suffix', array(__('Months', 'aviators')))
        ->addAttribute('placeholder', __('Number of months', 'aviators'));

    if (aviators_calculators_mt_setting('display_taxes')) {
        $form->addField('text', array('taxes', __('Taxes', 'aviators')))
            ->addValidator('required')
            ->addDecorator('suffix', array('%'));
    }

    if (aviators_calculators_mt_setting('display_insurance')) {
        $form->addField('text', array('insurance', __('Insurance', 'aviators')))
            ->addDecorator('suffix', array($currency . '/year'))
            ->addValidator('required')
            ->addAttribute('placeholder', __('Insurance per Year', 'aviators'));
    }

    $form->addField('submit', array('submit', __('Calculate', 'aviators')))
        ->addAttribute('class', 'btn btn-primary');

    $form->addOnValidation('aviators_calculator_mortgage_validate');
    $form->addOnSuccess('aviators_calculator_mortgage_submit');

    $settings = aviators_calculators_mt_setting();
    $form->setValues($settings);

    if (isset($_GET['mortgage'])) {
        $form->setValues($_GET['mortgage']);
    }


    $form->build();
    return $form;
}

/**
 * Validation callback
 * @param $form
 * @param $value
 * @return array
 */
function aviators_calculator_mortgage_validate($form, $value) {
    if ($value['home_price'] <= $value['down_price']) {
        return array(
            array(__('Home price cannot be lesser than down price', 'aviators'), 'home_price')
        );
    }
}

/**
 * Submission callback
 * @param $form
 * @param $values
 */
function aviators_calculator_mortgage_submit($form, $values) {
    $values = $form->clearSubmitValues($values);
    $return = $values['return'];
    unset($values['return']);
    unset($values['submit']);
    $query = http_build_query(array('mortgage' => $values));

    $form->setRedirect($return . '?' . $query);
}


function aviators_calculator_results($values) {
    // no values
    if (!$values) {
        return array(
            'interest' => FALSE,
            'insurance' => FALSE,
            'taxes' => FALSE,
        );
    }

    // calculate interest -----
    // monthly interest rate
    $interest = 0;
    $mir = ($values['interest_rate'] / 12) / 100;
    // amount borrowed
    $P = $values['home_price'] - $values['down_price'];
    $interest = ($mir * ($P)) / (1 - (pow((1 + $mir), ($values['loan_term'] * -1))));
    $interest = round($interest);

    // calculate property taxes -----
    $taxes = FALSE;
    if (aviators_calculators_mt_setting('display_taxes')) {
        $taxes = ($values['home_price'] / 100 * $values['taxes']) / 12;
        $taxes = round($taxes);
    }

    // calculate insurance
    $insurance = FALSE;
    if (aviators_calculators_mt_setting('display_insurance')) {
        $insurance = $values['insurance'] / 12;
        $insurance = round($insurance);
    }

    return array(
        'interest' => $interest,
        'insurance' => $insurance,
        'taxes' => $taxes,
    );
}



