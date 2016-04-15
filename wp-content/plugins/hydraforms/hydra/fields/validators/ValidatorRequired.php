<?php

namespace Hydra\Fields\Validators;
use Hydra\Fields\Field;

class ValidatorRequired extends Validator {

  public function __construct(Field $field, $message = NULL, $value = NULL) {
    if(!$message) {
      $message = 'Field ' . $field->getLabel() . ' is required.';
    }

    parent::__construct($field, 'text', $message, TRUE);
  }

  public function validate() {
    $value = $this->getField()->getValue();
      // zero is valid
    if (!$value && $value !== 0) {
      return $this->getMessage();
    }
  }
}