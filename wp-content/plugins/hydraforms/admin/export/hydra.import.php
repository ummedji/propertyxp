<?php
use \Hydra\Builder;

class HydraImportAdmin extends HydraAdmin {
    private $idMapping;
    // @todo MEssaging for import
    private $messages = array();
    private $xml;

    public function importXMLForm() {
        $form = new Builder('hydra-import', '/submit/hydra-import');

        $form->addField('file', array('file', __('File', 'hydraforms')));
        $form->addField('submit', array('submit', __('Import', 'hydraforms')));

        $form->addOnSuccess('importFormSubmit', $this);
        $form->build();

        print "<div class=hydra-page>";
        print $form->render();
        print "</div>";
    }

    public function importFormSubmit($form, $values) {
        $xmlString = file_get_contents($_FILES['file']['tmp_name']);
        $this->import($xmlString, $form);
    }

    public function import($xmlString, $form = null) {
        $simpleXML = simplexml_load_string($xmlString);
        $this->xml = $simpleXML;
        $dbFieldViewModel = new HydraFieldViewModel();

        // 1 process post types
        foreach ($simpleXML->postTypes->children() as $xmlPostType) {
            // import views first
            $this->importViews($xmlPostType);
            $this->importFields($xmlPostType);
            $this->importGroups($xmlPostType);
        }

        foreach ($simpleXML->forms->children() as $xmlForm) {
            $hydraFormRecord = $this->importForm($xmlForm);
            $this->importFormHandler($xmlForm, $hydraFormRecord);
            $this->importFields($xmlForm);
            $this->importFilters($xmlForm);
        }
        $idMapping = $this->idMapping;

        // FIELDS
        foreach ($idMapping['fields'] as $data) {
            $fieldModel = new HydraFieldModel();
            $fieldRecord = $fieldModel->load($data['id']);

            if (isset($idMapping['fields'][$data['parent_id']])) {
                $parent_record = $idMapping['fields'][$data['parent_id']];
                $fieldRecord->parent_id = $parent_record['id'];
                $fieldRecord->save();
            }
        }

        // FILTERS
        if (isset($idMapping['filters']) && count($idMapping['filters'])) {


            foreach ($idMapping['filters'] as $data) {
                $filterModel = new HydraFieldFilterModel();
                $filterRecord = $filterModel->load($data['id']);

                if (isset($idMapping['fields'][$data['field_id']])) {
                    // assign field
                    $field_record = $idMapping['fields'][$data['field_id']];

                    // clear any previous instances
                    $filterModel->deleteByFieldId($field_record['id']);
                    $filterRecord->field_id = $field_record['id'];

                    // assign referrer
                    $referrer_record = $idMapping['fields'][$data['referrer_id']];
                    $filterRecord->referrer_id = $referrer_record['id'];

                    $filterRecord->save();
                }
            }
        }

        if(isset($idMapping['views']) && count($idMapping['views'])) {
            // VIEWS
            foreach ($idMapping['views'] as $data) {
                $fieldModel = new HydraFieldViewModel();
                $fieldRecord = $fieldModel->load($data['id']);

                if (isset($idMapping['views'][$data['parent_id']])) {
                    $parent_record = $idMapping['views'][$data['parent_id']];
                    $fieldRecord->parent_id = $parent_record['id'];
                    $fieldRecord->save();
                }
            }

        }

        if($form) {
            foreach ($this->messages as $message) {
                $form->addSuccessMessage($message);
            }
        } else {
            return $this->messages;
        }
    }

    private function importViews($xmlPostType) {
        /** @var SimpleXMLElement $simpleXML */
        $dbViewModel = new HydraViewModel();
        foreach ($xmlPostType->views->children() as $xmlView) {

            // skip default
            if ((string) $xmlView['name'] == 'default') {
                continue;
            }

            $record = array(
                'name' => (string) $xmlView['name'],
                'label' => (string) $xmlView['label'],
                'post_type' => (string) $xmlView['post_type'],
            );

            // If existing - update, else create
            $viewRecord = $dbViewModel->loadByNamePostType($record['post_type'], $record['name']);
            if ($viewRecord) {
                $viewRecord->updateWithData($record);
                $this->messages[] = "View " . $viewRecord->label . " updated";
            }
            else {
                $viewRecord = new HydraViewRecord($record);
                $this->messages[] = "View " . $viewRecord->label . " created";
            }
            $viewRecord->save();
        }
    }

