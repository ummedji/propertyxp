<?php


use \Hydra\Builder;

require_once 'hydra.import.php';

add_action('admin_menu', 'hydra_export_admin_menu');

function hydra_export_admin_menu() {
    $hydraOptions = new HydraExportAdmin();
    $icon = '/wp-content/plugins/hydraforms/assets/img/icon-small.png';

    add_submenu_page(
        'hydrapost',
        __('Export', 'hydraforms'),
        __('Export', 'hydraforms'),
        'edit_pages',
        'hydraexport',
        array($hydraOptions, 'router')
    );

    add_submenu_page(
        'hydrapost',
        __('Import', 'hydraforms'),
        __('Import', 'hydraforms'),
        'edit_pages',
        'hydraimport',
        array($hydraOptions, 'router')
    );
}


class HydraExportAdmin extends HydraAdmin {

    public function router() {
        $params = $_GET;
        switch ($_GET['page']) {
            case "hydraexport":
                print $this->title(__('Export forms', 'hydraforms'));
                $messages = array(
                    __('Here you can select HydraForms element you wish to export into xml', 'hydraforms'),
                    __('Resulting xml file will be automatically offered for download', 'hydraforms'),
                    __('Disabling wp_debug is advised ( if enabled )', 'hydraforms'),
                );

                print $this->messages($messages);
                $this->exportForm();
                break;
            case "hydraimport":
                $import = new HydraImportAdmin();

                print $this->title(__('Import forms', 'hydraforms'));
                $messages = array(
                    __('Note that all imported data will overwrite current HydraForms configuration.', 'hydraforms'),
                );
                print $this->messages($messages);

                $import->importXMLForm();
                break;
        }
    }

    public function exportForm() {
        $dbModelFields = new HydraFieldModel();
        $dbModelForms = new HydraFormModel();

        $usedPostTypes = $dbModelFields->loadUsedPostTypes();
        $forms = $dbModelForms->loadAll();

        $formOptions = array();
        foreach ($forms as $form) {
            $formOptions[$form->name] = $form->label;
        }

        $postTypeOptions = array();
        foreach ($usedPostTypes as $postType) {
            if (!in_array($postType->post_type, array_keys($formOptions))) {
                $postTypeOptions[$postType->post_type] = $postType->post_type;
            }
        }

        $form = new Builder('hydra-export', '/submit/hydra-export');

        $form->addField('checkboxes', array('post_types', __('Post Types', 'hydraforms')))
            ->setDescription(__('Select post-types to be exported', 'hydraforms'))
            ->setOptions($postTypeOptions);

        $form->addField('checkboxes', array('forms', __('Forms', 'hydraforms')))
            ->setDescription(__('Select forms to be exported', 'hydraforms'))
            ->setOptions($formOptions);

        $form->addField('submit', array('submit', __('Export', 'hydraforms')));
        $form->addOnSuccess('exportFormSubmit', $this);

        $form->setRedirect(FALSE);
        $form->build();

        print "<div class=hydra-page>";
        print $form->render();
        print "</div>";
    }


