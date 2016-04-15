<?php

namespace Hydra\Fields;

use Hydra\Builder;
use Hydra\Decorators\Decorator;
use Hydra\Decorators\FieldDecorator;
use Hydra\Message;
use Hydra\Fields\Validators\Validator;
use Hydra\Fields\Validators\ValidatorMinlength;
use Hydra\Fields\Validators\ValidatorRequired;
use Hydra\Fields\Validators\ValidatorMail;

require_once 'validators/ValidatorInterface.php';
require_once 'validators/Validator.php';
require_once HYDRA_DIR . 'hydra/decorators/Decorator.php';
require_once HYDRA_DIR . 'hydra/decorators/FieldDecorator.php';

abstract class Field implements FieldInterface {

    protected $type;
    protected $name;
    protected $input;
    protected $attributes;
    protected $wrapperClass;
    protected $value;
    protected $defaultValue;
    protected $builder;
    protected $label;
    protected $labelDisabled = FALSE;
    protected $isRequired = FALSE;
    protected $isTranslatable = FALSE;
    protected $translationValue;

    private $validators;
    private $decorators;
    private $weight;
    private $description;
    private $output;
    private $ajaxCallback;
    private $ajax;

    /**
     * Attribute marking if we are rendering input group to render proper structure for prefix or suffix
     */
    private $isInputGroup = FALSE;

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function addAjaxAction($wrapper, $action = 'click') {
        $this->ajax = TRUE;

        $this->addAttribute('class', 'ajax-action');
        $this->addAttribute('data-type', 'post');
        $this->addAttribute('data-action', $action);
        $this->addAttribute('data-wrapper', $wrapper);
        $this->addAttribute('data-form', $this->getBuilder()->getId());
        $this->addAttribute('data-submit', $this->getBuilder()->getSubmitPath());

        return $this;
    }

    public function addAjaxCallback($callback, $object = NULL) {
        $this->ajaxCallback[] = array(
            'callback' => $callback,
            'object' => $object,
        );

        return $this;
    }

    public function processAjaxCallback() {
        foreach ($this->ajaxCallback as $callable) {
            if ($callable['object'] == NULL) {
                call_user_func($callable['callback'], $this->getBuilder(), $this->getBuilder()->getValues());
            }
            else {
                call_user_func(array(
                    $callable['object'],
                    $callable['callback']
                ), $this->getBuilder(), $this->getBuilder()->getValues());
            }
        }
    }

