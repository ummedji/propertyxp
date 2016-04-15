<?php

namespace Hydra\Fields;

use Hydra\Builder;

class CheckboxField extends Field {

    public function __construct($name, $label = '') {
        parent::__construct($name, 'checkbox', $label);
    }

    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * Get value - if not found in session - returns back to default value
     * @todo - Fallback to input form should be registered also - in case of invalidating form
     * @return string
     */
    public function getValue() {

        if ($this->value || $this->value == 0) {
            return $this->value;
        }
        else {
            return !empty($this->defaultValue) ? $this->defaultValue : "";
        }
    }


    public function renderField() {
        return $this->renderInput() . $this->renderLabel() . $this->renderDescription();
    }

    public function renderInputElement($name = NULL, $value = NULL) {
        $value = $this->getValue();

        if (!$name) {
            $name = $this->name;
        }

        if ($value) {
            $this->addAttribute('checked', 'checked');
        }
        else {
            if ($value === NULL && $this->getDefaultValue()) {
                $this->addAttribute('checked', 'checked');
            }
        }

        $output = "<div class=checkbox>";
        $output .= "<input type=\"hidden\" value=\"0\" name=\"" . $name . "\">";
        $output .= "<label>";
        $output .= "<input " . $this->printAttributes() . " type=\"$this->type\" name=\"$name\">";
        $output .= "</label>";
        $output .= "</div>";

        return $output;
    }

    public function renderLabel() {
        return $this->getLabel();
    }
}