<?php

use Hydra\Builder;

class HydraAdminListFields extends HydraAdmin {

    public function listAction($post_type) {
        $manager = new HydraFieldModel();
        $container = $manager->loadByPostType($post_type);

        $items = $container->getHierarchy();
        $sortForm = $this->sortForm($post_type);
        $tabs = $this->tabsMenu($post_type);
        $title = $this->title('Manage fields - ' . $post_type);
        $addForm = $this->addForm($post_type);

        $variablesList = array('tabs', 'items', 'sortForm', 'title', 'addForm');

        return compact($variablesList);
    }

    public function addForm($postType) {

        $form = new Builder('add-new-field', '/submit/add-new-field');

        $options = hydra_field_get_definition_options();

        $form->addField('select', array('field_type', 'Type'))
            ->addAttribute('class', 'select-chosen')
            ->setOptions($options);

        $form->addField('text', array('field_label', 'Label'))
            ->setDescription('Human readable label')
            ->addValidator('required', 'Field label is required')
            ->addAttribute('class', 'machine-name-source');

        $form->addField('text', array('field_name', 'Machine name'))
            ->addDecorator('prefix', array('hf_' . $postType . '_'))
            ->setDescription('Machine readable name')
            ->addValidator('required', 'Machine name is required')
            ->addAttribute('class', 'machine-name');

        $form->addField('hidden', array('post_type', $postType));
        $form->addField('submit', array('add_field', 'Add field'));

        $form->addOnSuccess('addFormSubmit', $this);
        $form->build();

        return $form;
    }

    public function addFormSubmit($form, $values) {
        $postType = $values['post_type'];
        $values['field_name'] = 'hf_' . $postType . '_' . $values['field_name'];

        $record = new HydraFieldRecord($values);

        $options = hydra_widget_get_widgets_for_type($record->field_type);
        $keys = array_keys($options);
        $record->widget = reset($keys);
        $record->save();

        return $record;
    }

    /**
     * Sorting form
     * @param $type
     * @return Builder
     */
    public function sortForm($type) {
        $this->includeSortable();

        $manager = new HydraFieldModel();
        $container = $manager->loadByPostType($type);
        $items = $container->getHierarchy();

        $sortForm = new Builder('sort', '/submit/sort');
        $sortForm->addField('hidden', array('post_type', $type));

        foreach ($items as $set) {

            $fieldset = $sortForm->addField('fieldset', array($set->id));
            $fieldset->addField('hidden', array('parent_id', $set->parent_id))
                ->setAttribute('id', 'parent-' . $set->id);
            $fieldset->addField('hidden', array('hidden', $set->hidden))->setAttribute('id', 'hidden-' . $set->id);
            $fieldset->addField('hidden', array('weight', $set->weight))->setAttribute('id', 'weight-' . $set->id);

            if ($set->isWrapper() && $set->hasChildren()) {
                foreach ($set->getChildren() as $item) {
                    $itemFieldset = $fieldset->addField('fieldset', array($item->id));

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

    /**
     * Save sorting
     * @param $form
     * @param $values
     */
    public function sortFormSubmit($form, $values) {
        $manager = new HydraFieldModel();

        $container = $manager->loadByPostType($values['post_type']);
        $items = $container->getRecords();

        foreach ($items as $item) {
            /** @var $item HydraFieldRecord */
            if ($item->isWrapper() || $item->parent_id == 0) {
                $item->updateWithData($values[$item->id]);
            }
            else {
                $item->updateWithData($values[$item->parent_id][$item->id]);
            }
            $item->save();
        }

        $form->addSuccessMessage(__('Sorting was successfully updated', 'hydraforms'));
    }
}