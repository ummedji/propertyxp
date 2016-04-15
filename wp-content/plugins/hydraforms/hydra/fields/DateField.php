<?php

namespace Hydra\Fields;

use Hydra\Builder;

class DateField extends Field {

    public function __construct($name, $label = '')
    {
      parent::__construct($name, 'date', $label);
      $this->addAttribute('class', 'form-control');
    }
}