<?php

use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;

/**
 * Field CRUD Interface
 * Class HydraAdminField
 */
class HydraAdminPostView extends HydraAdmin {

    public function __construct() {
        $this->slug = 'hydrapost';
    }

    public function viewAction($post_type, $view_name) {
        $db = new HydraFieldViewModel();
        $viewModel = new HydraViewModel();
        $viewContainer = $db->loadByViewName($view_name, $post_type);
        $view = $viewModel->loadByNamePostType($post_type, $view_name);

        if(!$view) {
            $view_name = "default";
            $view_label = __("Default", 'hydraforms');
        } else {
            $view_name = $view->name;
            $view_label = $view->label;
        }

        $items = $viewContainer->getHierarchy();

        $sortForm = $this->sortForm($post_type, $view_name, $items);
        $tabs = $this->tabsMenu($post_type);
        $title = $this->title('Manage display ' . $view_label);

        $messages = array(
            __('On this page you can manage how your fields will be displayed on frontend', 'hydraforms'),
            __('Fields are displayed trough formatters - which are allowing you do display data in various formats.', 'hydraforms'),
            __('Change order of fields, hide them, or change its settings, click "Save" and observe your changes on fronted.', 'hydraforms'),
        );

        $messages = $this->messages($messages);

        $flatItems = $viewContainer->getRecords();
        $formatterSettings = array();

        foreach ($flatItems as $item) {
            $hydraFormatter = new HydraFormatterForm($item->id, $item->formatter);
            $formatterSettings[$item->id] = $hydraFormatter->form();
        }

        $addForm = $this->addForm($post_type, $view_name);
        include('templates/view/field_list.tpl.php');
    }

    public function sortForm($post_type, $view_name, $items) {
        $this->includeSortable();

        $sortForm = new Builder('view-sort', '/submit/view-sort');
        $sortForm->addField('hidden', array('post_type', $post_type));
        $sortForm->addField('hidden', array('view_name', $view_name));


        foreach ($items as $viewGroup) {
            $viewGroup->loadField();

            $fieldset = $sortForm->addField('fieldset', array($viewGroup->id));

            $fieldset->addField('hidden', array('parent_id', $viewGroup->parent_id))
                ->setAttribute('id', 'parent-' . $viewGroup->id);
            $fieldset->addField('hidden', array('hidden', $viewGroup->hidden))
                ->setAttribute('id', 'hidden-' . $viewGroup->id);
            $fieldset->addField('hidden', array('weight', $viewGroup->weight))
                ->setAttribute('id', 'weight-' . $viewGroup->id);

            if ($viewGroup->isWrapper()) {

                $fieldset->addField(
                    'select',
                    array(
                        'formatter',
                        ''
                    )
                )
                ->setOptions(hydra_formatter_get_formatters_for_type('fieldset'))
                ->addAttribute('class', 'select-chosen formatter')
                ->setDefaultValue($viewGroup->formatter)
                ->setAttribute('id', 'formatter-' . $viewGroup->id);


            }
            else {
                $fieldset->addField('select', array(
                    'formatter',
                    '',
                    hydra_formatter_get_formatters_for_type($viewGroup->field->field_type)
                ))
                    ->addAttribute('class', 'select-chosen formatter')
                    ->setAttribute('id', 'formatter-' . $viewGroup->id)
                    ->setDefaultValue($viewGroup->formatter);
            }

            // fieldset children - hidden fields
            if ($viewGroup->isWrapper() && $viewGroup->hasChildren()) {
                foreach ($viewGroup->getChildren() as $item) {
                    $item->loadField();

                    $itemFieldset = $fieldset->addField('fieldset', array($item->id));
                    $itemFieldset->addField('select', array(
                        'formatter',
                        '',
                        hydra_formatter_get_formatters_for_type($item->field->field_type)
                    ))
                        ->setDefaultValue($item->formatter)
                        ->addAttribute('class', 'select-chosen formatter')
                        ->setAttribute('id', 'formatter-' . $item->id);


                    $itemFieldset->addField('hidden', array('hidden', $item->hidden))
                        ->setAttribute('id', 'hidden-' . $item->id);
                    $itemFieldset->addField('hidden', array('parent_id', $item->parent_id))
                        ->setAttribute('id', 'parent-' . $item->id);
                    $itemFieldset->addField('hidden', array('weight', $item->weight))
                        ->setAttribute('id', 'weight-' . $item->id);
                }
            }
        }

        $sortForm->addOnSuccess('sortFormSubmit', $this);
        $sortForm->addField('submit', array('save', 'Save'))
            ->addAttribute('class', 'button')
            ->addAttribute('class', 'button-green');
        $sortForm->build();

        return $sortForm;
    }

