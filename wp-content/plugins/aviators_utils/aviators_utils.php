<?php
/*
Plugin Name:    Aviators Utils
Description:    Settings system used in aviators themes
Version:        1.0.0
Author:         Aviators
Author URI:     http://byaviators.com
*/

require_once 'aviators_utils.to.php'; // theme options
require_once 'aviators_utils.wl.php'; // widget logic

add_action('admin_menu', 'aviators_utils_wl_menu');
function aviators_utils_wl_menu() {
    add_management_page(__('Widget Logic Export', 'aviators'), __('Widget Logic Export', 'aviators'), AVIATORS_SETTINGS_CAPABALITY, 'widget-logic-export', 'aviators_utils_wl_export_page');
    add_management_page(__('Widget Logic Import', 'aviators'), __('Widget Logic Import', 'aviators'), AVIATORS_SETTINGS_CAPABALITY, 'widget-logic-import', 'aviators_utils_wl_import_page');

    add_management_page(__('Theme Options Export', 'aviators'), __('Theme Options Export', 'aviators'), AVIATORS_SETTINGS_CAPABALITY, 'theme-options-export', 'aviators_utils_to_export_page');
    add_management_page(__('Theme Options Import', 'aviators'), __('Theme Options Import', 'aviators'), AVIATORS_SETTINGS_CAPABALITY, 'theme-options-import', 'aviators_utils_to_import_page');
}
