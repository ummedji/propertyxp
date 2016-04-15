<?php

use \Hydra\Builder;

class HydraAdminFilterFilter extends HydraAdminListFields {
    public function __construct() {
        $this->slug = "hydrafilter";
    }

    public function defaultAction() {
        $forms_list_table = new Forms_List_Table();
        $forms_list_table->data = $this->prepareData();
        $forms_list_table->prepare_items();
        print $this->title(__('Custom Filters Managment', 'hydraforms'));

        $messages = array(
            __('You can manage all your custom filters from this page', 'hydraforms'),
            __('Hydraforms allows you to create multiple custom filters from UI', 'hydraforms'),
            __('Each form can be displayed either via widget, or you can render it programmatically', 'hydraforms'),
        );

        print $this->messages($messages);
        print hydra_render_messages();

        print '<div class="wrap">';
        $forms_list_table->display();
        $createLink = $this->createRoute('filter', 'create', array());
        echo '<a class="btn button" href="' . $createLink . '">' . __('Create Filter', 'hydraforms') . '</a>';
        print '</div>';

        // include 'templates/form_list.tpl.php';
    }

    private function prepareData() {
        $data = array();

        $dbModel = new HydraFormModel();
        $records = $dbModel->loadByType('filter');
        $recordLinks = array();

        if ($records) {
            foreach ($records as $record) {
                $data[] = array(
                    'posttitle' => '<a href="' . $this->createRoute(
                        'filter',
                        'list',
                        array('post_type' => $record->name)
                    ) . '"><strong>' . $record->label . '</strong></a>',
                    'machinename' => $record->name,
                    'actions' => array(
                        'manage_edit' => $this->createLink(
                            __('Edit filter', 'hydraforms'),
                            $this->createRoute('filter', 'edit', array('post_type' => $record->name))
                        ),
                        'manage_delete' => $this->createLink(
                            __('Delete Filter', 'hydraforms'),
                            $this->createRoute('filter', 'delete', array('id' => $record->id))
                        ),
                        'manage_list' => $this->createLink(
                            __('List fields', 'hydraforms'),
                            $this->createRoute('filter', 'list', array('post_type' => $record->name))
                        ),
                    ),
                );
            }
        }

        return $data;
    }

    public function createAction() {
        print $this->title(__('Create filter', 'hydraforms'));
        $this->createForm();
    }

    public function editAction($id) {
        $dbFieldModel = new HydraFormModel();
        $filter = $dbFieldModel->loadByName($id);

        print $this->title(sprintf(__('Edit %s', 'hydraforms'), $filter->getLabel()));
        $this->editForm($id);
    }

    public function createForm() {
        $this->editForm();
    }

    /** @TODO - prototyping, correct later */
    public function editForm($postType = NULL) {
        $values = array();
        $dbFieldModel = new HydraFieldModel();
        if ($postType) {
            $dbModel = new HydraFormModel();
            $record = $dbModel->loadByName($postType);
            $values = $record;
        }

        $form = new Builder('edit-form', '/submit/edit-form');

        if ($postType) {
            $form->addField('hidden', array('post_type', $postType));
        }
        $general = $form->addField('fieldset', array('general', __('General information', 'hydraforms')))
            ->isTree(FALSE);


        $general->addField('text', array('label', __('Label', 'hydraforms')))
            ->enableTranslatable()
            ->addAttribute('class', 'machine-name-source')
            ->addValidator('required')
            ->setDescription(__('Human readable label of the form', 'hydraforms'));

        $general->addField('text', array('name', __('Name', 'hydraforms')))
            ->addAttribute('class', 'machine-name')
            ->addValidator('required')
            ->setDescription(__('Machine-readable name', 'hydraforms'));

        $form->addField('hidden', array('type', 'filter'));

        $fieldset = $form->addField('fieldset', array('settings', __('Settings', 'hydraforms')));

        $fieldset->addField('select', array('post_type', __('Post type', 'hydraforms')))
            ->setOptions($dbFieldModel->loadUsedPostTypesAsArray())
            ->setDescription(__('Select on which post type should filter work', 'hydraforms'));

        $fieldset->addField('text', array('redirect', __('Redirect', 'hydraforms')))
            ->enableTranslatable()
            ->setDescription(__('Select the page which will load the results', 'hydraforms'));

        $fieldset->addField('checkbox', array('enable_title', __('Display title', 'hydraforms')))
            ->setDescription(__('If enabled, label will be displayed on frontend as title of the form', 'hydraforms'));

        $fieldset->addField('checkbox', array('enable_widget', __('Enable widget for this form', 'hydraforms')))
            ->setDescription(__('If enabled, this form will be available via widget', 'hydraforms'));

        $fieldset->addField('text', array('submit_text', __('Submit button text', 'hydraforms')))
            ->setDescription(__('Value of submit button on frontend', 'hydraforms'))
            ->enableTranslatable()
            ->setDefaultValue('Submit');

        $fieldset->addField('text', array('class', __('Form class', 'hydraforms')))
            ->setDescription(__('Additional class for frontend', 'hydraforms'));

        $form->addField('submit', array('save', __('Save', 'hydraforms')));
        $form->addOnSuccess('editFormSubmit', $this);

        if (isset($record)) {
            // delete link
            $deleteLink = $this->createLink(
                __('Delete', 'hydraforms'),
                $this->createRoute('filter', 'delete', array('post_type' => $postType))
            );
            $form->addField('markup', array('delete', $deleteLink));
        }

        // return link
        $returnLink = $this->createLink(__('Cancel', 'hydraforms'), $this->createRoute('filter', 'default', array()));
        $form->addField('markup', array('cancel', $returnLink));

        if (isset($record)) {
            $form->setValues((array) $values);
        }

        $form->build();

        print $form->render();
    }

