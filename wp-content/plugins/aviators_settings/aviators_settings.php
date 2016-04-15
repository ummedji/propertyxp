<?php
/*
Plugin Name:    Aviators Settings
Description:    Settings system used in aviators themes
Version:        1.1.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

define('AVIATORS_SETTINGS_CAPABALITY', 'edit_pages');


if (TRUE) {
    // symbolic link - messed up wordpress
    define('AVIATORS_SETTINGS_DIR', ABSPATH . '/wp-content/plugins/aviators_settings');
    define('AVIATORS_SETTINGS_URL', plugins_url() . '/aviators_settings');
}
else {
    define('AVIATORS_SETTINGS_DIR', trailingslashit(get_template_directory()) . trailingslashit(basename(dirname(__FILE__))));
    define('AVIATORS_SETTINGS_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));
}

add_action('admin_menu', 'aviators_settings_admin_menu');
function aviators_settings_admin_menu($default_item) {
    $icon = AVIATORS_SETTINGS_URL . '/assets/img/icon.png';

    $definitions = aviators_settings_get_definitions();
    $keys = array_keys($definitions);
    $initial_slug = reset($keys);

    add_menu_page(__('Settings', 'aviators'), __('Settings', 'aviators'), AVIATORS_SETTINGS_CAPABALITY, $initial_slug, 'aviators_settings_render_settings_page', $icon, 31);

    foreach($definitions as $slug => $definition) {
        add_submenu_page($initial_slug, $definition['title'], $definition['title'], AVIATORS_SETTINGS_CAPABALITY, $slug, 'aviators_settings_render_settings_page');
    }
}

function aviators_settings_enqueue_style() {
    wp_register_style('aviators-settings', plugins_url() . '/aviators_settings/assets/css/admin.css');
    wp_enqueue_style('aviators-settings');
}
add_action('admin_init', 'aviators_settings_enqueue_style');


/**
 * Main page render
 */
function aviators_settings_render_settings_page() {
    $page = $_GET['page'];
    $definition = aviators_settings_get_definition($page);
    $tabs = $definition['tabs'];

    if(isset($_GET['tab'])) {
        $active_tab = $_GET['tab'];
    } else {
        $keys = array_keys($definition['tabs']);
        $active_tab = reset($keys);
    }

    $form = new \Hydra\Builder('aviators_settings', '/submit/aviators_settings');
    $form->addField('hidden',  array('page', $page));
    $form->addField('hidden', array('tab', $active_tab));

    $fieldset = $form->addField('fieldset', array($active_tab, 'Tab'))
        ->isRenderable(false);
    $fieldset->addDecorator('table');

    call_user_func($definition['callback'], $fieldset, $active_tab);

    $form->setValues(array($active_tab => aviators_settings_get($page,  $active_tab)));

    $form->addField('submit', array('submit', __('Save', 'aviators_settings')));
    $form->addOnSuccess('aviators_settings_save');
    $form->build();

    include('templates/wrapper.php');
}


function aviators_settings_save($form, $values) {
    $name = 'aviators_settings_' . $values['page'] . '_' . $values['tab'];
    update_option($name, $values[$values['tab']]);
}

function aviators_settings_get($page, $group, $field = null) {
    $options = get_option('aviators_settings_' . $page . '_' . $group);
    // options do not exist, revert to default
    if(!$options) {
        $defaults = aviators_settings_get_default($page, $group);

        if($field && isset($defaults[$field])) {
            return $defaults[$field];
        }
        return $defaults;
    }

    if($field) {
        if(isset($options[$field])) {
            return $options[$field];
        } else {
            return false;
        }
    }
    return $options;
}


/**
 * Get settings pages/tabs definitions
 * @return mixed|void
 */
function aviators_settings_get_definitions() {
    static $aviators_settings_definitions;

    if(!empty($aviators_settings_definitions)) {
        return $aviators_settings_definitions;
    }

    $definitions = array();
    $definitions = apply_filters('aviators_settings_definition', $definitions);

    return $aviators_settings_definitions = $definitions;
}

/**
 * Get settings page single definition
 * @param $page
 * @return mixed
 */
function aviators_settings_get_definition($page) {
    $definition = aviators_settings_get_definitions();
    return $definition[$page];
}

/**
 * Get default values for form/settings
 * @param $mixed
 */
