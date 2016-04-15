<?php

require_once HYDRA_DIR . '/hydra/Builder.php';
require_once HYDRA_DIR . '/hydra/definition/DefinitionManager.php';

require_once 'hydra.admin.field.php';
require_once 'hydra.admin.list.php';
require_once 'hydra.admin.table.php';

use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;


spl_autoload_register(
  function ($class) {
    // @todo automate -
    if($class == 'HydraAdminFormForm') {
      require_once 'form/hydra.admin.form.php';
    }

    if($class == 'HydraAdminFormField') {
      require_once 'form/hydra.admin.field.php';
    }

    if($class == 'HydraAdminFormHandler') {
      require_once 'form/hydra.admin.handler.php';
    }

    if($class == 'HydraAdminPostPost') {
      require_once 'post/hydra.admin.post.php';
    }

    if($class == 'HydraAdminPostField') {
      require_once 'post/hydra.admin.field.php';
    }

    if($class == "HydraAdminPostView") {
      require_once 'post/hydra.admin.view.php';
    }

    if($class == 'HydraAdminFilterFilter') {
      require_once 'filter/hydra.admin.filter.php';
    }

    if($class == 'HydraAdminFilterField') {
      require_once 'filter/hydra.admin.field.php';
    }



  }
);

add_action('admin_menu', 'hydra_admin_menu');
function hydra_admin_menu() {
  $hydraOptions = new HydraAdmin();
  $icon = HYDRA_URL . 'assets/img/icon-small.png';
  add_menu_page(
    __('Hydra', 'hydraforms'),
    __('Hydra', 'hydraforms'),
    'edit_pages',
    'hydrapost',
    array($hydraOptions, 'router'),
    $icon,
    41
  );

  add_submenu_page(
    'hydrapost',
    __('Post Fields', 'hydraforms'),
    __('Post Fields', 'hydraforms'),
    'edit_pages',
    'hydrapost',
    array($hydraOptions, 'router'),
    $icon
  );

  add_submenu_page(
    'hydrapost',
    __('Custom Forms', 'hydraforms'),
    __('Custom Forms', 'hydraforms'),
    'edit_pages',
    'hydraform',
    array($hydraOptions, 'router')
  );

  add_submenu_page(
    'hydrapost',
    __('Custom Filters', 'hydraforms'),
    __('Custom Filters', 'hydraforms'),
    'edit_pages',
    'hydrafilter',
    array($hydraOptions, 'router')
  );
}

class HydraAdmin {
  public $slug;


  public function __construct() {
    $this->slug = 'hydra';
  }

  protected function createRoute($subject, $action, $params) {
    $params['subject'] = $subject;
    $params['action'] = $action;

    $query = http_build_query($params);
    $url = home_url() . '/wp-admin/admin.php?page=' . $this->slug . '&' . $query;

    return $url;
  }

  /**
   *
   */
  public function router() {
    $params = $_GET;
    // ... Router - thanks to brilliant wp routing system oO

    $page = str_replace('hydra', '', $params['page']);
    if (!isset($params['subject'])) {
      $params['subject'] = $page;
    }

    if (!isset($params['action'])) {
      $params['action'] = 'default';
    }


    $subject = $params['subject'];
    $action = $params['action'];

    unset($params['subject']);
    unset($params['page']);
    unset($params['action']);

    $args = $params;

    $fieldClass =  'HydraAdmin' . ucfirst($page) . ucfirst($subject);

    try {

      require_once $page . '/hydra.admin.' .  $subject . '.php';
      $reflection = new \ReflectionClass($fieldClass);

      $controller = $reflection->newInstanceArgs($args);
      $action = $action . 'Action';

      call_user_func_array(array($controller, $action), $args);
    } catch (Exception $e) {

      print $e->getMessage();
    }

    return null;
  }

  protected function title($title) {
    $image_url = HYDRA_URL . '/assets/img/icon.png';

    ob_start();
    include 'templates/title.tpl.php';
    return ob_get_clean();
  }

