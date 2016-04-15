<?php
/**
 * Plugin Name: HydraForms
 * Description: Flexible plugin for managing post-types input fields, creating post-type displays, creating and managing forms and filter
 * Version: 0.8.3
 */

register_activation_hook(__FILE__, 'hydra_create_tables');

$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'hydraforms', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Defining if plugin is included in theme or as regular plugin
 */
define('HYDRA_THEME_MODE', apply_filters('hydra_theme_mode', FALSE));

if (HYDRA_THEME_MODE == FALSE) {
    define('HYDRA_DIR', plugin_dir_path(__FILE__));
    define('HYDRA_URL', plugin_dir_url(__FILE__));
}
else {
    define('HYDRA_DIR', trailingslashit(get_template_directory()) . trailingslashit(basename(dirname(__FILE__))));
    define('HYDRA_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));
}

require_once 'hydra.db.php';
require_once 'hydra.schema.php';
require_once 'hydra.setting.php';
require_once 'admin/hydra.admin.php';
require_once 'admin/export/hydra.export.php';
require_once 'admin/plugins/hydra.plugins.php';
require_once 'hydra/widgets/Widget.php';
require_once 'hydra.dbmapper.php';
require_once 'hydra/formatter/Formatter.php';
require_once 'hydra.metabox.php';
require_once 'hydra.render.form.php';
require_once 'hydra.render.field.php';
require_once 'hydra.render.post.php';
require_once 'hydra.token.php';
require_once 'hydra.shortcodes.php';

use Hydra\Builder;

add_action('admin_head', 'hydra_admin_css');
function hydra_admin_css() {
    echo "<link type='text/css' rel='stylesheet' href=" . HYDRA_URL . "/assets/style.css />";
}


spl_autoload_register(
    function ($class) {
        $originClass = $class;
        if (strstr($class, 'Hydra')) {
            $path_elements = explode('\\', $class);
            $class = array_pop($path_elements);
            $path = dirname(__FILE__) . '/' . strtolower(implode('/', $path_elements)) . '/' . $class . '.php';
            if (file_exists($path)) {
                require_once($path);
            }
        }

        $widget_definition = hydra_widget_definition();
        foreach($widget_definition as $widget) {
            if($widget['class'] == $originClass) {
                if(file_exists($widget['file'])) {
                    require_once $widget['file'];
                }
            }
        }

    }
);

add_action( 'init', 'hydraforms_register_session' );

function hydraforms_register_session() {
    if ( !session_id() ) {
        session_start();
    }
}

function _hydra_get_enabled_locales() {
    if (function_exists('icl_get_languages')) {
        return icl_get_languages();
    }
    else {
        return FALSE;
    }
}

register_activation_hook(__FILE__, 'hydra_activation_hook');
function hydra_activation_hook() {
    flush_rewrite_rules();
}

add_action('init', 'hydra_rewrite_rules');
function hydra_rewrite_rules() {

    // standard url
    add_rewrite_rule('^submit/(.+)/?$', 'index.php?hydra=true&form-id=$matches[1]', 'top');
    // needs to be there because of wpml translation prefix
    add_rewrite_rule('(.)*/submit/(.+)/?$', 'index.php?hydra=true&form-id=$matches[2]', 'top');

    add_rewrite_rule('^hydraformatter/(.+)/(.+)?$', 'index.php?hydraformatter=true&formatter=$matches[1]&id=$matches[2]', 'top');
    add_rewrite_rule('^hydrawidget/(.+)/(.+)/(.+)?$', 'index.php?hydrawidget=true&widget=$matches[1]&id=$matches[2]&is-filter=$matches[3]', 'top');
    add_rewrite_rule('^hydra-add-more/(.+)/(\d)?$', 'index.php?hydra-add-more=true&widget=$matches[1]&number=$matches[2]', 'top');

    add_rewrite_rule('^hydra-export', 'index.php?hydra-export=true', 'top');
    add_rewrite_rule('^hydra-import', 'index.php?hydra-import=true', 'top');

    $model = new \HydraFormCacheModel();
    $model->clearOldRecords();
}

add_filter('query_vars', 'hydra_add_query_vars');

function hydra_add_query_vars($vars) {
    $vars[] = 'hydra';
    $vars[] = 'form-id';
    $vars[] = 'is-filter';
    $vars[] = 'hydra-add-more';
    $vars[] = 'hydraformatter';
    $vars[] = 'language';
    $vars[] = 'hydrawidget';
    $vars[] = 'hydra-export';
    $vars[] = 'hydra-import';
    $vars[] = 'formatter';
    $vars[] = 'widget';
    $vars[] = 'id';
    return $vars;
}


add_action('template_redirect', 'hydra_catch_template');
function hydra_catch_template() {

    if (get_query_var('hydra') && get_query_var('form-id')) {

        header("HTTP/1.0 200 OK");
        /** @var Builder $build */
        $build = Builder::getBuild(get_query_var('form-id'));
        if ($build) {
            // @TODO
            // AJAX
            if (isset($_POST['trigger_element'])) {
                $build->setValues($_POST);
                $trigger_element = $_POST['trigger_element'];
                $triggerField = $build->getField($trigger_element);
                $triggerField->processAjaxCallback();
                exit();
            }
            else {
                // REGULAR
                if ($build) {
                    $build->validate();
                }
            }
        }

        exit();
    }

    if (get_query_var('hydraformatter')) {
        header("HTTP/1.0 200 OK");
        $formatter_name = get_query_var('formatter');
        $view_id = get_query_var('id');

        $hydraFormatter = new HydraFormatterForm($view_id, $formatter_name);
        print $hydraFormatter->form();

        exit();
    }

    if (get_query_var('hydrawidget')) {
        header("HTTP/1.0 200 OK");
        $widget_name = get_query_var('widget');
        $field_id = get_query_var('id');
        $is_filter = get_query_var('is-filter');

        $hydraFormatter = new HydraWidgetForm($field_id, $widget_name, $is_filter);
        print $hydraFormatter->form();

        exit();
    }

    if (get_query_var('hydra-add-more')) {
        header("HTTP/1.0 200 OK");

        $item = get_query_var('number');
        $builder = new Builder('no-name-required', 'no-submit', Builder::FORM_EXTENDER);

        $itemSet = $builder->addFieldObject(
            Builder::createField('fieldset', array(0, ''))
                ->isRenderable(FALSE)
        );

        $itemSet->removeAllDecorators();
        $itemSet->addFieldObject(
            Builder::createField('button', array('add-image', 'Select image'))
                ->addAttribute('class', 'hydra-add-image')
        );

        $itemSet->addFieldObject(
            Builder::createField('text', array('url', 'Url'))
                ->addAttribute('class', 'hydra-image-url'));

        $builder->addFieldObject($itemSet);

        print $builder->render();

        exit();
    }
}


class HydraFormatterForm {

    private $viewId;
    private $formatterName;

    public function __construct($viewId, $formatterName) {
        $this->viewId = $viewId;
        $this->formatterName = $formatterName;
    }

    public function form() {
        $db = new HydraFieldViewModel();
        $view = $db->load($this->viewId);

        $db = new HydraFieldModel();
        $field = $db->load($view->field_id);

        $settings = hydra_formatter_definition($this->formatterName);

        $group = false;
        if(isset($settings['group'])) {
            $group = $settings['group'];
        }
        $formatter = Hydra\Formatter\Formatter::getFormatter($this->formatterName, $group);

        // we need to remove these fields otherwise the form wont get identified right
        $form = new Builder('formatter-' . $this->viewId, '/submit/formatter-' . $this->viewId, Builder::FORM_EXTENDER);
        $form->removeField('form_id');
        $form->removeField('token');

        $fieldset = $form->addField('fieldset', array('formatter-' . $this->viewId, 'Formatter settings'));
        $formatter->getSettingsForm($fieldset, $view, $field);

        $fieldset->addField('hidden', array('view_id', $this->viewId));
        $fieldset->addField('hidden', array('formatter_name', $this->viewId));
        $fieldset->addDecorator('table');


        $fieldset->setValue($view->settings);

        ob_start();
        $form->render();
        $output = ob_get_clean();
        return $output;
    }
}


class HydraWidgetForm {

    private $fieldId;
    private $widgetName;

    public function __construct($fieldId, $widgetName, $isFilter) {
        $this->fieldId = $fieldId;
        $this->widgetName = $widgetName;
        $this->isFilter = $isFilter;
    }

    public function form() {
        $db = new HydraFieldModel();
        $field = $db->load($this->fieldId);

        $manager = new \Hydra\Definitions\DefinitionManager();
        $definition = $manager->createDefinition($field->field_type, $field);

        // we need to remove these fields otherwise the form wont get identified right

        $form = new Builder('widget-' . $field->field_type, '/submit/formatter-' . $this->fieldId, Builder::FORM_EXTENDER);
        $form->removeField('form_id');
        $form->removeField('token');

        $widgetManager = new \Hydra\Widgets\WidgetManager();

        if($this->isFilter) {
            $widgetManager->getWidgetAdminFilterForm($this->widgetName, $definition, $field, $form);
        } else {
            $widgetManager->getWidgetAdminForm($this->widgetName, $definition, $field, $form);
        }

        ob_start();
        echo "<h3><legend>Widget</legend></h3>";
        $form->render();
        $output = ob_get_clean();
        return $output;
    }
}
