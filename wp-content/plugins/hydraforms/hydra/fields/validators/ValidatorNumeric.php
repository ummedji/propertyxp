<?php

namespace Hydra\Fields\Validators;
use Hydra\Fields\Field;

class ValidatorNumeric extends Validator {

  public function __construct(Field $field, $message = NULL, $value = NULL) {
    if(!$message) {
      $message = 'Field ' . $field->getLabel() . ' is not numeric.';
    }
    parent::__construct($field, 'text', $message, TRUE);
  }

  public function validate() {
    $value = $this->getField()->getValue();

    if (!empty($value) && !is_numeric($value)) {
      return $this->getMessage();
    }
  }
}