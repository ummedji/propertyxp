<?php

namespace Hydra\Fields;

use Hydra\Builder;

class FieldsetField extends Field {

    private $fields;
    private $tree = TRUE;
    private $renderable = TRUE;
    public $nestedNamesSet = 0;

    public function isTree($bool = FALSE) {
        $this->tree = $bool;

        return $this;
    }

    public function getIsTree() {
        return $this->tree;
    }

    public function isRenderable($bool = TRUE) {
        $this->renderable = $bool;

        return $this;
    }

    public function getIsRenderable() {
        return $this->renderable;
    }

    /**
     * @param $name
     * @param string $label
     */
    public function __construct($name, $label = '') {
        parent::__construct($name, 'fieldset', $label);
        $this->tree = TRUE;
        $this->addAttribute('class', 'hydra-fieldset form-fieldset');
    }

    public function removeFields() {
        unset($this->fields);
    }


    public function removeField($name) {
        if(!count($this->fields)) {
            return;
        }
        foreach($this->fields as $index => $field) {
            if($field->getName() == $name) {
                unset($this->fields[$index]);
            }
        }
    }

    public function removeAttribute($name, $value) {
        if (isset($this->attributes[$name])) {
            foreach ($this->attributes[$name] as $key => $attr) {
                if ($value == $key) {
                    unset($this->attributes[$name][$key]);
                }
            }
        }
    }

    /**
     * Input should be setup by recursion
     * @param $formValues
     */
    public function setValue($formValues) {
        if (!count($this->fields)) {
            return;
        }


        foreach ($this->fields as $field) {
            if ($field->isTranslatable()) {
                if (isset($formValues['translations'][$field->getName()])) {
                    $field->setTranslationValue($formValues['translations'][$field->getName()]);
                }

                if (isset($formValues['translations'][$this->getName()][$field->getName()])) {
                    $field->setTranslationValue($formValues['translations'][$this->getName()][$field->getName()]);
                }
            }
            if (isset($formValues[$field->getName()])) {
                $field->setValue($formValues[$field->getName()]);
            }
        }
    }

    /**
     * @param $errors
     */
    public function populateErrors($errors) {
        if (!count($this->fields) || !count($errors)) {
            return;
        }

        $this->setNestedNames();
        foreach ($this->fields as $field) {

            // fieldset
            if (get_class($field) == 'Hydra\Fields\FieldsetField' && $this->isTree()) {
                $field->populateErrors($errors);
                continue;
            }

            if (isset($errors[$field->getName()])) {
                $field->hasError();
            }
        }
    }


    public function getFields() {
        return $this->fields;
    }

    /**
     * @param $fieldName
     * @param null $fieldSet
     * @return null
     */
    public function getField($nestedName, $fieldName) {

        $directDescendant = FALSE;

        if (count($nestedName) == 1) {
            $directDescendant = TRUE;
        }

        $descendant = array_shift($nestedName);
        if(!count($this->fields)) {
            return NULL;
        }

        foreach ($this->fields as $field) {
            // last descendant
            if ($directDescendant) {
                if ($field->getName() == $descendant || $field->getName() == $fieldName) {
                    return $field;
                }
            }
            else {
                if ($field->getName() == $descendant) {
                    return $field->getField($nestedName, $fieldName);
                }
            }

            // what if there are nested names already
            if(isset($field->nestedNamesSet) && $field->nestedNamesSet == 1) {
                if($field->getName() == $this->getNestedName($descendant)) {
                    return $field->getField($nestedName, $fieldName);
                }
            }
        }

        return NULL;
    }


    private function getNestedName($name) {
        return $this->getName() . '[' . $name . ']';
    }

    /**
     * Set nested names for fields
     */
    private function setNestedNames() {

        if (!count($this->fields) || !$this->getIsTree()) {
            return;
        }

        if ($this->nestedNamesSet) {
            return;
        }
        else {
            $this->nestedNamesSet = 1;
        }

        foreach ($this->fields as $field) {
            $field->setName($this->getName() . '[' . $field->getName() . ']');
        }
    }

    public function setBuilder(
        Builder $builder
    ) {
        $this->builder = $builder;
        if (!count($this->fields)) {
            return;
        }

        foreach ($this->fields as $field) {
            $field->setBuilder($this->builder);
        }

    }

    /**
     * @param $type
     * @param array $args
     * @return Field
     */
    public function addField($type,$args = array()) {

        $field = $this->getBuilder()->createField($type, $args);
        $this->fields[] = $field;
        $field->setBuilder($this->getBuilder());

        return $field;
    }

    /**
     * @param Field $field
     * @return Field
     */
    public function addFieldObject(Field $field) {
        $this->fields[] = $field;
        if ($this->getBuilder()) {
            $field->setBuilder($this->getBuilder());
        }

        return $field;
    }


    public function validate() {
        if (!count($this->fields)) {
            return array();
        }

        // we need to set nested names before proceeding with validation
        // now we can nicely compare error messages against actual fields
        $this->setNestedNames();

        $messages = array();
        foreach ($this->fields as $field) {
            $messages = array_merge($messages, $field->validate());
        }

        return $messages;
    }

    /**
     * Very specific field
     * @return string|void
     */
    public function renderField() {
        return $this->render();
    }

    public function renderInput($name = NULL, $value = NULL) {
        return $this->render();
    }

    public function render() {
        $output = '';
        if ($this->getIsRenderable()) {
            $output = "<fieldset  " . $this->printAttributes() . " type=\"$this->type\" value=\"" . $this->getValue() . "\" name=\"$this->name\">";
            $output .= $this->renderLabel();
        }
        else {
            $this->removeAttribute('class', 'hydra-fieldset form-fieldset');
            $output = "<div " . $this->printAttributes() . ">";
        }

        $this->setNestedNames();

        // @todo ajax actions are breaking with decorators
        if ($this->getDecorators()) {
            foreach ($this->getDecorators() as $decorator) {
                $output .= $decorator->render($this->fields);
            }
        } else {
            if(count($this->fields)) {
                foreach ($this->fields as $field) {
                    $output .= $field->render();
                }
            }
        }

        if ($this->getIsRenderable()) {
            $output .= '</fieldset>';
        }
        else {
            $output .= "</div>";
        }

        return $output;
    }

    public function renderLabel() {
        $output = '<h3><legend>' . $this->getLabel() . '</legend></h3>';

        return $output;
    }

    public function customRender($preserveFields) {
        if ($preserveFields) {
            return $this->render();
        }

        $output = array();
        $field_names = array();

        foreach ($this->fields as $index => $field) {
            $field_names[$index] = $field->getName();
        }

        $this->setNestedNames();
        foreach ($this->fields as $index => $field) {
            $output[$field_names[$index]] = $field->customRender($preserveFields);
        }

        return $output;
    }
}