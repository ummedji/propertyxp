<?php

namespace Hydra;

use Hydra\Decorators\TableDecorator;
use Hydra\Message;
use Hydra\Token;
use Hydra\Fields\Field;
use Hydra\Fields\HiddenField;

require_once 'MessageManager.php';
require_once 'fields/FieldInterface.php';
require_once 'fields/Field.php';
require_once 'fields/HiddenField.php';
require_once 'Token.php';


class Builder {

    // Types of builders
    const FORM_SELFSTANDING = 1;
    const FORM_EXTENDER = 2;

    private $fields;
    private $submit;
    private $messagesManager;

    private $onSuccess = array();
    private $onValidation = array();
    private $token;
    private $name;
    private $attributes;
    private $submittedFieldName;
    private $decorator;
    private $redirect;
    private $buildId;

    private $error = array();
    private $currentWeight = 0;

    public $values;
    public $submitFields;


    /**
     * @param $name
     * @param string $submit
     * @param int $formBuild
     */
    public function __construct($name, $submit = '', $formBuild = Builder::FORM_SELFSTANDING) {
        if (!$submit) {
            $submit = '/submit/' . $name;
        }

        $this->submit = home_url() . $submit;
        $this->name = $name;
        $this->setAttribute('id', $name);

        $this->formBuild = $formBuild;
        $this->buildFormMeta();

        // go back to form url after done with success
        $this->setRedirect('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);

        $this->messagesManager = new MessageManager($this->name);
    }

    public function getId() {
        if (isset($this->attributes['id'])) {
            $id = $this->attributes['id'];

            return $id;
        }
    }

    public function setSubmit($submit) {
        $this->submit = $submit;
    }

    /**
     * Add attributes to the form
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function addAttribute($attribute, $value) {
        $this->attributes[$attribute][] = $value;

        return $this;
    }

    /**
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setAttribute($attribute, $value) {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Implode the array of attributes into html-usable string
     * @return string
     */
    private function printAttributes() {
        $output = '';

        if (!count($this->attributes)) {
            return $output;
        }

        foreach ($this->attributes as $attribute => $values) {
            if (is_string($values)) {
                $value = $values;
            }
            else {
                $value = implode(" ", $values);
            }
            $output .= "$attribute=\"$value\"";
        }

        return trim($output);
    }

    public function isRenderable() {
        return TRUE;
    }

    /**
     * @return mixed
     */
    public function getBuildId() {
        return $this->buildId;
    }

    public function build() {
        do_action('hydraforms_form_alter', $this, $this->getName());

        if (isset($_SESSION['hydra']['invalidate'][$this->name])) {
            $buildId = $this->name . '-' . $_SESSION['hydra']['invalidate'][$this->name];
            $build = Builder::getBuild($buildId);
            $this->unsetBuild($buildId);

            if ($build) {
                $this->setErrors($build->getErrors());
                $this->setValues($build->getValues());
                unset($_SESSION['hydra']['invalidate'][$this->name]);
                unset($build);
            }
        }

        $model = new \HydraFormCacheModel();
        $form_id = $this->getName() . '-' . $this->getBuildId();
        $model->save($form_id, $this);
    }

    public function getErrors() {
        return $this->error;
    }

    private function hasErrors() {
        if (is_array($this->error) && count($this->error)) {
            return TRUE;
        }
    }

    private function setErrors() {
        // error message == error
        $messages = $this->messagesManager->getErrors();
        if (is_array($messages) && count($messages)) {
            foreach ($messages as $message) {
                $this->error[$message->getFieldName()] = $message->getFieldName();
            }
        }
    }


    private function populateErrors() {
        if (!count($this->error)) {
            return;
        }

        foreach ($this->fields as $field) {
            // fieldset
            if (get_class($field) == 'Hydra\Fields\FieldsetField') {
                $field->populateErrors($this->error);
                continue;
            }

            if (isset($this->error[$field->getName()])) {
                $field->hasError();
            }
        }

        unset($this->error);
    }

    /**
     * @param $buildId
     * @return mixed
     */
    public static function getBuild($buildId) {
        $model = new \HydraFormCacheModel();
        $build = $model->load($buildId);
        if ($build) {
            return $build;
        }

        return NULL;
    }

    private function unsetBuild($buildId) {
        $model = new \HydraFormCacheModel();
        $model->delete($this->name . '-' . $buildId);
    }

    public function setRedirect($redirect) {
        $this->redirect = $redirect;
    }

    public function getName() {
        return $this->name;
    }

    public function addDecorator($type, $args = array()) {
        // dumm exception on some basic  types
        if (in_array($type, array('prefix', 'suffix', 'wrapper'))) {
            $this->decorator[] = new FieldDecorator($type, $args);

            return $this;
        };

        $decoratorClass = '\\Hydra\\Decorators\\' . ucfirst($type) . 'Decorator';

        try {
            $path = dirname(__FILE__) . '/decorators/' . ucfirst($type) . 'Decorator.php';
            require_once($path);

            $reflection = new \ReflectionClass($decoratorClass);
            $decorator = $reflection->newInstanceArgs(array());

            $this->decorator[] = $decorator;
        } catch (Exception $e) {
//      echo $e->getMessage();
            // @todo tudu tu tu tu
        }

        return $this;
    }

    /**
     * Add submit field name to array
     * Used for determining which field was actually triggered - if multiple submit buttons available
     * @param $fieldName
     *  Name of a field
     */
    public function addSubmitField($fieldName) {
        $this->submitFields[$fieldName] = $fieldName;
    }

    /**
     * @param $fieldName
     */
    public function removeSubmitField($fieldName) {
        if (isset($this->submitFields[$fieldName])) {
            unset($this->submitFields[$fieldName]);
        }
    }

    /**
     * @return array
     */
    public function getSubmitFields() {
        return $this->submitFields;
    }

    /**
     * @return string
     */
    public function getSubmitPath() {
        return $this->submit;
    }

    /**
     * Gets field - expected format is nesting[nested][nested]
     * @param $fieldName
     * @param null $fieldSet
     * @return null
     */
    public function getField($fieldName, $fieldSet = NULL) {
        $nestedName = explode('[', $fieldName);
        foreach ($nestedName as &$part) {
            $part = trim($part, ']');
        }

        $directDescendant = FALSE;
        if (count($nestedName) == 1) {
            $directDescendant = TRUE;
        }

        $descendant = array_shift($nestedName);

        foreach ($this->fields as $field) {
            if ($field->getType() == 'fieldset' && $field->getIsTree()) {
                if ($result = $field->getField($nestedName, $fieldName)) {
                    return $result;
                }
            }

            if ($field->getName() == $descendant) {
                if ($directDescendant) {
                    return $field;
                }
                else {
                    return $field->getField($nestedName, $fieldName);
                }
            }
        }

        return NULL;
    }

    /**
     * Get all fields
     * @return mixed
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * Remove single field according to name
     * @param $name
     */
    public function removeField($name) {
        foreach ($this->fields as $index => $field) {
            if ($field->getName() == $name) {
                unset($this->fields[$index]);
            }
        }
    }

    /**
     * Custom success callback for form
     * @param $callback
     * @param null $object
     * @param $position
     */
    public function addOnSuccess($callback, $object = NULL, $position = "bottom") {
        $successCallback = array(
            'callback' => $callback,
            'object' => $object,
        );

        if ($position == "bottom") {
            array_push($this->onSuccess, $successCallback);
        }
        else {
            array_unshift($this->onSuccess, $successCallback);
        }
    }

    /**
     * Custom validation callback for form
     * @param $callback
     * @param null $object
     * @param $position
     */
    public function addOnValidation($callback, $object = NULL, $position = "bottom") {
        $validationCallback = array(
            'callback' => $callback,
            'object' => $object,
        );

        if ($position == "bottom") {
            array_push($this->onValidation, $validationCallback);
        }
        else {
            array_unshift($this->onValidation, $validationCallback);
        }
    }

    /**
     * Forward to submission callbacks
     * @throws Exception
     */
    public function forwardToSuccessHandlers() {
        $this->submitFieldSuccessHandlers();

        if (!is_array($this->onSuccess) || !count($this->onSuccess)) {
            return;
        }

        foreach ($this->onSuccess as $callable) {
            if (isset($callable['object'])) {
                call_user_func(array($callable['object'], $callable['callback']), $this, $this->getValues());
            }
            else {
                call_user_func($callable['callback'], $this, $this->getValues());
            }
        }
    }

    /**
     * Forward to submission callbacks specific for submitted button
     */
    private function submitFieldSuccessHandlers() {
        $submittedField = $this->getSubmittedField();
        // no submit found
        if (!$submittedField) {
            return;
        }
        $submitCallbacks = $submittedField->getOnSuccess();

        if (is_array($submitCallbacks) && count($submitCallbacks)) {
            foreach ($submitCallbacks as $callable) {
                if (isset($callable['object'])) {
                    call_user_func(array($callable['object'], $callable['callback']), $this, $this->getValues());
                }
                else {
                    call_user_func($callable['callback'], $this, $this->getValues());
                }
            }
        }
    }

    /**
     * Forward to custom validation callbacks
     * @return array
     * @throws Exception
     */
    public function forwardToValidationHandlers() {
        $messages = $this->submitFieldValidationHandlers();

        // nothing to do
        if (!is_array($this->onValidation) || !count($this->onValidation)) {
            return $messages;
        }

        foreach ($this->onValidation as $callable) {
            if (isset($callable['object'])) {
                $result = call_user_func(array($callable['object'], $callable['callback']), $this, $this->getValues());
            }
            else {
                $result = call_user_func($callable['callback'], $this, $this->getValues());
            }

            if (is_array($result)) {
                $messages = array_merge($messages, $result);
            }
        }

        return $messages;
    }

    /**
     * Forward to submission callbacks specific for submitted button
     */
    private function submitFieldValidationHandlers() {
        $messages = array();
        $submittedField = $this->getSubmittedField();
        // no submit found
        if (!$submittedField) {
            return $messages;
        }
        $validationCallbacks = $submittedField->getOnValidation();

        if (is_array($validationCallbacks) && count($validationCallbacks)) {
            foreach ($validationCallbacks as $callable) {
                if (isset($callable['object'])) {
                    $result = call_user_func(
                        array($callable['object'], $callable['callback']),
                        $this,
                        $this->getValues()
                    );
                }
                else {
                    $result = call_user_func($callable['callback'], $this, $this->getValues());
                }

                if (is_array($result)) {
                    $messages = array_merge($messages, $result);
                }
            }
        }

        return $messages;
    }


    /**
     * Building form meta information
     *  - Generation of token
     *  - Creating hidden fields
     *  - Population values from $_POST
     */
    private function buildFormMeta() {
        $this->token = new Token($this->name);

        $this->addField('hidden', array('token', $this->token->generateToken()))
            ->setAttribute('id', 'hydra-token-' . $this->getId());
        $this->addField('hidden', array('form_id', $this->getName()))
            ->setAttribute('id', 'form-id-' . $this->getId());

        // unique build id
        $this->buildId = md5(uniqid(rand(), TRUE));

        // @todo - move in method ?
        $this->submit .= '-' . $this->buildId;
    }


    public function isSubmitted() {
        return (bool) $this->values && isset($_POST['form_id']) && $_POST['form_id'] == $this->getName();
    }

    /**
     * Add existing form element to builder
     * @param Field $field
     * @return Field
     */
    public function addFieldObject(Field $field) {
        $field->setBuilder($this);
        $this->fields[] = $field;

        return $field;
    }

    /**
     * Creates and adds form element to builder
     * @param $name
     * @param $args
     * @return Field
     */
    public function addField($name, $args) {
        $field = Builder::createField($name, $args);
        $field->setBuilder($this);
        if ($name != 'hidden') {
            $field->setWeight($this->currentWeight);
            $this->currentWeight += 2;
        }

        $this->fields[] = $field;

        return $field;
    }


    /**
     * Create form object, but do not associate with the Form
     * This might prove useful when creating utility elements (progress-bars, multi-step controls ...)
     * @param $name
     * @param array $args
     * @return null|object
     */
    public static function createField($name, $args = array()) {
        $fieldClass = '\\Hydra\\Fields\\' . ucfirst($name) . 'Field';

        try {
            require_once 'fields/' . ucfirst($name) . 'Field.php';
            $reflection = new \ReflectionClass($fieldClass);
            $field = $reflection->newInstanceArgs($args);

            return $field;
        } catch (Exception $e) {
            // echo $e->getMessage();
            // @todo tudu tu tu tu
        }

        return NULL;
    }

    private function setSubmittedField($fieldName) {
        $this->submittedFieldName = $fieldName;
    }

    public function getSubmittedField() {
        return $this->getField($this->submittedFieldName);
    }

    /**
     * Sets submission meta, which submit button was sent
     */
    public function setSubmissionMeta() {
        $submitFields = $this->getSubmitFields();
        $values = $this->getValues();

        if (is_array($submitFields) && count($submitFields)) {
            foreach ($submitFields as $fieldName) {
                $parts = explode('[', $fieldName);
                foreach ($parts as &$part) {
                    $part = trim($part, ']');
                }

                if ($this->searchSubmitValue($values, array_shift($parts), $parts)) {
                    $this->setSubmittedField($fieldName);
                }

            }
        }
    }

    /**
     * Search for submitted field value
     * @param $values
     * @param $name
     * @param array $descendants
     * @return bool
     */
    private function searchSubmitValue($values, $name, $descendants = array()) {
        if (isset($values[$name])) {
            if (count($descendants)) {
                return $this->searchSubmitValue($values[$name], array_shift($descendants), $descendants);
            }
            else {
                return TRUE;
            }
        }

        return FALSE;
    }


    /**
     * Validates form token
     * @return bool
     */
    private function validateToken() {

        if (!isset($values['token']) || !$this->token->checkToken($this->getName(), $values['token'])) {
            return FALSE;
        };

        return TRUE;
    }

    /**
     * @return mixed
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * Set single value
     * @param $key
     * @param $value
     */
    public function setValue($key, $value) {
        $this->values[$key] = $value;
    }

    /**
     * Get single field value
     * @param $key
     * @return bool
     */
    public function getValue($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return FALSE;
    }

    /**
     * Setting inputs back to forms - in case of invalidation or... retrieving the values for ajax purposes
     *
     * Scenario:
     * Input overwrites default value - if form was submitted, but without success ( validation errors )
     * Input becomes new default value if set
     */
    public function setValues($values = NULL) {

        if ($values) {
            $this->values = $values;
        }

        if ((isset($_POST['form_id']) && $_POST['form_id'] == $this->getName())) {
            $this->values = $_POST;
            $this->populateFromValues($this->values);
        }
        else {
            if ($this->values) {
                $this->populateFromValues($this->values);
            }
        }
    }

    /**
     * Populate fields with appropriate values
     * @param $values
     */
    private function populateFromValues($values) {

        foreach ($this->fields as $field) {

            // fieldset
            if (get_class($field) == 'Hydra\Fields\FieldsetField' && !$field->getIsTree()) {
                // @todo add aditional check - however if value is not set its probably fieldset without tree structure
                $field->setValue($values);
                continue;
            }

            if (isset($values[$field->getName()])) {
                $passValues = $values[$field->getName()];


                if (isset($values['translations'][$field->getName()])) {
                    $field->setTranslationValue($values['translations'][$field->getName()]);

                    if (is_array($passValues)) {
                        $passValues['translations'] = $values['translations'][$field->getName()];
                    }
                }


                $field->setValue($passValues);
            }
        }
    }

    /**
     * @return array|Message
     */
    public function validate() {
        $this->messagesManager->clearMessages();

        $this->setValues();
        if (!$this->isSubmitted()) {
            return;
        }

        $this->setSubmissionMeta();
        $this->messages = array();
        if ($this->formBuild == Builder::FORM_SELFSTANDING && $this->validateToken()) {
            $this->messagesManager(
                new Message(__('Token has expired. You need to reload the form.', 'hydraforms'), 'danger')
            );
        }

        // basic field validation
        foreach ($this->fields as $field) {
            $errorsMessages = $field->validate();
            if (count($errorsMessages)) {
                $this->messagesManager->addMessages($errorsMessages);
            }
        }


        // custom validation callbacks
        $errorMessages = $this->forwardToValidationHandlers();
        // Push all messages to message manager
        if (count($errorMessages)) {
            foreach ($errorMessages as $errorMessage) {
                $this->messagesManager->addMessage(new Message($errorMessage[0], 'danger', $errorMessage[1]));
            }
        }


        $this->setErrors();
        // success
        if (!$this->hasErrors()) {
            // Glorious success !
            // 1. Clear session
            // 2. Remove form token
            // 3. Check form redirect
            $this->unsetBuild($this->getBuildId());
            $this->forwardToSuccessHandlers();

            if ($this->formBuild == Builder::FORM_SELFSTANDING) {
                $this->token->removeToken($this->getName());
            }

            if ($this->redirect) {
                header('Location:' . $this->redirect);
            }

            $this->messagesManager->store();

            return TRUE;
        }

        // failure
        $this->messagesManager->store();
        $this->build();

        $this->invalidatedForm();

        header('Location:' . $_SERVER['HTTP_REFERER']);

        return FALSE;
    }

    private function invalidatedForm() {
        $_SESSION['hydra']['invalidate'][$this->name] = $this->getBuildId();
    }

    private function sortFields($fields) {
        usort($fields, array($this, 'sort'));

        return $fields;
    }

    private function sort($itemA, $itemB) {
        if ($itemA->getWeight() > $itemB->getWeight()) {
            return TRUE;
        }

        return FALSE;
    }

    public function renderMessages() {
        print $this->messagesManager->renderMessages();
    }

    /**
     * Render form
     */
    public function render() {
        $this->populateErrors();
        // render messages - if not rendered before - on form validation for example
        print $this->messagesManager->renderMessages();

        if ($this->formBuild == Builder::FORM_SELFSTANDING) {
            print '<form action="' . $this->submit . '" method="post" name="' . $this->getName(
                ) . '" ' . $this->printAttributes() . '>';
        }

        $fields = $this->sortFields($this->fields);
        if ($this->decorator) {
            foreach ($this->decorator as $decorator) {
                print $decorator->render($fields);
            }
        }
        else {
            foreach ($fields as $field) {
                print $field->render();
            }
        }

        if ($this->formBuild == Builder::FORM_SELFSTANDING) {
            print "</form>";
        }
    }

    public function customRender($preserveFields = FALSE) {
        $output = array();
        // @todo - refactor
        if ($this->formBuild == Builder::FORM_SELFSTANDING) {
            $output['form_start'] = '<form action="' . $this->submit . '" method="post" name="' . $this->getName(
                ) . '" ' . $this->printAttributes() . '>';
        }

        // ! can't use decorators during custom rendering
        foreach ($this->fields as $field) {
            $output['form_fields'][$field->getName()] = $field->customRender($preserveFields);
        }

        if ($this->formBuild == Builder::FORM_SELFSTANDING) {
            $output['form_closure'] = "</form>";
        }

        return $output;
    }

    public function clearSubmitValues($values) {
        unset($values['token']);
        unset($values['form_id']);

        return $values;
    }

    /**
     * Utility function - to add success message more comfortable
     * @param $text
     */
    public function addSuccessMessage($text) {
        $this->messagesManager->addMessage(new Message($text, 'success'));
    }

    /**
     * Utility function - to add validation message more comfortable
     * @param $text
     */
    public function addValidationMessage($text) {
        $this->messagesManager->addMessage(new Message($text, 'danger'));
    }

    /**
     * Utility function - to add validation message more comfortable
     * @param $text
     * @param $type
     */
    public function addMessage($text, $type = "success") {
        $this->messagesManager->addMessage(new Message($text, $type));
    }
}