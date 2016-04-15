<?php

namespace Hydra\Fields;

use Hydra\Builder;

class TextField extends Field {

    public function __construct($name, $label = '')
    {
      parent::__construct($name, 'text', $label);
      $this->addAttribute('class', 'form-control');
    }


}