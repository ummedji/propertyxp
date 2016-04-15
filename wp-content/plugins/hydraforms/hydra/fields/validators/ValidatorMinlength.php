<?php

namespace Hydra\Fields\Validators;
use Hydra\Fields\Field;

class ValidatorMinlength extends Validator {

  public function __construct(Field $field, $message, $value) {
    parent::__construct($field, 'minlength', $message, $value);
  }

  public function validate() {
    $values = $this->getField()->getBuilder()->getValues();

    if (!isset($values[$this->getField()->getName()])) {
      return;
    }
    if (strlen($values[$this->getField()->getName()]) < $this->getValue()) {
      return $this->getMessage();
    }
  }

}