    public function exportFormSubmit($form, $values) {
        // export now ?
        $fieldDB = new HydraFieldModel();
        $handlerDb = new HydraFormHandlerModel();
        $formDb = new HydraFormModel();
        $viewDB = new HydraFieldViewModel();
        $db = new HydraViewModel();

        $lines = array();

        // new XML document
        $xmlDoc = new \DOMDocument();
        $xmlData = $xmlDoc->createElement('data');
        $xmlDoc->appendChild($xmlData);

        $xmlPostTypes = $xmlDoc->createElement('postTypes');
        $xmlData->appendChild($xmlPostTypes);

        // **************************
        // exporting post type forms
        // **************************
        if (isset($values['post_types'])) {


            foreach ($values['post_types'] as $postType) {
                // set post type
                $xmlPostType = $xmlDoc->createElement('postType');
                $xmlPostType->setAttribute('name', $postType);

                $xmlPostTypes->appendChild($xmlPostType);

                // set hydra view types
                $hydraViews = $db->loadByPostType($postType);
                if (count($hydraViews)) {
                    $xmlViews = $this->exportViews($hydraViews, $postType, $xmlDoc);
                    $xmlPostType->appendChild($xmlViews);
                }

                // set hydra fields
                $recordsContainer = $fieldDB->loadByPostType($postType);
                $fields = $recordsContainer->getRecords();

                $xmlFields = $this->exportFields($fields, $xmlDoc);
                $xmlPostType->appendChild($xmlFields);

                // groups are special, they do not have field to be attached to
                $xmlGroups = $xmlDoc->createElement('groups');
                $groups = $viewDB->loadGroupsByPostType($postType);
                foreach ($groups as $group) {
                    $xmlGroup = $this->exportFieldViews($group, $xmlDoc);
                    $xmlGroups->appendChild($xmlGroup);
                }
                $xmlPostType->appendChild($xmlGroups);

                $xmlTaxonomies = $xmlDoc->createElement('taxonomies');
                $this->exportTaxonomies($postType, $xmlTaxonomies, $xmlDoc);
                $xmlData->appendChild($xmlTaxonomies);
            }
        }


        $xmlForms = $xmlDoc->createElement('forms');
        $xmlData->appendChild($xmlForms);
        // **************************
        // exporting front-end forms
        // **************************
        if (isset($values['forms'])) {
            foreach ($values['forms'] as $formName) {
                // set form
                // @attributes
                $xmlForm = $xmlDoc->createElement('form');
                $xmlForms->appendChild($xmlForm);

                $form = $formDb->loadByName($formName);

                $values = array(
                    'id' => $form->id,
                    'name' => $form->name,
                    'label' => $form->label,
                    'type' => $form->type,
                );

                // set field
                foreach ($values as $key => $value) {
                    $xmlForm->setAttribute($key, $value);
                }

                $xmlFormTranslations = $this->exportTranslations($form->translations, $xmlDoc);
                $xmlForm->appendChild($xmlFormTranslations);
                // set field attributes
                $xmlFormSettings = $xmlDoc->createElement("settings");
                foreach ($form->settings as $key => $attribute) {
                    if (is_string($attribute)) {
                        $xmlFormSettings->setAttribute($key, $attribute);
                    }
                }
                $xmlForm->appendChild($xmlFormSettings);


                // set hydra fields
                $recordsContainer = $fieldDB->loadByPostType($formName);
                $fields = $recordsContainer->getRecords();
                $xmlFields = $this->exportFields($fields, $xmlDoc);
                $xmlForm->appendChild($xmlFields);

                // set hydra form handlers
                $handlers = $handlerDb->loadByFormName($formName);
                $xmlHandlers = $this->exportHandlers($handlers, $formName, $xmlDoc);
                $xmlForm->appendChild($xmlHandlers);

                if ($form->type == 'filter') {
                    $filterDb = new HydraFieldFilterModel();
                    $filters = $filterDb->loadByPostType($formName);
                    if ($filters) {
                        $xmlFilter = $this->exportFilters($filters, $xmlDoc);
                        $xmlForm->appendChild($xmlFilter);
                    }

                }
            }
        }

        $this->downloadHeaders();
        echo $xmlDoc->saveXML();
    }

    private function exportHandlers($hydraHandlers, $postType, $xmlDoc) {
        $xmlHandlers = $xmlDoc->createElement('handlers');
        foreach ($hydraHandlers as $hydraHandler) {
            $xmlHandler = $this->exportHandler($hydraHandler, $xmlDoc);
            $xmlHandlers->appendChild($xmlHandler);
        }

        return $xmlHandlers;
    }

    private function exportHandler(HydraFormHandlerRecord $hydraHandler, $xmlDoc) {
        $xmlHandler = $xmlDoc->createElement('handler');

        $values = array(
            'label' => $hydraHandler->label,
            'type' => $hydraHandler->type,
            'weight' => $hydraHandler->weight,
            'name' => $hydraHandler->name,
            'form_id' => $hydraHandler->form_id,
        );

        // set field
        foreach ($values as $key => $value) {
            $xmlHandler->setAttribute($key, $value);
        }

        // set field attributes
        $xmlHandlerSettings = $xmlDoc->createElement("settings");
        foreach ($hydraHandler->settings as $key => $attribute) {
            $xmlHandlerSettings->setAttribute($key, $attribute);
        }
        $xmlHandler->appendChild($xmlHandlerSettings);

        // handler translations export
        $xmlHandlerTranslations = $this->exportTranslations($hydraHandler->translations, $xmlDoc);
        $xmlHandler->appendChild($xmlHandlerTranslations);

        // @todo attributes;
        return $xmlHandler;
    }

