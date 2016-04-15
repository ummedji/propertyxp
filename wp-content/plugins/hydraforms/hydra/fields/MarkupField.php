<?php

namespace Hydra\Fields;

use Hydra\Builder;

class MarkupField extends Field {

  public function __construct($name, $value = '') {
    parent::__construct($name, 'markup', '', $value);
  }

  public function renderInput($name = null, $value = null) {

    if(!$value) {
      $value = $this->getValue();
    }

    if(!$name) {
     $name = $this->getName();
    }

    // return $value;
    // kinda.. not...
    $this->addAttribute('class', strtolower(str_replace('_', '-', $name)));
    return "<div " . $this->printAttributes() . ">" . $value . "</div>";
  }

  public function renderField() {
    return $this->renderInput();
  }

  public function render() {
    return $this->renderField();
  }
}