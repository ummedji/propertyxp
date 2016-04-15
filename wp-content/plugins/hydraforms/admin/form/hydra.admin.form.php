<?php

use \Hydra\Builder;

class HydraAdminFormForm extends HydraAdminListFields {
    public function __construct() {
        $this->slug = "hydraform";
    }

    public function tabsMenu($postType, $id = NULL) {
        $db = new HydraViewModel();
        $links = array();

        $tabs = array(
            'fields' => array(
                'title' => __('Manage Fields', 'hydraforms'),
                'link' => $this->createRoute(
                    'form',
                    'list',
                    array('post_type' => $postType)
                )
            ),
            'handlers' => array(
                'title' => __('Handlers', 'hydraforms'),
                'link' => $this->createRoute(
                    'handler',
                    'list',
                    array('post_type' => $postType)
                )
            ),
        );


        ob_start();
        include 'templates/tabs.tpl.php';

        return ob_get_clean();
    }

    public function defaultAction() {

        $forms_list_table = new Forms_List_Table();
        $forms_list_table->data = $this->prepareData();
        $forms_list_table->prepare_items();
        print $this->title(__('Custom Forms Managment', 'hydraforms'));
        $messages = array(
            __('You can manage all your custom forms from this page', 'hydraforms'),
            __('Hydraforms allows you to create multiple custom forms from UI', 'hydraforms'),
            __('Each form can be displayed either via widget, or you can render it programmatically', 'hydraforms'),
        );

        print $this->messages($messages);
        print hydra_render_messages();
        print '<div class="wrap">';
        $forms_list_table->display();

        $createLink = $this->createRoute('form', 'create', array());
        echo '<a class="btn button" href="' . $createLink . '">' . __('Create Form', 'hydraforms') . '</a>';
        print '</div>';

        // include 'templates/form_list.tpl.php';
    }

    private function prepareData() {
        $data = array();

        $dbModel = new HydraFormModel();
        $records = $dbModel->loadByType('form');
        $recordLinks = array();

        if ($records) {
            foreach ($records as $record) {
                $data[] = array(
                    'posttitle' => '<a href="' . $this->createRoute(
                        'form',
                        'list',
                        array('post_type' => $record->name)
                    ) . '"><strong>' . $record->label . '</strong></a>',
                    'machinename' => $record->name,
                    'actions' => array(
                        'manage_edit' => $this->createLink(
                            __('Edit form', 'hydraforms'),
                            $this->createRoute('form', 'edit', array('post_type' => $record->name))
                        ),
                        'manage_delete' => $this->createLink(
                            __('Delete form', 'hydraforms'),
                            $this->createRoute('form', 'delete', array('post_type' => $record->name))
                        ),
                        'manage_field' => $this->createLink(
                            __('List fields', 'hydraforms'),
                            $this->createRoute('form', 'list', array('post_type' => $record->name))
                        ),
                        'manage_handlers' => $this->createLink(
                            __('List handlers', 'hydraforms'),
                            $this->createRoute('handler', 'list', array('post_type' => $record->name))
                        ),
                    ),
                );
            }
        }

        return $data;
    }

    public function createAction() {
        print $this->title(__('Create form', 'hydraforms'));
        $this->createForm();
    }

    public function editAction($postType) {
        $dbForm = new HydraFormModel();
        $form = $dbForm->loadByName($postType);


        print $this->title(sprintf(__('Edit %s', 'hydraforms'), $form->getLabel()));
        $this->editForm($postType);
    }

    public function createForm() {
        $this->editForm();
    }