    private function importFields($xmlPostType) {
        $dbFieldModel = new HydraFieldModel();

        foreach ($xmlPostType->fields->children() as $xmlField) {
            // processing record
            $fieldRecord = array(
                'field_name' => (string) $xmlField['field_name'],
                'post_type' => (string) $xmlField['post_type'],
                'field_type' => (string) $xmlField['field_type'],
                'field_label' => (string) $xmlField['field_label'],
                'widget' => (string) $xmlField['widget'],
                'wrapper' => isset($xmlField['wrapper']) ? (string) $xmlField['wrapper'] : 0,
                'weight' => (string) $xmlField['weight'],
                'cardinality' => (string) $xmlField['cardinality'],
                'parent_id' => 0,
                'translations' => $this->createTranslationArray($xmlField->translations),
            );

            $attributesObject = $xmlField->attributes->attributes();
            $attributesArray = (array) $attributesObject;
            if(isset($attributesArray['@attributes'])) {
                $attributesArray = $attributesArray['@attributes'];
                $fieldRecord['attributes'] = $attributesArray;

                $attributesObject = $xmlField->widget_settings->attributes();
                $attributesArray = (array) $attributesObject;

                if (isset($attributesArray['@attributes'])) {
                    $attributesArray = $attributesArray['@attributes'];
                    $fieldRecord['widget_settings'] = $attributesArray;
                }
                else {
                    $fieldRecord['widget_settings'] = array();
                }
            }

            $hydraField = $dbFieldModel->loadByName($fieldRecord['field_name']);
            $new = TRUE;
            if ($hydraField) {
                $new = FALSE;
                $hydraField->updateWithData($fieldRecord);
                $this->messages[] = "Field " . $hydraField->field_name . '(' . $hydraField->field_label . ') updated';
            }
            else {
                $hydraField = new HydraFieldRecord($fieldRecord);
                $this->messages[] = "Field " . $hydraField->field_name . '(' . $hydraField->field_label . ') created';
            }

            $hydraField->save();
//            if ($new) {
                $this->synchronizeTaxonomy($hydraField);
//            }


            $this->idMapping['fields'][(string) $xmlField['id']] = array(
                'parent_id' => (string) $xmlField['parent_id'],
                'id' => $hydraField->id,
            );

            $this->importFieldViews($xmlField, $hydraField);
        }
    }

    private function importFilters($xmlForm) {
        if (!$xmlForm->filters) {
            return;
        }
        foreach ($xmlForm->filters->children() as $xmlFilter) {

            // processing record
            $hydraFilter = array(
                'field_id' => 0,
                'referrer_id' => 0,
                'col' => (string) $xmlFilter['col'],
                'condition' => (string) $xmlFilter['condition'],
            );

            $hydraFilterRecord = new HydraFieldFilterRecord($hydraFilter);
            $hydraFilterRecord->save();
            // meh
            $this->messages[] = "Filter created";

            $this->idMapping['filters'][(string) $xmlFilter['id']] = array(
                'field_id' => (string) $xmlFilter['field_id'],
                'referrer_id' => (string) $xmlFilter['referrer_id'],
                'id' => $hydraFilterRecord->id,
            );
        }
    }

    private function importGroups($xmlPostType) {
        foreach ($xmlPostType->groups->children() as $xmlView) {
            $db = new HydraFieldViewModel();
            // I can load created record based on field ID !
            $hydraFieldView = $db->loadByFieldName((string)$xmlView['field_name'], (string) $xmlView['view']);
            $fieldViewRecord = array(
                'field_id' => 0,
                'parent_id' => 0,
                'field_name' => (string) $xmlView['field_name'],
                'field_label' => (string) $xmlView['field_label'],
                'view' => (string) $xmlView['view'],
                'weight' => isset($xmlView['weight']) ? (string) $xmlView['weight'] : 0,
                'post_type' => (string)$xmlPostType['name'],
                'formatter' => (string) $xmlView['formatter'],
                'wrapper' => isset($xmlView['wrapper']) ? (string) $xmlView['wrapper'] : 0,
                'hidden' => isset($xmlView['hidden']) ? (string) $xmlView['hidden'] : 0,
            );

            if (isset($xmlView->settings)) {
                $attributesObject = $xmlView->settings->attributes();
                $attributesArray = (array) $attributesObject;
                if (isset($attributesArray['@attributes'])) {
                    $attributesArray = $attributesArray['@attributes'];
                    $fieldViewRecord['settings'] = $attributesArray;
                }
                else {
                    $fieldViewRecord['settings'] = array();
                }
            }

            if ($hydraFieldView) {
                $hydraFieldView->updateWithData($fieldViewRecord);
            }
            else {
                $hydraFieldView = new HydraFieldViewRecord($fieldViewRecord);
            }

            $hydraFieldView->save();

            $this->idMapping['views'][(string) $xmlView['id']] = array(
                'parent_id' => (string) $xmlView['parent_id'],
                'id' => $hydraFieldView->id,
            );
        }

    }

