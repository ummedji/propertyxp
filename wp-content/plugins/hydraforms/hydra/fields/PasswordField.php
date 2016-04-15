<?php

namespace Hydra\Fields;

use Hydra\Builder;

class PasswordField extends Field {

    public function __construct($name, $label = '')
    {
      parent::__construct($name, 'password', $label);
      $this->addAttribute('class', 'form-control');
    }



    public function renderInputElement($name = NULL, $value = NULL) {
        if (!$name) {
            $name = $this->name;
        }

        if (!$value) {
            $value = $this->getValue();
        }

        // value should never be rendered for password fields
        $output = "<input " . $this->printAttributes() . " type=\"$this->type\" name=\"$name\">";
        if ($decorators = $this->getDecorators()) {
            foreach ($decorators as $decorator) {
                $output = str_replace('!field', $output, $decorator->render());
            }
        }

        return $output;
    }

}