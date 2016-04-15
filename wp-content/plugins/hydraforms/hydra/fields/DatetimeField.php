<?php

namespace Hydra\Fields;

use Hydra\Builder;

class DatetimeField extends Field {

    public function __construct($name, $label = '')
    {
      parent::__construct($name, 'datetime-local', $label);
      $this->addAttribute('class', 'form-control');
    }
}