    private function exportViews($hydraViews, $postType, $xmlDoc) {
        $xmlViews = $xmlDoc->createElement("views");

        foreach ($hydraViews as $hydraView) {
            $xmlView = $xmlDoc->createElement('view');

            $values = array(
                'post_type' => $postType,
                'name' => $hydraView->name,
                'label' => $hydraView->label,
            );

            foreach ($values as $key => $attribute) {
                $xmlView->setAttribute($key, $attribute);
            }

            // add child
            $xmlViews->appendChild($xmlView);
        }

        return $xmlViews;
    }

    private function exportFields($fields, $xmlDoc) {
        $xmlFields = $xmlDoc->createElement("fields");

        // append fields with field views
        foreach ($fields as $field) {
            $xmlField = $this->exportField($field, $xmlDoc);
            $xmlFields->appendChild($xmlField);
        }

        return $xmlFields;
    }

    private function exportField($field, $xmlDoc) {
        $xmlField = $xmlDoc->createElement("field");

        $values = array(
            'id' => $field->id,
            'parent_id' => $field->parent_id,
            'field_name' => $field->field_name,
            'wrapper' => $field->wrapper,
            'post_type' => $field->post_type,
            'field_type' => $field->field_type,
            'field_name' => $field->field_name,
            'field_label' => $field->field_label,
            'widget' => $field->widget,
            'weight' => $field->weight,
            'cardinality' => $field->cardinality,
        );

        // set field
        foreach ($values as $key => $value) {
            $xmlField->setAttribute($key, $value);
        }

        // set field attributes
        $xmlFieldAttributes = $xmlDoc->createElement("attributes");
        foreach ($field->attributes as $key => $attribute) {
            if (is_string($attribute)) {
                $xmlFieldAttributes->setAttribute($key, $attribute);
            }
        }
        $xmlField->appendChild($xmlFieldAttributes);

        // set field widget settings
        $xmlFieldWidget = $xmlDoc->createElement("widget_settings");
        foreach ($field->widget_settings as $key => $attribute) {
            if(is_string($attribute)) {
                $xmlFieldWidget->setAttribute($key, $attribute);
            }
        }

        $xmlField->appendChild($xmlFieldWidget);

        // set field default values
        // @todo - hm, field values usually go to 3 level nesting...
        $xmlFieldDefaults = $xmlDoc->createElement("default_values");
        foreach ($field->default_values as $key => $translation) {
            $xmlFieldDefaults->setAttribute($key, $attribute);
        }
        $xmlField->appendChild($xmlFieldDefaults);

        // set translations
        $xmlFieldTranslations = $this->exportTranslations($field->translations, $xmlDoc);
        $xmlField->appendChild($xmlFieldTranslations);

        /** @var HydraFieldRecord $field */
        $xmlFieldViews = $xmlDoc->createElement('views');
        $xmlField->appendChild($xmlFieldViews);

        $field->loadViews();
        $fieldViews = $field->getViews();

        if (count($fieldViews)) {
            foreach ($fieldViews as $fieldView) {
                $xmlFieldView = $this->exportFieldViews($fieldView, $xmlDoc);
                $xmlFieldViews->appendChild($xmlFieldView);
            }
        }

        return $xmlField;
    }

    private function exportFilters($filters, $xmlDoc) {
        $xmlFilters = $xmlDoc->createElement("filters");
        foreach ($filters as $filter) {
            $xmlFilter = $this->exportFilter($filter, $xmlDoc);
            $xmlFilters->appendChild($xmlFilter);
        }

        return $xmlFilters;
    }

    private function exportFilter($filter, $xmlDoc) {
        $xmlFilter = $xmlDoc->createElement("filter");

        $values = array(
            'id' => $filter->id,
            'field_id' => $filter->field_id,
            'referrer_id' => $filter->referrer_id,
            'col' => $filter->col,
            'condition' => $filter->condition,
        );

        // set field
        foreach ($values as $key => $value) {
            $xmlFilter->setAttribute($key, $value);
        }

        return $xmlFilter;
    }