    public function sortFormSubmit($form, $values) {
        $viewModel = new HydraFieldViewModel();
        $viewContainer = $viewModel->loadByViewName($values['view_name'], $values['post_type']);

        $items = $viewContainer->getRecords();

        foreach ($items as $item) {

            if (isset($values['formatter-' . $item->id])) {
                $item->settings = $values['formatter-' . $item->id];
            }
            else {
                $item->settings = array();
            }

            /** @var $item HydraFieldRecord */
            if ($item->isWrapper() || $item->parent_id == 0) {
                $data = $values[$item->id];
            }
            else {
                $data = $values[$item->parent_id][$item->id];
            }

            $item->updateWithData($data);
            $item->save();
        }

        $url = $this->createRoute(
            'view',
            'view',
            array(
                'post_type' => $values['post_type'],
                'view_name' => $values['view_name'],
            )
        );

        $form->setRedirect($url);
    }

    public function deleteAction($id, $post_type) {
        $dbModel = new HydraViewModel();
        $view = $dbModel->load($id);

        print $this->title('Delete ' . $view->label);
        $form = $this->viewDeleteForm($id, $post_type);
        $form->render();
    }

    public function viewDeleteForm($id, $post_type) {
        $form = new Builder('view-delete', '/submit/view-delete');

        $dbModel = new HydraViewModel();
        $dbModel->load($id);

        $cancelUrl = $this->createRoute(
            'view',
            'list',
            array(
                'post_type' => $post_type,
            )
        );

        $cancelLink = "<a href=$cancelUrl>Cancel</a>";
        $form = new Builder('field-delete', '/submit/field-delete');

        $form->addField('markup', array(
            'message',
            __('Are you sure you want to delete this display? This action can <b>not</b> be reverted'),
            'hydraforms'
        ));
        $form->addField('markup', array('cancel', $cancelLink));
        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('post_type', $post_type));
        $form->addField('submit', array('delete', __('Delete', 'hydraforms')));

        $form->addOnSuccess('viewDeleteFormSubmit', $this);
        $form->build();

