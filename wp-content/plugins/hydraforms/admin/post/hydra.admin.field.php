<?php


use Hydra\Definitions\DefinitionManager;
use Hydra\Definitions\FieldDefinition;
use Hydra\Builder as Builder;

class HydraAdminPostField extends HydraAdminField {
    public function __construct() {
        $this->slug = 'hydrapost';
    }

    public function fieldFormSubmit($form, $values) {
        $record = parent::fieldFormSubmit($form, $values);

        $url = $this->createRoute(
            'post',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->setRedirect($url);
    }

    protected function returnUrl($post_type) {
        return $this->createRoute(
            'post',
            'list',
            array(
                'post_type' => $post_type,
            )
        );
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

        $form->addField('markup', array('message', __('Are you sure you want to delete this field? This action can <b>not</b> be reverted.', 'hydraforms')));
        $form->addField('hidden', array('id', $id));
        $form->addField('hidden', array('post_type', $post_type));

        // ugly
        if(isset($_GET['view_name'])) {
            $form->addField('hidden', array('view_name', $field_type));
        } else {
            $form->addField('hidden', array('field_type', $field_type));
        }

        $form->addField('hidden', array('parent_id', $parent_id));
        $form->addField('submit', array('delete', 'Delete'));
        $form->addField('markup', array('cancel', $cancelLink));

        $form->addOnSuccess('fieldFormDelete', $this);
        $form->build();

        $form->render();
    }

    public function fieldFormDelete($form, $values) {
        // delete frontend group
        if(isset($values['view_name'])) {
            $fieldViewModel = new HydraFieldViewModel();
            $fieldView = $fieldViewModel->load($values['id']);
            $container = $fieldViewModel->loadGroupRecords($values['id']);
            $children = $container->getRecords();
            if($children) {
                foreach($children as $child) {
                    $child->setParentId(0);
                    $child->save();
                }
            }

            $url = $this->createRoute(
                'view',
                'view',
                array(
                    'post_type' => $values['post_type'],
                    'view_name' => $values['view_name'],
                )
            );

            $fieldView->delete();
        } else {
            // delete regular field
            parent::fieldFormDelete($form, $values);
            $url = parent::returnUrl($values['post_type']);
        }


        $form->setRedirect($url);
    }
}