    /** @TODO - prototyping, correct later */
    public function editForm($postType = NULL) {
        $values = array();

        if ($postType) {
            $dbModel = new HydraFormModel();
            $record = (array) $dbModel->loadByName($postType);
            $values = $record;
        }

        $form = new Builder('hydra-edit-form', '/submit/hydra-edit-form');
        $form->addAttribute('class', 'hydra-form');

        $general = $form->addField('fieldset', array('general', __('General information', 'hydraforms')))
            ->isTree(FALSE);
        $general->addDecorator('table');

        if ($postType) {
            $form->addField('hidden', array('post_type', $postType));
        }
        $form->addField('hidden', array('type', 'form'));

        $general->addField('text', array('label', __('Label', 'hydraforms')))
            ->addAttribute('class', 'machine-name-source')
            ->addValidator('required')
            ->enableTranslatable()
            ->setDescription(__('Human readable label of the form', 'hydraforms'));

        $machineName = $general->addField('text', array('name', __('Name', 'hydraforms')))
            ->addAttribute('class', 'machine-name')
            ->addValidator('required')
            ->setDescription(__('Machine-readable name', 'hydraforms'));

        if ($postType) {
            $machineName->setAttribute('disabled', TRUE);
        }

        $fieldset = $form->addField('fieldset', array('settings', __('Settings', 'hydraforms')));
        $fieldset->addDecorator('table');

        $fieldModel = new HydraFieldModel();
        $post_types = $fieldModel->loadUsedPostTypes();
        $options = array();
        $types = get_post_types();

        foreach ($post_types as $post_type) {
            if (in_array($post_type->post_type, $types)) {
                $options[$post_type->post_type] = $post_type->post_type;
            }
        }

        $fieldset->addField('checkboxes', array('post_type_context', __('Has context of post type', 'hydraforms')))
            ->setOptions($options)
            ->setDescription(__('If form works with context of some post types, select the values'));

        $fieldset->addField('checkbox', array('enable_title', __('Display title', 'hydraforms')))
            ->setDescription(__('If enabled, label will be displayed on frontend as title of the form', 'hydraforms'));

        $fieldset->addField('checkbox', array('enable_widget', __('Enable widget for this form', 'hydraforms')))
            ->setDescription(__('If enabled, this form will be available via widget', 'hydraforms'));

        $fieldset->addField('text', array('submit_text', __('Submit button text', 'hydraforms')))
            ->enableTranslatable()
            ->setDescription(__('Value of submit button on frontend', 'hydraforms'))
            ->setDefaultValue('Submit');

        $fieldset->addField('text', array('class', __('Form class', 'hydraforms')))
            ->setDescription(__('Additional class for frontend', 'hydraforms'));

        $form->addField('submit', array('save', __('Save', 'hydraforms')))
            ->addAttribute('class', 'button-green')
            ->addAttribute('class', 'fl');
        $form->addOnSuccess('editFormSubmit', $this);

        if (isset($record)) {
            $form->setValues($values);
            // delete link
            $deleteLink = $this->createLink(
                __('Delete', 'hydraforms'),
                $this->createRoute('form', 'delete', array('post_type' => $postType))
            );
            $form->addField('markup', array('delete', $deleteLink));
        }

        // return link
        $returnLink = $this->createLink(__('Cancel', 'hydraforms'), $this->createRoute('form', 'default', array()));
        $form->addField('markup', array(__('cancel', 'hydraforms'), $returnLink));

        $form->build();
        print "<div class=hydra-page>";
        print $form->render();
        print "</div>";
    }

    public function editFormSubmit($form, $values) {
        if (isset($values['post_type'])) {
            $dbModel = new HydraFormModel();
            $hydraFormRecord = $dbModel->loadByName($values['post_type']);
            $hydraFormRecord->updateWithData($values);

        }
        else {
            $hydraFormRecord = new HydraFormRecord($values);
        }

        if ($hydraFormRecord) {
            $hydraFormRecord->save();
        }

        $form->setRedirect(
            $this->createRoute(
                'form',
                'default',
                array()
            )
        );

        $form->addSuccessMessage(sprintf(__('Form %s successfully saved', 'hydraforms'), $hydraFormRecord->getLabel()));
    }


    public function listAction($post_type) {
        $compactedVals = parent::listAction($post_type);
        extract($compactedVals);
        unset($compactedVals);

        $dbForm = new HydraFormModel();
        $form = $dbForm->loadByName($post_type);
        $title = $this->title('Manage fields ' . $form->label);

        $messages = array(
            __('You can manage all form fields here', 'hydraforms'),
            __('You can change order by using drag&drop and clicking "Save" button to confirm changes', 'hydraforms'),
        );

        $messages = $this->messages($messages);

        include 'templates/field_list.tpl.php';
    }

    public function addFormSubmit($form, $values) {
        $record = parent::addFormSubmit($form, $values);
        $route = $this->createRoute(
            'field',
            'edit',
            array(
                'id' => $record->id,
                'post_type' => $record->post_type,
                'field_type' => $record->field_type
            )
        );
        $form->setRedirect($route);
    }

    public function sortFormSubmit($form, $values) {
        parent::sortFormSubmit($form, $values);

        $url = $this->createRoute(
            'form',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->setRedirect($url);
    }

    public function deleteAction($postType) {
        $formModel = new HydraFormModel();
        $formRecord = $formModel->loadByName($postType);

        print $this->title(sprintf(__('Delete %s', 'hydraforms'), $formRecord->getLabel()));

        $form = new Builder('delete-form', '/submit/delete-form');

        $cancelUrl = $this->createRoute('form', 'default', array());
        $cancelLink = $this->createLink(__('Cancel', 'hydraforms'), $cancelUrl);

        $form->setRedirect($cancelUrl);
        $form->addField(
            'markup',
            array(
                'message',
                __('Are you sure you want to delete this form? This can <b>not</b> be reverted!', 'hydraforms')
            )
        );
        $form->addField('hidden', array('id', $postType));
        $form->addField('markup', array('cancel', $cancelLink));
        $form->addField('submit', array('delete', __('Delete', 'hydraforms')));
        $form->addOnSuccess('deleteActionSubmit', $this);
        $form->build();
        $form->render();
    }

    public function deleteActionSubmit($form, $values) {
        $id = $values['id'];

        $dbModel = new HydraFormModel();
        $record = $dbModel->loadByName($id);

        $record->delete();

        $form->addSuccessMessage(sprintf(__('Form %s was successfully deleted', 'hydraforms'), $record->getLabel()));
    }
}


class Forms_List_Table extends Hydra_List_Table {
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

        $this->found_data = array_slice(
            $this->data,
            (($current_page - 1) * $this->items_per_page),
            $this->items_per_page
        );

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page' => $this->items_per_page,
            )
        );

        $this->items = $this->found_data;
    }

    function column_posttitle($item) {

        return sprintf('%1$s %2$s', $item['posttitle'], $this->row_actions($item['actions']));
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