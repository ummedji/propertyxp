<?php

use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;

/**
 * Field CRUD Interface
 * Class HydraAdminField
 */
class HydraAdminField extends HydraAdmin {

    public function __construct() {
        $this->slug = 'hydrapost';
    }

    /**
     * Create action
     * @param $post_type
     * @param $field_type
     * @param int $parent_id
     * @param int $referrer_id
     */
    public function createAction($post_type, $field_type, $parent_id = 0, $referrer_id = 0) {
        $this->editAction(NULL, $post_type, $field_type, $parent_id, $referrer_id);

    }

    /**
     * Edit action
     * @param null $id
     * @param $post_type
     * @param $field_type
     * @param int $parent_id
     * @param int $referrer_id
     */
    public function editAction($id = NULL, $post_type, $field_type, $parent_id = 0, $referrer_id = 0) {
        $this->includeSortable();
        $manager = new HydraFieldModel();
        $item = NULL;

        if ($id) {
            $item = $manager->load($id);
        }
        print $this->title("Editing " . $item->field_label);

        $form = $this->fieldForm($field_type, $item, $referrer_id);

        if ($item) {
            $form->addField('hidden', array('id', $item->id));
        }

        $form->setAttribute('id', 'field-form');
        $form->addAttribute('class', 'hydra-form');

        $form->addField('hidden', array('post_type', $post_type));
        $form->addField('hidden', array('field_type', $field_type));
        $form->addField('hidden', array('parent_id', !empty($item->parent_id) ? $item->parent_id : $parent_id));
        $form->addField('hidden', array('formatter', !empty($item->formatter) ? $item->formatter : ''));
        $form->addField('hidden', array('hidden', !empty($item->hidden) ? $item->hidden : ''));
        $form->addField('hidden', array('wrapper', !empty($item->wrapper) ? $item->wrapper : 0));
        $form->addField('hidden', array('weight', !empty($item->weight) ? $item->weight : 0));

        $form->addField('submit', array('save', __('Save', 'hydraforms')))
            ->addAttribute('class', 'button-green')
            ->addAttribute('class', 'fl');

        // delete link
        $deleteLink = $this->createLink(__('Delete', 'hydraforms'), $this->createRoute('field', 'delete', array(
            'id' => $item->id,
            'post_type' => $post_type,
            'field_type' => $field_type
        )));
        $form->addField('markup', array('delete', $deleteLink));

        // return link
        $returnLink = $this->createLink(__('Cancel', 'hydraforms'), $this->returnUrl($post_type));
        $form->addField('markup', array(__('cancel', 'hydraforms'), $returnLink));

        $form->addOnSuccess('fieldFormSubmit', $this);

        $form->build();
        print "<div class=hydra-page>";
        print $form->render();
        print "</div>";
    }

    /**
     * @param $field_type
     * @param null $fieldRecord
     * @param int $referrer_id
     * @return Builder
     */
    public function fieldForm($field_type, $fieldRecord = NULL, $referrer_id = 0, $type = 'field') {
        $form = new Builder('field-definition', '/submit/field-definition');


        $manager = new DefinitionManager($form);
        $manager->createDefinition($field_type, $fieldRecord, $type);

        /** @var \Hydra\Builder $form */
        if ($fieldRecord) {
            $form->setValues((array) $fieldRecord);
        }

        return $form;
    }

    /**
     * @param $form
     * @param $values
     */
    public function fieldFormSubmit($form, $values) {
        $dbManager = new HydraFieldModel();

        if ($values['field_type'] == 'fieldset') {
            $values['wrapper'] = 1;
        }

        if (isset($values['id'])) {
            $record = $dbManager->load($values['id']);
            $record->updateWithData($values);
            $record->save();
            $form->addSuccessMessage(sprintf(__('Field "%s" successfully created', 'hydraforms'), $values['field_label']));
        }
        else {
            $record = new HydraFieldRecord($values);
            $record->save();
            $form->addSuccessMessage(sprintf(__('Field "%s" successfully updated', 'hydraforms'), $values['field_label']));
        }

        // Don't remove! its used by descendants of instance
        return $record;
    }

    public function fieldsetForm($postType) {
        $form = new Builder('fieldset-definition', '/submit/fieldset-definition');

        $form->addField('text', array('field_name', 'Name'))
            ->addValidator('required', 'Required')
            ->setDescription('Machine readable name');

        $form->addField('text', array('field_label', 'Label'))
            ->addValidator('required', 'Required')
            ->setDescription('Title of group');

        $form->addField('hidden', array('post_type', $postType));
        $form->addField('hidden', array('wrapper', 1));
        $form->addField('hidden', array('field_type', 'fieldset'));

        $form->addField(
            'select',
            array(
                'formatter',
                '',
                array(
                    'table' => 'Table',
                    'list' => 'List'
                )
            )
        );

        $form->addField('submit', array('submit', __('Submit', 'hydraforms')));

        $form->addOnSuccess('fieldsetFormSubmit', $this);
        $form->build();

        return $form;
    }

    public function fieldsetFormSubmit($form, $values) {
        $record = new HydraFieldRecord($values);
        $record->save();
    }

    /**
     * Delete action
     * @param $id
     * @param $post_type
     * @param $field_type
     * @param int $parent_id
     */
    public function deleteAction($id, $post_type, $field_type, $parent_id = 0) {
        $dbModel = new HydraFieldModel();
        $field = $dbModel->load($id);

        print $this->title(sprintf(__('Delete %s', 'hydraforms'), $field->field_label));

        $cancelUrl = $this->returnUrl($post_type);
        $cancelLink = "<a href=$cancelUrl>Cancel</a>";
        $form = new Builder('field-delete', '/submit/field-delete');

        $form->addField('markup', array(
            'message',
            __('Are you sure you want to delete this field? This action can <b>not</b> be reverted.', 'hydraforms')
        ));
        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('post_type', $post_type));
        $form->addField('hidden', array('field_type', $field_type));
        $form->addField('hidden', array('parent_id', $parent_id));
        $form->addField('submit', array('delete', 'Delete'));
        $form->addField('markup', array('cancel', $cancelLink));

        $form->addOnSuccess('fieldFormDelete', $this);
        $form->build();

        $form->render();
    }

    protected function returnUrl($post_type) {
        return $url = $this->createRoute(
            'post',
            'list',
            array(
                'post_type' => $post_type,
            )
        );
    }

    public function fieldFormDelete($form, $values) {
        $manager = new HydraFieldModel();
        $id = $values['id'];
        $record = $manager->load($id);

        // delete children, poor kids :(
        if ($record->isWrapper()) {
            $fieldContainer = $manager->loadGroupRecordsByName($record->field_name);
            $children = $fieldContainer->getRecords();

            if (count($children)) {
                foreach ($children as $child) {
                    $child->delete();
                }
            }
        }

        $form->addSuccessMessage(sprintf(__('Field "%s" successfully deleted', 'hydraforms'), $record->field_label));

        $record->delete();
    }
}