    public function editFormSubmit($form, $values) {
        if (isset($values['post_type'])) {
            $dbModel = new HydraFormModel();
            $hydraFormRecord = $dbModel->loadByName($values['post_type']);
            $hydraFormRecord->updateWithData($values);
            $form->addSuccessMessage(
                sprintf(__('Filter "%s" successfully updated', 'hydraforms'), $hydraFormRecord->getLabel())
            );
        }
        else {
            $hydraFormRecord = new HydraFormRecord($values);
            $form->addSuccessMessage(
                sprintf(__('Filter "%s" successfully created', 'hydraforms'), $hydraFormRecord->getLabel())
            );
        }

        if ($hydraFormRecord) {
            $hydraFormRecord->save();
        }

        $form->setRedirect(
            $this->createRoute(
                'filter',
                'default',
                array()
            )
        );
    }

    public function listAction($post_type) {
        $compactedVals = parent::listAction($post_type);

        $messages = array(
            __('You can add only filters for fields which are attached to your selected', 'hydraforms'),
        );

        $messages = $this->messages($messages);
        extract($compactedVals);
        unset($compactedVals);

        include 'templates/field_list.tpl.php';
    }

    /**
     * We need to overwrite this, filters have different behaviour and can't be created, only derivated from existing field
     * @param $post_type
     * @return Builder
     */
    public function addForm($postType) {
        $dbModel = new HydraFieldModel();
        $dbFormModel = new HydraFormModel();
        $formRecord = $dbFormModel->loadByName($postType);

        if (!isset($formRecord->settings['post_type'])) {
            return;
            //@todo - throw exception possibly
        }

        $filterPostType = $formRecord->settings['post_type'];

        $form = new Builder('add-new-field', '/submit/add-new-field');
        $form->addField('hidden', array('post_type', $postType));
        $form->addField('select', array('referrer_id', __('Select field', 'hydraforms')))
            ->setOptions($dbModel->loadByPostTypeOptions($filterPostType))
            ->setDescription(__('Select Field for which <br/> you want to create filtering condition.', 'hydraforms'));

        $form->addField('submit', array('add_field', __('Create Filter', 'hydraforms')));
        $form->addOnValidation('validateFormSubmit', $this);
        $form->addOnSuccess('addFormSubmit', $this);
        $form->build();

        return $form;
    }


    /**
     * Form validation
     * @param $form
     * @param $values
     * @return array
     */
    public function validateFormSubmit($form, $values) {
        $messages = array();
        // check for empty reference_id, from time to time 0 reference_id occurs, unknown reason
        if (!isset($values['referrer_id']) || empty($values['referrer_id'])) {
            $messages[] = array(__('Invalid options selected', 'example'), 'referrer_id');

            return $messages;
        }
    }

    /**
     * 1. clone field referrer field
     * 2. save the field
     * 3. redirect to detail of the field
     * @param $form
     * @param $values
     * @return HydraFieldRecord|void
     */
    public function addFormSubmit($form, $values) {
        $dbModel = new HydraFieldModel();
        $referrer_id = $values['referrer_id'];
        $field = $dbModel->load($referrer_id);

        // 1. Remove id so new record gets inserted , instead of update
        $field->id = 0;
        // 2. Generate machine name
        $field->field_name = $this->generateFieldMachineName($field->field_name);
        // 3. Assign to filter, not to content
        $field->post_type = $values['post_type'];
        $field->weight = 99;
        $field->parent_id = 0;
        $field->save();

        // 4 set redirect with referrer id
        $form->setRedirect(
            $this->createRoute(
                'field',
                'edit',
                array(
                    'id' => $field->id,
                    'post_type' => $field->post_type,
                    'field_type' => $field->field_type,
                    'parent_id' => 0,
                    'referrer_id' => $values['referrer_id']
                )
            )
        );
    }

    private function generateFieldMachineName($fieldName) {
        $dbModels = new HydraFieldModel();
        $tmpName = $fieldName . '_filter';

        $newName = $tmpName;
        $i = 1;
        while ($dbModels->loadByName($newName)) {
            $newName = $tmpName . '_' . $i;
            $i++;
        }

        return $newName;
    }


    public function sortFormSubmit($form, $values) {
        parent::sortFormSubmit($form, $values);

        $url = $this->createRoute(
            'filter',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->setRedirect($url);
    }

    public function deleteAction($id) {
        $form = new Builder('delete-form', '/submit/delete-form');
        $dbModel = new HydraFormModel();
        $record = $dbModel->loadByName($id);
        print $this->title(sprintf(__('Delete %s', 'superforms'), $record->getLabel()));

        $cancelUrl = $this->createRoute(
            'filter',
            'default',
            array()
        );

        $cancelLink = "<a href=$cancelUrl>" . __("Cancel", 'hydraforms') . "</a>";
        $form->setRedirect($cancelUrl);

        $form->addField(
            'markup',
            array(
                'message',
                __('Are you sure you want to delete this filter? This action can <b>not</b> reverted!', 'hydraforms')
            )
        );
        $form->addField('hidden', array('id', $id));
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
        $form->addSuccessMessage(sprintf('Filter "%s" successfully deleted', 'hydraforms'), $record->getLabel());
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