        return $form;
    }

    public function viewDeleteFormSubmit($form, $values) {
        $dbModel = new HydraViewModel();

        $viewRecord = $dbModel->load($values['id']);
        $viewRecord->delete();

        $url = $this->createRoute(
            'view',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );
        $form->addSuccessMessage(sprintf('Display %s successfully deleted', 'hydraforms'), '');
        $form->setRedirect($url);
    }

    public function createAction($post_type) {
        $this->editAction(NULL, $post_type);
    }

    public function editAction($id = NULL, $post_type) {
        $dbModel = new HydraViewModel();
        $view = $dbModel->load($id);
        print $this->title(__('Edit ') . $view->label);

        $form = $this->viewForm($id, $post_type);
        $form->render();
    }

    public function viewForm($id = NULL, $post_type) {
        $form = new Builder('view-form', '/submit/view-form');
        $dbModel = new HydraViewModel();

        $viewRecord = FALSE;
        if ($id) {
            $viewRecord = $dbModel->load($id);
        }

        $form->addField('text', array('label', __('Label', 'hydraforms')))
            ->addAttribute('class', 'machine-name-source')
            ->addValidator('required')
            ->setDescription(__('Human readable title of the view', 'hydraforms'));

        $machineName = $form->addField('text', array('name', __('Machine name', 'hydraforms')))
            ->addAttribute('class', 'machine-name')
            ->addValidator('required')
            ->setDescription(__('Machine readable name of the view', 'hydraforms'));

        if ($id) {
            $machineName->addAttribute('disabled', TRUE);
        }

        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('post_type', $post_type));

        $form->addOnSuccess('viewFormSubmit', $this);
        if ($viewRecord) {
            $form->setValues((array) $viewRecord);
        }

        if ($id) {
            $form->addField('submit', array('submit', __('Save', 'hydraforms')));
        }
        else {
            $form->addField('submit', array('submit', __('Create', 'hydraforms')));
        }

        if ($id) {
            // delete link
            $deleteLink = $this->createLink(__('Delete', 'hydraforms'), $this->createRoute('view', 'delete', array(
                'id' => $id,
                'post_type' => $post_type
            )));
            $form->addField('markup', array('delete', $deleteLink));

            // return link
            $returnLink = $this->createLink(__('Cancel', 'hydraforms'), $this->createRoute('view', 'list', array('post_type' => $post_type)));
            $form->addField('markup', array(__('cancel', 'hydraforms'), $returnLink));
        }

        $form->build();
        return $form;
    }

    public function viewFormSubmit($form, $values) {

        $dbModel = new HydraViewModel();
        if ($values['id']) {
            $viewRecord = $dbModel->load($values['id']);
            $viewRecord->updateWithData($values);
        }
        else {
            $viewRecord = new HydraViewRecord($values);
        }

        $viewRecord->save();


        $url = $this->createRoute(
            'view',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        if ($values['id']) {
            $form->addSuccessMessage(sprintf(__('Display %s successfully updated', 'hydraforms'), $values['label']));
        }
        else {
            $form->addSuccessMessage(sprintf(__('Display %s successfully created', 'hydraforms'), $values['label']));
        }
        $form->setRedirect($url);
    }

    public function listAction($post_type) {
        $manager = new HydraViewModel();
        $views = $manager->loadByPostType($post_type);
        $tabs = $this->tabsMenu($post_type);


        $this->includeCss();
        $this->includeSortable();
        $createForm = $this->viewForm($id = NULL, $post_type);

        $views_list_table = new Views_List_Table();
        $views_list_table->data = $this->prepareData($views, $post_type);
        $views_list_table->prepare_items();

        $messages = array(
            __('On this page you can manage all your displays', 'hydraforms'),
            __('Display is bunch of settings which allows you to change your frontend renders without coding anything.'),
            __('Add new display using the form on the bottom of this page', 'hydraforms')
        );

        echo $this->title(__('Display Management', 'hydra'));
        print $messages = $this->messages($messages);
        print $this->tabsMenu($post_type);
        print hydra_render_messages();
        echo '<div class="wrap">';
        $views_list_table->display();
        $createForm->render();
        echo '</div>';
//    include 'templates/view/view_list.tpl.php';
    }

    public function addForm($postType, $view_name) {
        $form = new Builder('add-new-group', '/submit/add-new-group');

        $form->addField('text', array('field_label', 'Label'))
            ->setDescription('Human readable label')
            ->addValidator('required', 'Field label is required')
            ->addAttribute('class', 'machine-name-source');

        $form->addField('text', array('field_name', 'Machine name'))
            ->addDecorator('prefix', array('hf_' . $postType))
            ->setDescription('Machine readable name')
            ->addValidator('required', 'Machine name is required')
            ->addAttribute('class', 'machine-name');

        $form->addField('hidden', array('post_type', $postType));
        $form->addField('hidden', array('view', $view_name));
        $form->addField('submit', array('add_field', __("Create Group", 'hydraforms')));

        $form->addOnSuccess('addFormSubmit', $this);
        $form->build();

        return $form;
    }

    public function addFormSubmit($form, $values) {
        $dbModel = new HydraFieldViewModel();

        $values['parent_id'] = 0;
        $values['field_id'] = 0;
        $values['wrapper'] = 1;
        // default formatter
        $values['formatter'] = 'table';
        $values['field_name'] =  'hf_' . $values['post_type'] . '_' . $values['field_name'];

        $fieldViewRecord = new HydraFieldViewRecord($values);
        $fieldViewRecord->save();
    }


    private function prepareData($views, $post_type) {
        $data = array();

        if (is_array($views)) {
            foreach ($views as $view) {
                // View's actions
                $actions = array();
                $actions['manage_view'] = $this->createRoute('view', 'view', array(
                    'post_type' => $post_type,
                    'view_name' => $view->name
                ));

                if (isset($view->id)) {
                    $actions['manage_edit'] = $this->createRoute('view', 'edit', array(
                        'id' => $view->id,
                        'post_type' => $post_type
                    ));
                    $actions['manage_delete'] = $this->createRoute('view', 'delete', array(
                        'id' => $view->id,
                        'post_type' => $post_type
                    ));
                }

                $data[] = array(
                    'posttitle' => '<a href="' . $this->createRoute(
                            'view',
                            'view',
                            array('post_type' => $post_type, 'view_name' => $view->name))
                        . '"><strong>' . $view->label . '</strong></a>',
                    'machinename' => $view->name,
                    'actions' => $actions,
                );
            }
        }

        return $data;
    }

}

class Views_List_Table extends Hydra_List_Table {
    var $items_per_page = 10;

    function get_columns() {
        $columns = array(
            'posttitle' => __('Title', 'hydraforms'),
            'machinename' => __('Machine Name', 'hydraforms'),
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
            case 'machinename':
                return $item[$column_name];
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
            'manage_view' => '<a href="' . $item['actions']['manage_view'] . '">' . __('View', 'hydraforms') . '</a>',
        );

        if (!empty($item['actions']['manage_edit'])) {
            $actions['manage_edit'] = '<a href="' . $item['actions']['manage_edit'] . '">' . __('Edit', 'hydraforms') . '</a>';
        }

        if (!empty($item['actions']['manage_delete'])) {
            $actions['manage_delete'] = '<a href="' . $item['actions']['manage_delete'] . '">' . __('Delete', 'hydraforms') . '</a>';
        }

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
