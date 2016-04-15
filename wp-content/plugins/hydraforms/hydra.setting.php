<?php

/**
 * Get single definition
 * @param $name
 * @return bool
 */
function hydra_field_get_definition($name) {
    $field_definitions = hydra_field_definition();

    if (isset($field_definitions[$name])) {
        return $field_definitions[$name];
    }

    return FALSE;
}

/**
 * Get array of field definitions options
 * @return array
 */
function hydra_field_get_definition_options() {
    $field_definitions = hydra_field_definition();
    $options = array();

    foreach ($field_definitions as $machine_name => $field) {
        $options[$machine_name] = $field['name'];
    }

    return $options;
}

/**
 * Collect all the field definitions provided
 * @return array
 */
function hydra_field_definition() {

    // static cache
    static $hydra_field_settings;
    if (!empty($hydra_field_settings)) {
        return $hydra_field_settings;
    }
    // definitions which come directly with basic hydra package
    $field_definitions = array(
        'textarea' => array(
            'name' => __('Text Area', 'hydraforms'),
            'class' => 'Hydra\Definitions\TextareaDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/TextareaDefinition.php',
            'default_widget' => 'textarea',
            'default_formatter' => 'longtext',
        ),
        'mail' => array(
            'name' => __('E-mail', 'hydraforms'),
            'class' => 'Hydra\Definitions\MailDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/MailDefinition.php',
            'default_widget' => 'mail',
            'default_formatter' => 'basic',
        ),
        'link' => array(
            'name' => __('Link', 'hydraforms'),
            'class' => 'Hydra\Definitions\LinkDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/LinkDefinition.php',
            'default_widget' => 'link',
            'default_formatter' => 'link',
        ),
        'text' => array(
            'name' => __('Text', 'hydraforms'),
            'class' => 'Hydra\Definitions\TextDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/TextDefinition.php',
            'default_widget' => 'text',
            'default_formatter' => 'basic',
        ),
        'number' => array(
            'name' => __('Number', 'hydraforms'),
            'class' => 'Hydra\Definitions\NumberDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/NumberDefinition.php',
            'default_widget' => 'number',
            'default_formatter' => 'number',
        ),
        'checkbox' => array(
            'name' => __('Checkbox', 'hydraforms'),
            'class' => 'Hydra\Definitions\CheckboxDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/CheckboxDefinition.php',
            'default_widget' => 'checkbox',
            'default_formatter' => 'basic',
        ),
        'image' => array(
            'name' => __('Image', 'hydraforms'),
            'class' => 'Hydra\Definitions\ImageDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/ImageDefinition.php',
            'default_widget' => 'image',
            'default_formatter' => 'image',
        ),
        'date' => array(
            'name' => __('Date', 'hydraforms'),
            'class' => 'Hydra\Definitions\DateDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/DateDefinition.php',
            'default_widget' => 'date',
            'default_formatter' => 'date'
        ),
        'date_range' => array(
            'name' => __('Date Range', 'hydraforms'),
            'class' => 'Hydra\Definitions\DateRangeDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/DateRangeDefinition.php',
            'default_widget' => 'date_range',
            'default_formatter' => 'date'
        ),
        'datetime' => array(
            'name' => __('Date Time', 'hydraforms'),
            'class' => 'Hydra\Definitions\DatetimeDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/DatetimeDefinition.php',
            'default_widget' => 'date',
            'default_formatter' => 'datetime'
        ),
        'datetime_range' => array(
            'name' => __('Date Time Range', 'hydraforms'),
            'class' => 'Hydra\Definitions\DatetimeRangeDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/DatetimeRangeDefinition.php',
            'default_widget' => 'date_range',
            'default_formatter' => 'datetime'
        ),
        'taxonomy' => array(
            'name' => __('Taxonomy', 'hydraforms'),
            'class' => 'Hydra\Definitions\TaxonomyDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/TaxonomyDefinition.php',
            'default_widget' => 'checkboxes',
            'default_formatter' => 'taxonomy',
        ),
        'reference' => array(
            'name' => __('Post Reference', 'hydraforms'),
            'class' => 'Hydra\Definitions\ReferenceDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/ReferenceDefinition.php',
            'default_widget' => 'checkboxes',
            'default_formatter' => 'post',
        ),
        'week' => array(
            'name' => __('Opening Hours', 'hydraforms'),
            'class' => 'Hydra\Definitions\WeekDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/WeekDefinition.php',
            'default_widget' => 'week',
            'default_formatter' => 'week',
        ),
        'pricing' => array(
            'name' => __('Pricing Table', 'hydraforms'),
            'class' => 'Hydra\Definitions\PricingDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/PricingDefinition.php',
            'default_widget' => 'pricing_table',
            'default_formatter' => 'pricing_table',
        ),
        'fieldset' => array(
            'name' => __('Field Group', 'hydraforms'),
            'class' => 'Hydra\Definitions\FieldsetDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/FieldsetDefinition.php',
            'default_widget' => NULL, // none for fieldset
            'default_formatter' => NULL, // none for fieldset
        ),
        'options' => array(
            'name' => __('Options List', 'hydraforms'),
            'class' => 'Hydra\Definitions\OptionsDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/OptionsDefinition.php',
            'default_widget' => 'select', // none for fieldset
            'default_formatter' => NULL, // none for fieldset
        ),
        'rating' => array(
            'name' => __('Rating', 'hydraforms'),
            'class' => 'Hydra\Definitions\RatingDefinition',
            'file' => plugin_dir_path(__FILE__) . 'hydra/definition/RatingDefinition.php',
            'default_widget' => 'select',
            'default_formatter' => NULL,
        ),
    );

    $field_definitions = apply_filters('hydra_field_definition', $field_definitions);
    return $hydra_field_settings = $field_definitions;
}

