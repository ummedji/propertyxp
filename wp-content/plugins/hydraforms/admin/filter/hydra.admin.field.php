<?php

class HydraAdminFilterField extends HydraAdminField {

    public function __construct() {
        $this->slug = 'hydrafilter';
    }

    public function fieldForm($fieldType, $fieldRecord = NULL, $referrer_id = 0, $type = 'filter') {
        $form = parent::fieldForm($fieldType, $fieldRecord, $referrer_id, 'filter');

        if($referrer_id) {
            $form->addField('hidden', array('referrer_id', $referrer_id));
        } else {
            $conditions = $fieldRecord->loadConditions();

            if($conditions) {
                $condition = reset($conditions);
                $form->addField('hidden', array('referrer_id', $condition->referrer_id));
            }
        }

        $form->addField('hidden', array('is_filter', true));
        return $form;
    }

    public function fieldFormSubmit($form, $values) {
        $record = parent::fieldFormSubmit($form, $values);
        $conditions = $values['widget_condition'];

        foreach($conditions as $conditionValues) {
            $condition = new HydraFieldFilterRecord($conditionValues);

            // already existing
            if ($conditionValues['id']) {
                $dbModel = new HydraFieldFilterModel();
                $condition = $dbModel->load($conditionValues['id']);
            }
            else {
                $conditionValues['referrer_id'] = $values['referrer_id'];
                $conditionValues['field_id'] = $record->id;
                $condition->field_id = $record->id;
            }

            $condition->updateWithData($conditionValues);
            $condition->save();
        }

        $url = $this->createRoute(
            'filter',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->setRedirect($url);
    }

    public function deleteAction($id, $post_type, $field_type, $parent_id = 0) {
        $dbModel = new HydraFieldModel();
        $field = $dbModel->load($id);
        parent::deleteAction($id, $post_type, $field_type, $parent_id = 0);
    }

    public function fieldFormDelete($form, $values) {
        // delete group
        parent::fieldFormDelete($form, $values);

        $url = $this->createRoute(
            'filter',
            'list',
            array(
                'post_type' => $values['post_type'],
            )
        );

        $form->setRedirect($url);
    }

    protected function returnUrl($post_type) {
        return $this->createRoute(
            'filter',
            'list',
            array(
                'post_type' => $post_type,
            )
        );
    }

}