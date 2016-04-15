<?php

use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;
use Hydra\Handlers\Handler;

/**
 * Field CRUD Interface
 * Class HydraAdminField
 */
class HydraAdminFormHandler extends HydraAdmin {

    public function __construct() {
        $this->slug = 'hydraform';
    }

    public function listAction($post_type) {

        $this->includeCss();
        $controller = new HydraAdminFormForm();
        $handlerModel = new HydraFormHandlerModel();
        $formModel = new HydraFormModel();

        $form = $formModel->loadByName($post_type);
        $items = $handlerModel->loadByFormId($form->id);

        $addForm = $this->addHandlerForm($post_type);
        $sortForm = $this->sortForm($items, $post_type);

        $messages = array(
            __('You can manage all form handlers here. Handlers are actions which will be executed after submitting the form', 'hydraforms'),
            __('If you add "Mail" handler, mail according to your settings will be send after successfull submission', 'hydraforms'),
        );
        $messages = $this->messages($messages);
        $title = $this->title(sprintf(__('Manage handlers %s', 'hydraforms'), $form->getLabel()));
        $tabs = $controller->tabsMenu($post_type);

        include 'templates/handler/handler_list.tpl.php';
    }

    public function sortForm($items, $post_type) {
        $this->includeSortable();

        $sortForm = new Builder('view-sort', '/submit/view-sort');
        $sortForm->addField('hidden', array('post_type', $post_type));

        foreach ($items as $item) {
            $fieldset = $sortForm->addField('fieldset', array($item->id));

            $fieldset->addField('hidden', array('weight', __('Weight', 'hydraforms')))
                ->setAttribute('id', 'weight-' . $item->id)
                ->setDefaultValue($item->weight);
        }

        $sortForm->addField('submit', array('save', __('Save', 'hydraforms')))
            ->addAttribute('class', 'button-green');

        $sortForm->addOnSuccess('sortFormSubmit', $this);
        $sortForm->build();

        return $sortForm;
    }

    public function sortFormSubmit($form, $values) {
        $id = $values['post_type'];
        $manager = new HydraFormHandlerModel();
        $items = $manager->loadByFormId($id);

        foreach ($items as $item) {
            $item->updateWithData($values[$item->id]);
            $item->save();
        }

        $form->setRedirect(
            $this->createRoute(
                'handler',
                'list',
                array('post_type' => $values['post_type'])
            )
        );
    }


    public function createHandlerForm() {

    }

    public function addHandlerForm($post_type) {
        $this->includeSortable();
        $form = new Builder('add-handler', '/submit/add-handler');

        $form->addField('hidden', array('post_type', $post_type));
        $options = hydra_handler_settings();

        $form->addField('select', array('type', __('Type', 'hydraforms')))
            ->setOptions($options);

        $form->addField('hidden', array('post_type', $post_type));

        $form->addField('text', array('label', __('Label', 'hydraforms')))
            ->addAttribute('class', 'machine-name-source')
            ->addValidator('required')
            ->setDescription(__('Human readable label of the form', 'hydraforms'));

        $form->addField('text', array('name', __('Name', 'hydraforms')))
            ->addAttribute('class', 'machine-name')
            ->addValidator('required')
            ->setDescription(__('Machine-readable name', 'hydraforms'));

        $form->addField('submit', array('add_field', __('Create handler', 'hydraforms')));

        $form->addOnSuccess('addHandlerFormSubmit', $this);

        $form->build();
        return $form;
    }

    public function addHandlerFormSubmit($form, $values) {
        $formModel = new HydraFormModel();
        $formRecord = $formModel->loadByName($values['post_type']);
        $handler = new HydraFormHandlerRecord(array(
            'label' => $values['label'],
            'type' => $values['type'],
            'name' => $values['name'],
            'form_id' => $formRecord->id,
        ));

        $handler->save();

        $url = $this->createRoute(
            'handler',
            'edit',
            array(
                'id' => $handler->id,
                'post_type' => $values['post_type'],
                'type' => $values['type'],
            )
        );

        $form->addSuccessMessage(__('Handler successfully created', 'hydraforms'));
        $form->setRedirect($url);
    }

    public function createAction($post_type, $type) {
        $this->editAction(NULL, $post_type, $type);
    }