/**
 * Get Single widget
 * @param $name
 * @return bool
 */
function hydra_widget_get_widget($name) {
    $widget_definitions = hydra_widget_definition();
    if (isset($widget_definitions[$name])) {
        return $widget_definitions[$name];
    }

    return FALSE;
}

/**
 * Get available widgets for definition type
 * @param $type
 * @return array
 */
function hydra_widget_get_widgets_for_type($type) {
    $widgets = hydra_widget_definition();

    $options = array();
    foreach ($widgets as $name => $settings) {
        if (in_array($type, $settings['field_types'])) {
            $options[$name] = $settings['name'];
        }
    }

    return $options;
}

/**
 * Collect all widget definitions
 * @return array
 */
function hydra_widget_definition() {

    // static cache
    static $hydra_widget_definitions;
    if (!empty($hydra_widget_definitions)) {
        return $hydra_widget_definitions;
    }

    $widget_definitions = array(
        'text' => array(
            'name' => __('Text', 'hydraforms'),
            'class' => 'Hydra\Widgets\TextWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Text.php',
            'field_types' => array('text'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'link' => array(
            'name' => __('Link', 'hydraforms'),
            'class' => 'Hydra\Widgets\LinkWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Link.php',
            'field_types' => array('link'),
            'filter_only' => FALSE,
            'no_filter' => TRUE,
        ),
        'pricing_table' => array(
            'name' => __('Pricing Table', 'hydraforms'),
            'class' => 'Hydra\Widgets\PricingTableWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/PricingTable.php',
            'field_types' => array('pricing'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'mail' => array(
            'name' => __('E-mail', 'hydraforms'),
            'class' => 'Hydra\Widgets\MailWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Mail.php',
            'field_types' => array('mail'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'week' => array(
            'name' => __('Opening Hours', 'hydraforms'),
            'class' => 'Hydra\Widgets\WeekWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Week.php',
            'field_types' => array('week'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'number' => array(
            'name' => __('Number', 'hydraforms'),
            'class' => 'Hydra\Widgets\NumberWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Number.php',
            'field_types' => array('number'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'checkbox' => array(
            'name' => __('Checkbox', 'hydraforms'),
            'class' => 'Hydra\Widgets\CheckboxWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Checkbox.php',
            'field_types' => array('checkbox'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'checkboxes' => array(
            'name' => __('Checkboxes', 'hydraforms'),
            'class' => 'Hydra\Widgets\CheckboxesWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Checkboxes.php',
            'field_types' => array('taxonomy', 'options', 'reference'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'select' => array(
            'name' => __('Select', 'hydraforms'),
            'class' => 'Hydra\Widgets\SelectWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Select.php',
            'field_types' => array('taxonomy', 'options', 'reference', 'rating'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'date' => array(
            'name' => __('Date', 'hydraforms'),
            'class' => 'Hydra\Widgets\DateWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Date.php',
            'field_types' => array('date', 'datetime'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'date_range' => array(
            'name' => __('Date Range', 'hydraforms'),
            'class' => 'Hydra\Widgets\DateRangeWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Date.php',
            'field_types' => array('date', 'datetime', 'date_range', 'datetime_range'),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        ),
        'date_calendar' => array(
            'name' => __('Calendar Dates', 'hydraforms'),
            'class' => 'Hydra\Widgets\DateCalendarWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/DateCalendar.php',
            'field_types' => array('date', 'datetime', 'date_range', 'datetime_range'),
            'filter_only' => FALSE,
            'no_filter' => TRUE,
        ),
        'textarea' => array(
            'name' => __('Textarea', 'hydraforms'),
            'class' => 'Hydra\Widgets\TextAreaWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Textarea.php',
            'field_types' => array('textarea'),
            'filter_only' => FALSE,
            'no_filter' => TRUE,
        ),
        'image' => array(
            'name' => __('Image', 'hydraforms'),
            'class' => 'Hydra\Widgets\ImageWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Image.php',
            'field_types' => array('image'),
            'filter_only' => FALSE,
            'no_filter' => TRUE,
        ),
        'fieldset' => array(
            'name' => __('Group', 'hydraforms'),
            'class' => 'Hydra\Widgets\FieldsetWidget',
            'file' => plugin_dir_path(__FILE__) . 'hydra/widgets/Widget.php',
            'field_types' => array(),
            'filter_only' => FALSE,
            'no_filter' => FALSE,
        )
    );

    $widget_definitions = apply_filters('hydra_widget_definition', $widget_definitions);
    return $hydra_widget_definitions = $widget_definitions;
}

/**
 * Get single formatter by name
 * @param $name
 * @return bool
 */
function hydra_formatter_get_formatter($name) {
    $formatter_definitions = hydra_formatter_definition();

    if (isset($formatter_definitions[$name])) {
        return $formatter_definitions[$name];
    }

    return FALSE;
}

/**
 * Get available formatter for field definition
 * @param $type
 * @return array
 */
function hydra_formatter_get_formatters_for_type($type) {
    $formatters = hydra_formatter_definition();

    $options = array();
    foreach ($formatters as $name => $settings) {
        if (in_array($type, $settings['field_types'])) {
            $options[$name] = $settings['name'];
        }
    }

    return $options;
}

/**
 * Collects all formatter definitions
 * @return array
 */
function hydra_formatter_definition() {
    // static cache
    static $hydra_formatter_definitions;
    if (!empty($hydra_formatter_definitions)) {
        return $hydra_formatter_definitions;
    }

    $formatter_definitions = array(
        'basic' => array(
            'name' => __('Plain text', 'hydraforms'),
            'class' => 'Hydra\Formatter\BasicFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/BasicFormatter.php',
            'field_types' => array('text', 'checkbox'),
            'group' => FALSE,
        ),
        'link' => array(
            'name' => __('Link', 'hydraforms'),
            'class' => 'Hydra\Formatter\LinkFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/LinkFormatter.php',
            'field_types' => array('link'),
            'group' => FALSE,
        ),
        'pricing_table' => array(
            'name' => __('Pricing', 'hydraforms'),
            'class' => 'Hydra\Formatter\PricingTableFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/PricingTableFormatter.php',
            'field_types' => array('pricing'),
            'group' => FALSE,
        ),
        'week' => array(
            'name' => __('Table', 'hydraforms'),
            'class' => 'Hydra\Formatter\WeekFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/WeekFormatter.php',
            'field_types' => array('week'),
            'group' => FALSE,
        ),
        'option_list' => array(
            'name' => __('Options list', 'hydraforms'),
            'class' => 'Hydra\Formatter\OptionlistFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/OptionlistFormatter.php',
            'group' => FALSE,
            'field_types' => array('options'),
        ),
        'checkboxes' => array(
            'name' => __('Checkboxes', 'hydraforms'),
            'class' => 'Hydra\Formatter\CheckboxesFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/CheckboxesFormatter.php',
            'group' => FALSE,
            'field_types' => array('checkboxes', 'options', 'taxonomy')
        ),
        'date' => array(
            'name' => __('Date', 'hydraforms'),
            'class' => 'Hydra\Formatter\DateFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/DateFormatter.php',
            'group' => FALSE,
            'field_types' => array('date', 'date_range'),
        ),
        'image' => array(
            'name' => __('Image', 'hydraforms'),
            'class' => 'Hydra\Formatter\ImageFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/ImageFormatter.php',
            'group' => FALSE,
            'field_types' => array('image'),
        ),
        'datetime' => array(
            'name' => __('Datetime', 'hydraforms'),
            'class' => 'Hydra\Formatter\DatetimeFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/DatetimeFormatter.php',
            'group' => FALSE,
            'field_types' => array('datetime_range', 'datetime')
        ),
        'longtext' => array(
            'name' => __('Full text', 'hydraforms'),
            'class' => 'Hydra\Formatter\LongtextFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/LongtextFormatter.php',
            'group' => FALSE,
            'field_types' => array('textarea'),
        ),
        'table' => array(
            'name' => __('Table', 'hydraforms'),
            'class' => 'Hydra\Formatter\TableGroupFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/TableGroupFormatter.php',
            'group' => TRUE,
            'field_types' => array('fieldset'),
        ),
        'html' => array(
            'name' => __('Basic', 'hydraforms'),
            'class' => 'Hydra\Formatter\HTMLGroupFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/HtmlGroupFormatter.php',
            'group' => TRUE,
            'field_types' => array('fieldset'),
        ),
        'description' => array(
            'name' => __('Description list', 'hydraforms'),
            'class' => 'Hydra\Formatter\DescriptionGroupFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/DescriptionGroupFormatter.php',
            'group' => TRUE,
            'field_types' => array('fieldset'),
        ),
        'list' => array(
            'name' => __('List', 'hydraforms'),
            'class' => 'Hydra\Formatter\ListGroupFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/ListGroupFormatter.php',
            'group' => TRUE,
            'field_types' => array('fieldset'),
        ),
        'taxonomy' => array(
            'name' => __('Taxonomy', 'hydraforms'),
            'class' => 'Hydra\Formatter\TaxonomyFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/TaxonomyFormatter.php',
            'group' => FALSE,
            'field_types' => array('taxonomy'),
        ),
        'number' => array(
            'name' => __('Number', 'hydraforms'),
            'class' => 'Hydra\Formatter\NumberFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/NumberFormatter.php',
            'group' => FALSE,
            'field_types' => array('number'),
        ),
        'price' => array(
            'name' => __('Price', 'hydraforms'),
            'class' => 'Hydra\Formatter\PriceFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/PriceFormatter.php',
            'group' => FALSE,
            'field_types' => array('number'),
        ),
        'post' => array(
            'name' => __('Post', 'hydraforms'),
            'class' => 'Hydra\Formatter\PostFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/PostFormatter.php',
            'group' => FALSE,
            'field_types' => array('reference'),
        ),
        'stars' => array(
            'name' => __('Stars', 'hydraforms'),
            'class' => 'Hydra\Formatter\StarsFormatter',
            'file' => plugin_dir_path(__FILE__) . 'hydra/formatter/StarsFormatter.php',
            'group' => FALSE,
            'field_types' => array('rating'),
        ),
    );


    $formatter_definitions = apply_filters('hydra_formatter_definition', $formatter_definitions);
    return $hydra_formatter_definitions = $formatter_definitions;
}

function hydra_handler_settings($name = NULL) {
    return array(
        'mail' => __('Mail', 'hydraforms'),
        'message' => __('Message', 'hydraforms'),
    );
}