    private function exportTranslations($translations, $xmlDoc) {
        // root translation object
        $xmlFieldTranslations = $xmlDoc->createElement("translations");

        // provide array of listed items fieldname => translations
        $translationArray = $this->buildTranslationExportArray($translations);

        foreach ($translationArray as $name => $translation) {
            $xmlFieldTranslation = $xmlDoc->createElement("translation");
            $xmlFieldTranslation->setAttribute('name', $name);
            $hasChild = FALSE;
            foreach ($translation as $langcode => $value) {
                if (!empty($value)) {
                    $xmlFieldLanguage = $xmlDoc->createElement('language', $value);
                    $xmlFieldLanguage->setAttribute('langcode', $langcode);
                    $xmlFieldTranslation->appendChild($xmlFieldLanguage);
                    $hasChild = TRUE;
                }
            }

            if ($hasChild) {
                $xmlFieldTranslations->appendChild($xmlFieldTranslation);
            }
        }

        return $xmlFieldTranslations;
    }

    private function buildTranslationExportArray($translations) {
        $translationArray = array();

        if(!count($translations)) {
            return $translationArray;
        }

        foreach ($translations as $name => $translation) {
            list($name, $value) = $this->composeTranslationName($translation, $name);
            $translationArray[$name] = $value;
        }

        return $translationArray;
    }

    private function composeTranslationName($translation, $name) {
        if (empty($translation)) {
            return array($name, $translation);
        }

        $langcodeKeys = array_keys($translation);
        $key = array_shift($langcodeKeys);

        if (is_array($translation[$key])) {
            list($composedName, $value) = $this->composeTranslationName($translation[$key], $key);
            $name .= '[' . $composedName . ']';

            return array($name, $value);
        }
        else {
            return array($name, $translation);
        }
    }

    private function exportFieldViews($fieldView, $xmlDoc) {
        $xmlView = $xmlDoc->createElement('view');

        /** @var HydraFieldViewRecord $fieldView */
        $values = array(
            'id' => $fieldView->id,
            'formatter' => $fieldView->formatter,
            'field_name' => $fieldView->field_name,
            'field_label' => $fieldView->field_label,
            'parent_id' => $fieldView->parent_id,
            'hidden' => $fieldView->hidden,
            'wrapper' => $fieldView->wrapper,
            'view' => $fieldView->view,
            'weight' => $fieldView->weight,
        );

        foreach ($values as $key => $value) {
            if ($value) {
                $xmlView->setAttribute($key, $value);
            }
        }
        // set field attributes
        $xmlViewsAttributes = $xmlDoc->createElement("settings");
        foreach ($fieldView->settings as $key => $attribute) {
            $xmlViewsAttributes->setAttribute($key, $attribute);
        }

        $xmlView->appendChild($xmlViewsAttributes);

        return $xmlView;
    }

    private function exportTaxonomies($postType, $xmlTaxonomies, $xmlDoc) {
        $fieldModel = new HydraFieldModel();
        $container = $fieldModel->loadByPostType($postType);
        $records = $container->getRecords();

        if (count($records)) {
            foreach ($records as $record) {
                if ($record->field_type == 'taxonomy') {
                    $xmlTaxonomy = $xmlDoc->createElement('taxonomy');

                    $vocabularyName = $record->attributes['taxonomy'];
                    $xmlTaxonomy->setAttribute('vocabulary', $vocabularyName);

                    $terms = get_terms($vocabularyName);

                    foreach ($terms as $term) {
                        $xmlTerm = $xmlDoc->createElement('term');
                        $xmlTerm->setAttribute('slug', $term->slug);
                        $xmlTerm->setAttribute('id', $term->term_id);
                        $xmlTaxonomy->appendChild($xmlTerm);
                    }

                    $xmlTaxonomies->appendChild($xmlTaxonomy);
                }
            }
        }
    }

    public function downloadHeaders() {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename=data_export.xml");
        header("Content-Transfer-Encoding: binary");
    }
}