  protected function messages($messages) {
    $form = new Builder('message-control', '/submit/message-control');
    $status = get_option('hydra_messages', true);

    if($status) {
      $form->addField('submit', array('save', __('Disable tutor', 'hydraforms')));
      $form->addOnSuccess('disableTutorSubmit', $this);
    } else {
      $form->addField('submit', array('save', __('Enable tutor', 'hydraforms')));
      $form->addOnSuccess('enableTutorSubmit', $this);
    }

    $form->build();
    ob_start();
    include 'templates/messages.tpl.php';
    return ob_get_clean();
  }

  public function disableTutorSubmit($form, $values) {
    if('null' == get_option('hydra_messages', 'null')) {
      add_option('hydra_messages', false);
    } else {
      update_option('hydra_messages', false);
    }

  }

  public function enableTutorSubmit($form, $values) {
    update_option('hydra_messages', true);
  }

  public function createLink($text, $path, $attributes = array()) {

    $attrOutput = '';

    if($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] == str_replace(array('http://', 'www.', 'https://'), '', $path)) {
      $attributes['class'][] = 'active';
    }

    if(count($attributes)) {
      foreach($attributes as $key => $attribute) {
        if(is_array($attribute)) {
          $attrOutput .= $key ."=\"" .implode(' ', $attribute) . "\"";
        } else {
          $attrOutput .= $key ."=\"" .$attribute . "\"";
        }
      }
    }

    return "<a href=$path $attrOutput>$text</a>";
  }

  protected function tabsMenu($postType) {
    $db = new HydraViewModel();
    $views = $db->loadOptionsByPostType($postType);

    $links = array();
    foreach($views as $view) {
      $links[] = array(
        'title' => $view->label,
        'link' => $this->createRoute(
          'view',
          'view',
          array(
            'post_type' => $postType,
            'view_name' => $view->name,
          )
        ),
      );
    }

    $tabs = array(
      'fields' => array(
        'title' => 'Manage Fields',
        'link' => $this->createRoute(
          'post',
          'list',
          array('post_type' => $postType)
        )
      ),
      'manage_views' => array(
        'title' => 'Manage Displays',
        'link' => $this->createRoute(
          'view',
          'list',
          array('post_type' => $postType)
        )
      ),
      'views' => $links,
    );


    ob_start();
      include 'templates/tabs.tpl.php';
    return ob_get_clean();
  }

  protected function includeSortable() {
    wp_enqueue_script(
      'jquery.ui.core',
      includes_url('/js/jquery/ui/jquery.ui.core.min.js', __FILE__)
    );

    wp_enqueue_script(
      'jquery.ui.widget',
      includes_url('/js/jquery/ui/jquery.ui.widget.min.js', __FILE__)
    );
    wp_enqueue_script(
      'jquery.ui.mouse',
      includes_url('/js/jquery/ui/jquery.ui.mouse.min.js', __FILE__)
    );
    wp_enqueue_script(
      'jquery.ui.draggable',
      includes_url('/js/jquery/ui/jquery.ui.draggable.min.js', __FILE__)
    );
    wp_enqueue_script(
      'jquery.ui.droppable',
      includes_url('/js/jquery/ui/jquery.ui.droppable.min.js', __FILE__)
    );
    wp_enqueue_script(
      'jquery.ui.sortable',
      includes_url('/js/jquery/ui/jquery.ui.sortable.min.js', __FILE__)
    );


    wp_register_script('nestedSortable', HYDRA_URL . '/assets/nestedSortable.min.js');
    wp_enqueue_script('nestedSortable');

    wp_register_script('sort', HYDRA_URL . '/assets/sort.js');
    wp_enqueue_script('sort');

    wp_register_script('chosen', HYDRA_URL . '/assets/chosen/chosen.jquery.min.js');
    wp_enqueue_script('chosen');

    $this->includeCss();
  }

  protected function includeCss() {
    wp_register_style('chosen-style', HYDRA_URL . '/assets/chosen/chosen.min.css');
    wp_enqueue_style('chosen-style');

    wp_register_style('fields', HYDRA_URL . '/assets/style.css');
    wp_enqueue_style('fields');
  }


  public function viewForm($id = NULL, $post_type) {

    $form = new Builder('view-form', '/submit/view-form');
    $form->addField('text', array('name', 'Name'));
    $form->addField('text', array('label', 'Label'));
    $form->addField('submit', array('submit', 'Save'));
    $form->build();

    $form->render();
  }

  public function viewFormSubmit($form, $values) {

  }
}