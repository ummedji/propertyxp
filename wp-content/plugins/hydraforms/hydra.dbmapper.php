<?php

use Hydra\Decorators\FieldDecorator;
use Hydra\Builder;
use Hydra\Fields\FieldsetField;
use Hydra\Decorators\TableDecorator;
use Hydra\Definitions\DefinitionManager;
use Hydra\Widgets\Widget;

require_once 'hydra/fields/FieldsetField.php';
require_once 'hydra/decorators/TableDecorator.php';


class HydraDBMapper {

    public function __construct() {

    }

    /**
     * @param HydraFieldRecord $fieldRecord
     * @param $form
     * @param null $postId
     */
    public function generateFromRecord(HydraFieldRecord $fieldRecord, $form, $postId = NULL) {
        $field = NULL;

        $dbModel = new HydraFieldModel();

        $noWrapper = FALSE;
        if (in_array($fieldRecord->post_type, get_post_types())) {

            $noWrapper = FALSE;
        }
        else {
            $formModel = new HydraFormModel();
            $formRecord = $formModel->loadByName($fieldRecord->post_type);
            if ($formRecord->type == 'filter') {
                $noWrapper = FALSE;
            }
        }

        if ($fieldRecord->isWrapper()) {
            $fieldSet = $form->addField('fieldset', array($fieldRecord->field_name, $fieldRecord->field_label));
            $fieldSet->addDecorator('table');
            $fieldSet->isTree();
            if ($fieldRecord->hasChildren()) {
                foreach ($fieldRecord->getChildren() as $record) {
                    $this->generateField($record, $fieldSet, $postId, $noWrapper);
                }
            }
        }
        else {
            $this->generateField($fieldRecord, $form, $postId, $noWrapper);
        }
    }


    /**
     * @param HydraFieldRecord $fieldRecord
     * @param $form
     * @param null $postId
     * @param bool $noWrapper
     */
    public function generateField(HydraFieldRecord $fieldRecord, $form, $postId = NULL, $noWrapper = FALSE) {
        if ($postId) {
            $fieldRecord->loadMeta($postId);
        }

        $manager = new DefinitionManager();
        $definition = $manager->createDefinition($fieldRecord->field_type);
        $widgetManager = new \Hydra\Widgets\WidgetManager();
        // @todo TEST

        if (!$noWrapper) {
            $fieldset = $form->addField('fieldset', array($fieldRecord->field_name, $fieldRecord->getLabel()));
            $widgetManager->getWidgetForm(
                $fieldRecord->widget,
                $definition,
                $fieldRecord,
                $fieldset,
                $noWrapper
            );
            $fieldset->setValue($fieldRecord->widget_settings);
        }
        else {
            $widgetManager->getWidgetForm($fieldRecord->widget, $definition, $fieldRecord, $form, $noWrapper);
        }
    }


    /**
     * @todo
     */
    public function addValidators() {

    }

    /**
     * @todo
     */
    public function addDecorators() {

    }

    /**
     * @param $type
     * @params $args
     * @return object
     */
    public function createFormField($type, $args) {
        return Builder::createField($type, $args);
    }
}