    public function setTranslationValue($value) {
        $this->translationValue = $value;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getDescription() {
        return $this->description;
    }

    public function disableLabel() {
        $this->labelDisabled = TRUE;
        return $this;
    }

    public function enableLabel() {
        $this->labelDisabled = FALSE;
        return $this;
    }

    public function enableTranslatable() {
        $this->isTranslatable = TRUE;
        return $this;
    }

    public function disableTranslatable() {
        $this->isTranslatable = FALSE;
        return $this;
    }

    public function isTranslatable() {
        return $this->isTranslatable;
    }

    public function setInput($input) {
        $this->input = $input;

        return $this;
    }

    protected function getInput() {
        $this->input;

        return $this;
    }

    /**
     * Sorting based on weight
     * @param $weight
     */
    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Get sorting weights
     * @return mixed
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * @param Builder $builder
     */
    public function setBuilder(Builder $builder) {
        $this->builder = $builder;
    }

    public function getBuilder() {
        return $this->builder;
    }

    public function removeAllDecorators() {
        $this->decorators = array();
        return $this;
    }

    public function removeDecorator($type) {
        if (isset($this->decorators[$type])) {
            unset($this->decorators[$type]);
        }
        return $this;
    }


    public function addDecorator($type, $args = array()) {

        // dumm exception on some basic  types
        if (in_array($type, array('prefix', 'suffix', 'wrapper'))) {
            $this->decorators[] = new FieldDecorator($type, $args);
            return $this;
        };


        $decoratorClass = '\\Hydra\\Decorators\\' . ucfirst($type) . 'Decorator';

        try {
            $path = dirname(dirname(__FILE__)) . '/decorators/' . ucfirst($type) . 'Decorator.php';
            require_once($path);

            $reflection = new \ReflectionClass($decoratorClass);
            $decorator = $reflection->newInstanceArgs(array());

            $this->decorators[$type] = $decorator;
        } catch (Exception $e) {
            // echo $e->getMessage();
            // @todo tudu tu tu tu
        }

        return $this;
    }

    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getDefaultValue() {
        return $this->defaultValue;
    }

    protected function getDecorators() {
        return $this->decorators;
    }

    public function addValidator($type, $message = NULL, $value = array()) {
        $validatorClass = '\\Hydra\\Fields\\Validators\\Validator' . ucfirst($type);

        if ($type == 'required') {
            $this->isRequired = TRUE;
        }

        try {
            require_once 'validators/' . 'Validator' . ucfirst($type) . '.php';

            $reflection = new \ReflectionClass($validatorClass);
            $validator = $reflection->newInstanceArgs(array($this, $message, $value));
            $this->validators[] = $validator;
        } catch (Exception $e) {
            //      echo $e->getMessage();
            // @todo tudu tu tu tu
        }

        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setParent($name) {
        $this->name = $name . "[" . $this->name . "]";

    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function setValue($value) {
        // @todo - just temporary
        if(is_string($value)) {
          $this->value = stripslashes($value);
        } else {
          $this->value = $value;
        }
        return $this;
    }

    /**
     * Get value - if not found in session - returns back to default value
     * @todo - Fallback to input form should be registered also - in case of invalidating form
     * @return string
     */
    public function getValue() {
        if(is_string($this->value) && (int)$this->value === 0 && strlen($this->value) == 1) {
            return $this->value;
        }

        return !empty($this->value) ? $this->value : (!empty($this->defaultValue) ? $this->defaultValue : "");
    }


    /**
     * Overwrite whole attributes array
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes) {
        $this->attributes = $attributes;

        return $this;
    }

    public function setAttribute($attribute, $value) {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    public function unsetAttribute($key) {
        unset($this->attributes[$key]);
    }

    /**
     *
     */
    public function getAttribute($key) {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return FALSE;
    }

    /**
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function addAttribute($attribute, $value) {
        if (isset($this->attributes[$attribute]) && !is_string($this->attributes[$attribute])) {
            $this->attributes[$attribute][] = $value;
        }
        elseif (isset($this->attributes[$attribute]) && is_string($this->attributes[$attribute])) {
            $this->attributes[$attribute] = $value;
        }
        else {
            $this->attributes[$attribute][] = $value;
        }

        return $this;
    }

    /**
     * Implode all attributes in single string usable in HTML
     * @return string
     */
    protected function printAttributes() {
        $output = '';

        if (!count($this->attributes)) {
            return $output;
        }

        foreach ($this->attributes as $attribute => $values) {
            if (is_string($values)) {
                $value = $values;
            }
            else {
                if (is_array($values)) {
                    $value = implode(" ", $values);
                }
            }
            $output .= " $attribute=\"$value\"";
        }

        return trim($output);
    }

    public function setWrapperClass($class) {
        $this->wrapperClass = $class;
        return $this;
    }

    /**
     * @param $name
     * @param $type
     * @param string $label
     * @param null $value
     */
    protected function __construct($name, $type, $label = '', $value = NULL) {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Validate the form based on attached Validators
     * Each validators is collecting messages
     * @todo - should this collect name of error fields ? Instead of determining errors from session data ?
     * @return array
     *  Array of messages - if empty - validation for this field has passed
     */
    public function validate() {
        $results = array();
        if (!count($this->validators)) {
            return array();
        }

        $error = FALSE;

        foreach ($this->validators as $validator) {
            if ($text = $validator->validate()) {
                $results[] = new Message($text, 'danger', $this->getName());
                $error = TRUE;
            }
        }

        if ($error) {
            $this->hasError();
        }

        return $results;
    }

    /**
     * @TODO - stump method - but will server as overwrite of html of input
     * @TODO - using only replace tokens !label and !input
     * @param $html
     * @return mixed
     */
    public function renderCustom($html) {

    }

    /**
     * @return mixed|string
     */
    public function render() {
        // manual output
        if ($this->output) {
            return $this->output;
        }

        $field = $this->renderField();
        $classes = '';
        if (isset($this->wrapperClass)) {
            $classes = $this->wrapperClass;
        }

        $output = "<div class=\"field-item form-group field-type-" . $this->type . " " . $classes . " field-type-" . str_replace('_', '-', $this->name) . " \">";
        $output .= $field;
        $output .= "</div>";

        return $output;
    }

    /**
     * Adds css classes to inputs with errors
     */
    public function hasError() {
        $this->addAttribute('class', 'error-form');
    }


    /**
     * Rendering of field
     * Consist of rendering label + input
     * @todo - set decorators for inline
     * @return string
     */
    public function renderField() {
        $output = '';

        // Check if we are rendering input group
        if (is_array($this->decorators)) {
            foreach ($this->decorators as $decorator) {
                if ($decorator->type == 'suffix' || $decorator->type == 'prefix') {
                    $this->isInputGroup = TRUE;
                }
            }
        }

        if (!$this->getAttribute('id')) {
            $id = 'hydra-' . str_replace(array('[', ']', '_'), array('-', '', '-'), $this->name);
            $this->setAttribute('id', $id);
        }

        $output = $this->renderLabel();

        if ($this->isInputGroup) {
            return $output . '<div class="input-group">' . $this->renderInput() . $this->renderDescription() . '</div>';
        }
        else {
            $input = $this->renderInput();
        }


        return $output . $input . $this->renderDescription();
    }

    protected function getAsterisk() {
        $asterisk = '';

        if ($this->isRequired) {
            $asterisk = ' <span class="required">*</span>';
        }

        return $asterisk;
    }

    /**
     * Render only field label
     * @return string
     */
    public function renderLabel() {
        if (!$this->labelDisabled) {
            return "<label for=" . $this->getAttribute('id') . ">" . $this->label . $this->getAsterisk() . "</label>";
        }
        else {
            return '';
        }
    }

    public function renderLanguageInputs($locales) {
        global $sitepress;
        $inputs = "<ul class=language-inputs>";

        foreach ($locales as $key => $locale) {

            $flag = "<img src=" . $locale["country_flag_url"] . ">";

            $inputs .= "<li>";
            $defaultLanguage = $sitepress->get_default_language();

            if ($defaultLanguage == $key) {
                $inputs .= $this->renderInputElement() . $flag;
            }
            else {
                if (strstr($this->name, '[')) {
                    $parsedName = str_replace('[', '][', $this->name);
                    $name = "translations[$parsedName" . "[$key]";
                }
                else {
                    $name = "translations[$this->name][$key]";
                }

                $inputs .= $this->renderInputElement($name, $this->translationValue[$key]) . $flag;
            }
            $inputs .= "</li>";
        }
        $inputs .= "</ul>";


        return $inputs;
    }


    /**
     * @param null $name
     * @param null $value
     * @return mixed|string
     */
    public function renderInput($name = NULL, $value = NULL) {

        if ($this->isTranslatable()) {
            $locales = _hydra_get_enabled_locales();
            if ($locales) {
                $input = $this->renderLanguageInputs($locales);
                return $input;
            }
        }

        $input = $this->renderInputElement($name, $value);
        return $input;
    }

    public function renderInputElement($name = NULL, $value = NULL) {
        if (!$name) {
            $name = $this->name;
        }

        if (!$value) {
            $value = $this->getValue();
        }

        if(is_string($value)) {
          $value = htmlspecialchars($value);
        }
        $output = "<input " . $this->printAttributes() . " type=\"$this->type\" value=\"" . $value . "\" name=\"$name\">";

        if ($this->getDecorators()) {
            foreach ($this->decorators as $decorator) {
                $output = str_replace('!field', $output, $decorator->render());
            }
        }

        return $output;
    }

    /**
     * Render only description if available
     */
    public function renderDescription() {

        if ($this->description) {
            return '<div class="description">' . $this->description . '</div>';
        }

        return '';
    }

    public function customRender($preserveFields) {
        return $this->render();
    }
}