function aviators_settings_get_defaults() {
    static $aviators_settings_defaults;

    if(!empty($aviators_settings_defaults)) {
        return $aviators_settings_defaults;
    }

    $defaults = array();
    $defaults = apply_filters('aviators_settings_defaults', $defaults);

    return $aviators_settings_defaults = $defaults;
}

/**
 * Get defaults for single page of settings
 * @param $page
 * @return mixed
 */
function aviators_settings_get_default($page, $tab = null) {
    $defaults = aviators_settings_get_defaults();
    if(!$tab) {
        return $defaults[$page];
    } else {
        if (!empty($defaults[$page][$tab])) {
            return $defaults[$page][$tab];
        }
    }
}

/**
 * @param $page
 * @param $tab
 * @return string
 */
function aviators_settings_get_settings_path($page, $tab) {
    return site_url() . "/wp-admin/admin.php/?page={$page}&tab={$tab}";
}

function aviators_settings_export() {
    if(!isset($_GET['aviators-settings-export'])) {
        return;
    }
    $definitions = aviators_settings_get_definitions();
    $settings = array();
    foreach($definitions as $page => $definition) {
        foreach($definition['tabs'] as $group => $tab) {
            $name = 'aviators_settings_' . $page . '_' . $group;
            $value = aviators_settings_get($page, $group);
            if($value) {
                $settings[$name] = $value;
            }
        }
    }

    $string = json_encode($settings);
    print $string;
    exit;
}
add_action('admin_init', 'aviators_settings_export');

function aviators_settings_import() {
    // only once, import
    if(!get_option('aviators_settings_import', false)) {
        update_option('aviators_settings_import', 1);

        $string = '{"aviators_settings_agent_archive":{"title":"Agents","display_type":"row"},"aviators_settings_calculator_mortgage":{"currency":"$","display_taxes":"on","display_insurance":"on","display_month_table":"on","display_year_table":"on","display_total_table":"on","interest_color":"#cd2122","taxes_color":"#669900","insurance_color":"#0099FF","home_price":"250000","down_price":"50000","interest_rate":"5","loan_term":"360","taxes":"1.5","insurance":"800"},"aviators_settings_package_archive":{"title":"Packages","number":"3","merged":"on","weight":{"1789":"2","1790":"1","254":"3"}},"aviators_settings_package_1815":{"title_position":"center","disable_sidebar":"on","number":"4","merged":"on","weight":{"1819":"4","1789":"2","1790":"1","254":"3"}},"aviators_settings_property_archive":{"title":"Properties","display_type":"row","sort":"on","sort_options":{"title":"title","created":"created","26":"26","22":"22","23":"23","24":"24","25":"25"},"sort_default":"title","sort_order_default":"ASC"},"aviators_settings_property_1781":{"display_type":"row","isotope_taxonomy":"types","display_pager":"on","pager":"10","sort":"0","sort_default":"title","sort_order_default":"ASC"},"aviators_settings_property_1776":{"display_type":"grid","pager":"1","sort":"on","sort_options":{"title":"title","created":"created","26":"26","22":"22","23":"23","24":"24","25":"25"},"sort_default":"title","sort_order_default":"ASC","types":{"47":"47","48":"48","49":"49"}},"aviators_settings_property_1754":{"disable_sidebar":"on","display_type":"isotope","isotope_taxonomy":"types","display_pager":"0","pager":"8","sort":"0","sort_options":{"title":"title","created":"created","26":"26","22":"22","23":"23","24":"24","25":"25"},"sort_default":"title","sort_order_default":"ASC"},"aviators_settings_submission_general":{"enabled_types":{"property":"property","agent":"agent","agency":"agency"},"submission_index":"property","display_link":"on"},"aviators_settings_transaction_paypal":{"paypal_enviroment":"sandbox","paypal_live_name":"","paypal_live_password":"","paypal_live_signature":"","paypal_sandbox_name":"","paypal_sandbox_password":"","paypal_sandbox_signature":"","property_payment":"10","property_tax":"5","agent_payment":"15","agent_tax":"","agency_payment":"20","agency_tax":"5"},"aviators_settings_transaction_submissions":{"submission_system":"free"}}';
        $settings = json_decode($string, true);

        foreach($settings as $key => $value) {
            update_option($key, (array)$value);
        }
    }
}

add_action('admin_init', 'aviators_settings_import');