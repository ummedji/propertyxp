<?php

use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;


class HydraAdminPostPost extends HydraAdminListFields {
  public function __construct() {
    $this->slug = 'hydrapost';
  }

  public function defaultAction() {
    $post_types_list_table = new Post_Types_List_Table();
    $post_types_list_table->data = $this->prepareData();
    $post_types_list_table->prepare_items();

    $messages = array(
      __('This page displays all the post types registered in system. You can edit any post type wish and add various fields and displays', 'hydraforms'),
      __('Fields will be displayed in metabox on add/edit form of post type')
    );

    print $this->title(__('Post Types Management', 'hydraforms'));
    print $this->messages($messages);
    print '<div class="wrap">';
    $post_types_list_table->display();
    print '</div>';
  }

  private function prepareData() {
    $types = get_post_types();

    $data = array();
    foreach ($types as $type) {
      $typeObject = get_post_type_object($type);

      $dbViewModel = new HydraViewModel();
      $dbFieldModel = new HydraFieldModel();
      $fieldsContainer = $dbFieldModel->loadByPostType($type);

      $views = $dbViewModel->loadByPostType($type, count($fieldsContainer->getRecords()));
      $viewsList = '';

      if (is_array($views)) {
        foreach ($views as $view) {
          $viewsList .= '<a href="' . $this->createRoute(
              'view',
              'view',
              array('post_type' => $type, 'view_name' => $view->name)
            ) . '">' . $view->label . '</a>, ';
        }
      }
      else {
        $viewsList = '<a href="' . $this->createRoute('post', 'list', array('post_type' => $type)) . '">' . __(
            'No views found. Create new one',
            'hydraforms'
          ) . '</a>';
      }

      $data[] = array(
        'posttitle' => '<a href="' . $this->createRoute(
          'post',
          'list',
          array('post_type' => $type)
        ) . '"><strong>' . $typeObject->labels->singular_name . '</strong></a>',
        'using_hydra' => array_key_exists($type, $dbFieldModel->loadUsedPostTypesAsArray()),
        'of_elements' => count($fieldsContainer->getRecords()),
        'views' => trim($viewsList, ', '),
        'actions' => array(
          'manage_fields' => $this->createRoute('post', 'list', array('post_type' => $type)),
          'manage_views' => $this->createRoute('view', 'list', array('post_type' => $type)),
        )
      );
    }

    return $data;
  }

  public function listAction($post_type) {
    $compactedVals = parent::listAction($post_type);
    extract($compactedVals);
    unset($compactedVals);

    $messages = array(
      __('On this page you can perform various actions regarding your fields', 'hydraforms'),
      __('Add new field or field group using the form on the bottom of this page', 'hydraforms'),
      __('Change order of fields by drag&drop - dont forget to confirm your changes by clicking "Save" button', 'hydraforms'),
      __('Edit your existing fields using wheel icon', 'hydraforms'),
      __('Delete your existing fields using trash icon', 'hydraforms'),
    );

    $messages = $this->messages($messages);
    include 'templates/post/field_list.tpl.php';
  }

  public function addFormSubmit($form, $values) {
    $record = parent::addFormSubmit($form, $values);
    $route = $this->createRoute(
      'field',
      'edit',
      array('id' => $record->id, 'post_type' => $record->post_type, 'field_type' => $record->field_type)
    );
    $form->setRedirect($route);
  }

  public function sortFormSubmit($form, $values) {
    parent::sortFormSubmit($form, $values);

    $url = $this->createRoute(
      'post',
      'list',
      array(
        'post_type' => $values['post_type'],
      )
    );

    $form->setRedirect($url);
  }
}


class Post_Types_List_Table extends Hydra_List_Table {
  var $items_per_page = 10;

  function get_columns() {
    $columns = array(
      'posttitle' => __('Title', 'hydraforms'),
      'views' => __('Defined Views', 'hydraforms'),
      'using_hydra' => __('Using Hydra', 'hydraforms'),
      'of_elements' => __('Elements', 'hydraforms'),
    );

    return $columns;
  }

  function get_sortable_columns() {
    $sortable_columns = array(
      'posttitle' => array('posttitle', FALSE),
    );

    return $sortable_columns;
  }

  function column_default($item, $column_name) {
    switch ($column_name) {
      case 'posttitle':
        return $item[$column_name];
      case 'views':
        return $item[$column_name];
      case 'using_hydra':
        if ($item[$column_name]) {
          return '<span class="yes">' . __('Dispatched by Hydra', 'hydraforms') . '</span>';
        }
        else {
          return '<a href="' . $item['actions']['manage_fields'] . '">' . __('Create First Field', 'hydraforms')  . '</a>';
        }
      case 'of_elements':
        return '<span class="post-count"><span class="count">' . $item[$column_name] . '</span></span>';
      default:
        return print_r($item, TRUE); //Show the whole array for troubleshooting purposes
    }
  }

  function prepare_items() {
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    usort($this->data, array(&$this, 'usort_reorder'));
    $this->_column_headers = array($columns, $hidden, $sortable);

    $current_page = $this->get_pagenum();
    $total_items = count($this->data);

    $this->found_data = array_slice($this->data, (($current_page - 1) * $this->items_per_page), $this->items_per_page);

    $this->set_pagination_args(
      array(
        'total_items' => $total_items,
        'per_page' => $this->items_per_page,
      )
    );

    $this->items = $this->found_data;
  }

  function column_posttitle($item) {
    $actions = array(
      'manage_fields' => '<a href="' . $item['actions']['manage_fields'] . '">' . __('Fields', 'hydraforms') . '</a>',
      'manage_views' => '<a href="' . $item['actions']['manage_views'] . '">' . __('Views', 'hydraforms') . '</a>',
    );

    return sprintf('%1$s %2$s', $item['posttitle'], $this->row_actions($actions));
  }

  function usort_reorder($a, $b) {
    // If no sort, default to title
    $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'posttitle';
    // If no order, default to asc
    $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
    // Determine sort order
    $result = strcmp($a[$orderby], $b[$orderby]);

    // Send final sort direction to usort
    return ($order === 'asc') ? $result : -$result;
  }
}