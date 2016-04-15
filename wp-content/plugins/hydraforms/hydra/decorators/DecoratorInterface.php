<?php

namespace Hydra\Decorators;

interface DecoratorInterface {

  public function __construct($field, $type);
  public function render();
}