    private function importFieldViews($xmlField, $hydraField) {
        $db = new HydraFieldViewModel();
        foreach ($xmlField->views->children() as $xmlView) {
            $hydraFieldView = $db->loadByFieldName($hydraField->field_name, (string) $xmlView['view']);

            // I can load created record based on field ID !
            $fieldViewRecord = array(
                'field_id' => $hydraField->id,
                'parent_id' => 0,
                'view' => (string) $xmlView['view'],
                'field_name' => (string) $xmlView['field_name'],
                'field_label' => (string) $xmlView['field_label'],
                'weight' => isset($xmlView['weight']) ? (string) $xmlView['weight'] : 0,
                'post_type' => $hydraField->post_type,
                'formatter' => (string) $xmlView['formatter'],
                'wrapper' => isset($xmlView['wrapper']) ? (string) $xmlView['wrapper'] : 0,
                'hidden' => isset($xmlView['hidden']) ? (string) $xmlView['hidden'] : 0,
            );

            if (isset($xmlView->settings)) {
                $attributesObject = $xmlView->settings->attributes();
                $attributesArray = (array) $attributesObject;
                if (isset($attributesArray['@attributes'])) {
                    $attributesArray = $attributesArray['@attributes'];
                    $fieldViewRecord['settings'] = $attributesArray;
                }
                else {
                    $fieldViewRecord['settings'] = array();
                }
            }

            if ($hydraFieldView) {
                $hydraFieldView->updateWithData($fieldViewRecord);
            }
            else {
                $hydraFieldView = new HydraFieldViewRecord($fieldViewRecord);
            }

            $hydraFieldView->save();

            $this->idMapping['views'][(string) $xmlView['id']] = array(
                'parent_id' => (string) $xmlView['parent_id'],
                'id' => $hydraFieldView->id,
            );
        }
    }

    private function importFormHandler($xmlForm, HydraFormRecord $hydraFormRecord) {
        $dbModel = new HydraFormHandlerModel();

        foreach ($xmlForm->handlers->children() as $xmlHandler) {

            $handlerRecordData = array(
                'label' => (string) $xmlHandler['label'],
                'type' => (string) $xmlHandler['type'],
                'weight' => (string) $xmlHandler['weight'],
                'name' => (string) $xmlHandler['name'],
                'form_id' => $hydraFormRecord->id,
                'translations' => $this->createTranslationArray($xmlHandler->translations),
            );

            if (isset($xmlHandler->settings)) {
                $attributesObject = $xmlForm->settings->attributes();
                $attributesArray = (array) $attributesObject;
                $attributesArray = $attributesArray['@attributes'];
                $handlerRecordData['settings'] = $attributesArray;
            }

            $hydraHandlerRecord = $dbModel->loadByName((string) $xmlHandler['name']);
            if (!$hydraHandlerRecord) {
                $hydraHandlerRecord = new HydraFormHandlerRecord($handlerRecordData);
                $this->messages[] = "Handler " . $hydraHandlerRecord->label . " updated";
            }
            else {
                $hydraHandlerRecord->updateWithData($handlerRecordData);
                $this->messages[] = "Handler " . $hydraHandlerRecord->label . " created";
            }

            $hydraHandlerRecord->save();
        }
    }

    private function importForm($xmlForm) {
        $dbModel = new HydraFormModel();
        $name = (string) $xmlForm['name'];
        $hydraFormRecord = $dbModel->loadByName($name);

        $formRecordData = array(
            'name' => (string) $xmlForm['name'],
            'label' => (string) $xmlForm['label'],
            'type' => (string) $xmlForm['type'],
        );

        if (isset($xmlForm->settings)) {
            $attributesObject = $xmlForm->settings->attributes();
            $attributesArray = (array) $attributesObject;
            $attributesArray = $attributesArray['@attributes'];
            $formRecordData['settings'] = $attributesArray;
        }

        if ($hydraFormRecord) {
            $hydraFormRecord->updateWithData($formRecordData);
            $this->messages[] = "Form " . $hydraFormRecord->label . " update";
        }
        else {
            $hydraFormRecord = new HydraFormRecord($formRecordData);
            $this->messages[] = "Form " . $hydraFormRecord->label . " created";
        }

        $hydraFormRecord->save();

        return $hydraFormRecord;
    }

