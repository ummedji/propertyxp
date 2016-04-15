<?php

namespace Hydra\Fields;


class SelectField extends Field {

    private $options;
    private $optionClasses;

    public function __construct($name, $label = '', $options = array()) {
        $this->options = $options;
        parent::__construct($name, 'select', $label);
        $this->addAttribute('class', 'form-control');
    }

    public function setOptionsClasses($classes) {
        $this->optionClasses = $classes;
        return $this;
    }

    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    public function getOptions() {
        $placeholder = $this->getAttribute('data-placeholder');

        if (isset($this->options[0]) && $placeholder) {
            if (is_array($placeholder)) {
                $this->options[0] = reset($placeholder);
            }
            else {
                $this->options[0] = $placeholder;
            }
        }

        return $this->options;
    }

    public function renderInputElement($name = NULL, $value = NULL) {
        $output = '';

        $printAttributes = $this->printAttributes();
        if (!$name) {
            $name = $this->name;
        }
        if (strstr($printAttributes, 'multiple')) {
            $name = $name . "[]";
        }

        $output .= "<select " . $printAttributes . " name=\"$name\">";

        if (!$value) {
            $value = $this->getValue();
        }
        $options = $this->getOptions();
        if(!count($options)) {
            $output .= "</select>";
            return $output;
        }

        foreach ($options as $key => $option) {

            $attr = '';
            if (is_array($value)) {
                if (in_array($key, $value)) {
                    $attr = ' selected="selected"';
                }
            }
            elseif ($key == $value) {
                $attr = ' selected="selected" ';
            }


            if(isset($this->optionClasses[$key])) {
                $attr .= " class=\"".$this->optionClasses[$key]."\"";
            }
            if($key === '') {
                $output .= "<option value=\"\"" . $attr . ">$option</option>";
            } else {
                $output .= "<option value=\"$key\" " . $attr . ">$option</option>";
            }
        }

        $output .= "</select>";


        return $output;
    }


}