    public function editAction($id = NULL, $post_type, $type) {

        if ($id) {
            $dbModel = new HydraFormHandlerModel();
            $item = $dbModel->load($id);
            $values = (array) $item;
            unset($values['form_id']);
        }

        $formModel = new HydraFormModel();
        $formRecord = $formModel->loadByName($post_type);

        $form = new Builder('handler-form', '/submit/handler-form');
        $form->addAttribute('class', 'hydra-form');

        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('type', $type));
        $form->addField('hidden', array('post_type', $post_type));
        $form->addField('hidden', array('hydraform_id', $formRecord->id));

        $fieldset = $form->addField('fieldset', array('general', __('General information', 'hydraforms')))
            ->isTree(FALSE);
        $fieldset->addDecorator('table');

        $fieldset->addField('text', array('name', __('Machine name', 'hydraforms')))
            ->setDescription(__('Machine readable name', 'hydraforms'))
            ->setAttribute('disabled', TRUE);

        $fieldset->addField('text', array('label', __('Label', 'hydraforms')))
            ->setDescription(__('Field label', 'hydraforms'));

        $handler = Handler::getHandler($type);

        $tokenManager = new \HydraFormToken($post_type);
        $fieldset = $form->addField('fieldset', array('settings', __('Settings', 'hydraforms')));
        $fieldset->addDecorator('table');
        $postTypeContext = array();

        if(isset($formRecord->settings['post_type_context'])) {
            $postTypeContext = $formRecord->settings['post_type_context'];
        }

        $fieldset->addField('markup', array('markup', $tokenManager->listTokens($postTypeContext)));
        $fields = $handler->getSettings($fieldset);

        $form->addField('submit', array('submit', __('Save', 'hydraforms')))
            ->addAttribute('class', 'btn button-green fl');
        $form->addOnSuccess('editActionSubmit', $this);

        // delete link
        if ($item) {
            $deleteLink = $this->createLink(__('Delete', 'hydraforms'), $this->createRoute('handler', 'delete', array(
                'id' => $item->id,
                'post_type' => $post_type
            )));
            $form->addField('markup', array('delete', $deleteLink));
        }

        $returnLink = $this->createLink(__('Cancel', 'hydraforms'), $this->createRoute('handler', 'list', array('post_type' => $post_type)));
        $form->addField('markup', array(__('cancel', 'hydraforms'), $returnLink));

        if (isset($values)) {
            $form->setValues($values);
        }

        print $this->title(sprintf(__('Edit %s', 'hydraforms'), $item->label));

        $form->build();
        print "<div class=hydra-page>";
        $form->render();
        print "</div>";
    }

    public function editActionSubmit($form, $values) {
        $values['form_id'] = $values['hydraform_id'];

        if ($values['id']) {
            $dbModel = new HydraFormHandlerModel();
            $hydraFormHandler = $dbModel->load($values['id']);
            $hydraFormHandler->updateWithData($values);
        }
        else {
            $hydraFormHandler = new HydraFormHandlerRecord($values);
        }

        $hydraFormHandler->save();

        $url = $this->createRoute(
            'handler',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->addSuccessMessage(sprintf(__('Handler "%s" successfully updated', 'hydraforms'), $hydraFormHandler->label));
        $form->setRedirect($url);
    }

    /**
     *
     */
    public function deleteAction($id, $post_type) {
        $handlerModel = new HydraFormHandlerModel();
        $handler = $handlerModel->load($id);
        print $this->title(sprintf(__('Delete %s', 'superforms'), $handler->label));

        $form = $this->handlerDeleteForm($id, $post_type);
        $form->render();
    }

    public function handlerDeleteForm($id, $post_type) {
        $cancelUrl = $this->createRoute('handler', 'list', array('post_type' => $post_type));
        $cancelLink = "<a href=$cancelUrl>" . __("Cancel", 'hydraforms') . "</a>";

        $form = new Builder('handler-delete', '/submit/handler-delete');
        $form->setRedirect($cancelUrl);

        $form->addField('markup', array(
            'message',
            __('Are you sure you want to delete this handler ? This action can <b>not</b> be reverted!', 'hydraforms')
        ));
        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('post_type', $post_type));

        $form->addField('markup', array('cancel', $cancelLink));
        $form->addField('submit', array('delete', __('Delete', 'hydraforms')));


        $form->addOnSuccess('handlerDeleteFormSubmit', $this);
        $form->build();

        return $form;
    }

    public function handlerDeleteFormSubmit($form, $values) {
        $id = $values['id'];

        $handlerModel = new HydraFormHandlerModel();
        $handlerRecord = $handlerModel->load($id);

        $handlerRecord->delete();

        $form->addSuccessMessage(sprintf(__('Handler "%s" successfully deleted', 'hydraforms'), $handlerRecord->label));
    }
}