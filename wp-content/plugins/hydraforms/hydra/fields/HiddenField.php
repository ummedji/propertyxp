<?php

namespace Hydra\Fields;

class HiddenField extends Field {

  public function __construct($name, $value)
  {
    parent::__construct($name, 'hidden', '', $value);
  }

  public function renderLabel() {
    return '';
  }

  public function renderDescription() {
    return '';
  }

  public function render() {
    return $this->renderField();
  }
}