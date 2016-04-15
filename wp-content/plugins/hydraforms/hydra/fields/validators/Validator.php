<?php

namespace Hydra\Fields\Validators;

use Hydra\Fields\Field;


class Validator implements ValidatorInterface {
  const VALIDATOR_CONDITION_EQUALS = 1;
  const VALIDATOR_CONDITION_NOT_EQUALS = 2;
  const VALIDATOR_CONDITION_EMPTY = 3;
  const VALIDATOR_CONDITION_NOT_EMPTY = 4;
  const VALIDATOR_CONDITION_IN_ARRAY = 5;
  const VALIDATOR_CONDITION_NOT_IN_ARRAY = 6;

  private $field;
  private $type;
  private $message;

  public function __construct(Field $field, $type, $message, $value) {
    $this->field = $field;
    $this->message = $message;
    $this->type = $type;
    $this->value = $value;
  }

  protected function buildConditions() {

  }

  protected function getMessage($value = null) {
    if($value) {
      return str_replace('!value', $value, $this->message);
    }

    return $this->message;
  }

  protected function getField() {

    return $this->field;
  }

  protected function getValue() {
    return $this->value;
  }

  public function validate() {
    $values = $this->field->getBuilder()->getValues();
    $value = $values[$this->field->getName()];

    switch($this->type) {
      case Validator::VALIDATOR_CONDITION_EQUALS:
        if($value != $this->value) {
          return $this->getMessage($value);
        }
        break;
      case Validator::VALIDATOR_CONDITION_NOT_EQUALS:
        if($value == $this->value) {
          return $this->getMessage($value);
        }
        break;
      case Validator::VALIDATOR_CONDITION_EMPTY:
        if(!empty($value)) {
          return $this->getMessage($value);
        }
        break;
      case Validator::VALIDATOR_CONDITION_NOT_EMPTY:
        if(empty($value)) {
          return $this->getMessage($value);
        }
        break;
      case Validator::VALIDATOR_CONDITION_IN_ARRAY:
        if(!in_array($value, $this->value)) {
          return $this->getMessage($value);
        }
        break;
      case Validator::VALIDATOR_CONDITION_NOT_IN_ARRAY:
        if(in_array($value, $this->value)) {
          return $this->getMessage($value);
        }
        break;
    }
  }
}
