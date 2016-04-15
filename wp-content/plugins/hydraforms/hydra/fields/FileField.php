<?php

namespace Hydra\Fields;

use Hydra\Builder;

class FileField extends Field {

  public function __construct($name, $label = '') {
    parent::__construct($name, 'file', $label);
    $this->addAttribute('class', 'form-control');
  }

  public function setBuilder(Builder $builder) {
    parent::setBuilder($builder);
    $this->getBuilder()->addAttribute('enctype', 'multipart/form-data');
  }
}