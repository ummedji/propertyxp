<?php

namespace Hydra\Fields;


class ButtonField extends Field {

  public function __construct($name, $value = 'Submit') {
    $this->type = 'button';
    $this->name = $name;
    $this->value = $value;
  }

  public function renderLabel() {
    return '';
  }
}