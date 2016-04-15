<?php

namespace Hydra\Fields;

class TextareaField extends Field {

  public function __construct($name, $label = '') {
    parent::__construct($name, 'textarea', $label);
    $this->addAttribute('class', 'form-control');
    $this->setCols("50");
    $this->setRows("5");
  }

  public function setCols($cols) {
    $this->setAttribute('cols', (string)$cols);
    return $this;
  }

  public function setRows($rows) {
    $this->setAttribute('rows', (string)$rows);
    return $this;
  }

  public function renderInputElement($name = null, $value = null) {
    if(!$name) {
      $name = $this->name;
    }
    if(!$value) {
      $value = $this->getValue();
    }

    return "<textarea " . $this->printAttributes() . " name=\"$name\">" . $value . "</textarea>";
  }

}