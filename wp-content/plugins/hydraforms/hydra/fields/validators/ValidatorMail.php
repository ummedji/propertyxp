<?php

namespace Hydra\Fields\Validators;

use Hydra\Fields\Field;

class ValidatorMail extends Validator
{

    public function __construct(Field $field, $message = NULL, $value = NULL)
    {
        if(!$message) {
            $message = 'Field ' . $field->getLabel() . ' is not a valid e-mail address.';
        }
        parent::__construct($field, $field->getType(), $message, TRUE);
    }

    public function validate()
    {
        $value = $this->getField()->getValue();

        if ($value) {
            if (!(bool)filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return $this->getMessage();
            }
        }

    }
}