    private function createTranslationArray($xmlTranslations) {
        $translationArray = array();

        foreach ($xmlTranslations->children() as $xmlTranslation) {
            $fieldName = (string) $xmlTranslation['name'];
            $fieldNameParts = explode('[', $fieldName);

            $fieldTranslationArray = array();
            $langArray = array();
            foreach ($xmlTranslation->children() as $language) {
                $langArray[(string) $language['langcode']] = (string) $language;
            }
            $this->buildTransArray($fieldTranslationArray, $fieldNameParts, $langArray);


            $translationArray += $fieldTranslationArray;

        }

        return $translationArray;
    }

    private function buildTransArray(&$fieldTranslationArray, $parts, $values) {
        if (is_string($parts) || (is_array($parts) && !count($parts))) {
            return;
        }

        $part = trim(array_shift($parts), ']');
        $fieldTranslationArray[$part] = array();

        if (!count($parts)) {
            $fieldTranslationArray[$part] = $values;

            return;
        }

        $this->buildTransArray($fieldTranslationArray[$part], $parts, $values);
    }


    /**
     * Taxonomy synchronization will be done only on first field insertion.
     * I have spoken!
     * @param $hydraField
     */
    private function synchronizeTaxonomy($hydraField) {
        if (!isset($hydraField->attributes['taxonomy'])) {
            return;
        }

        $vocabulary = $hydraField->attributes['taxonomy'];

        $vocabularies = $this->xml->xpath('//taxonomy[@vocabulary="' . $vocabulary . '"]');
        if (count($vocabularies)) {
            $xmlVocabulary = reset($vocabularies);
        }
        $xmlTerms = array();

        if(!is_object($xmlVocabulary))  {
            return;
        }

        foreach($xmlVocabulary->children() as $term) {
            $xmlTerms[] = $term;
        }


        if (!count($xmlTerms)) {
            return;
        }

        $termMapping = array();
        foreach ($xmlTerms as $xmlTerm) {
            // 1. first term with same slug
            $oldId = (string) $xmlTerm['id'];
            $term = get_term_by('slug', (string) $xmlTerm['slug'], $vocabulary);
            // 2. retrieve its id
            $newId = $term->term_id;
            // 3. add to mapping
            $termMapping[$oldId] = $newId;
        }

        // 4. retrieve all meta and switch !
        global $wpdb;
        $prepareSQL = $wpdb->prepare(
            'SELECT * FROM ' . $wpdb->prefix . 'postmeta' . ' WHERE meta_key = %s',
            $hydraField->field_name
        );

        $results = $wpdb->get_results($prepareSQL);

        foreach ($results as $result) {
            // delete old records
            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE %s AND post_id = %d",
                    $hydraField->field_name . '\_%\_%',
                    $result->post_id
                )
            );

            $values = unserialize($result->meta_value);

            $saveValues = array();
            // replace
            foreach ($values['items'] as $index => &$item) {

                $value = $item['value'];

                if (is_array($value)) {
                    foreach ($value as $term) {
                        if (isset($termMapping[$term])) {
                            // unset old
                            unset($value[$term]);
                            // add new
                            $value[$termMapping[$term]] = $termMapping[$term];
                        }

                        if (isset($termMapping[$term])) {
                            update_post_meta(
                                $result->post_id,
                                $hydraField->field_name . '_' . $termMapping[$term] . '_value',
                                $value
                            );
                        }
                    }
                }
                else {
                    foreach ($termMapping as $old => $new) {
                        // one match DONE !
                        if ($value == $old) {
                            $value = $new;
                            continue;
                        }
                    }

                    if (isset($termMapping[$term->term_id])) {
                        update_post_meta(
                            $result->post_id,
                            $hydraField->field_name . '_' . $termMapping[$term->term_id] . '_value',
                            $value
                        );
                    }

                }
                $saveValues['items'][]['value'] = $value;
            }


            update_post_meta($result->post_id, $result->meta_key, $saveValues);
        }
    }
}