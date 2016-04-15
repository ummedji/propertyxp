<?php

namespace Hydra\Fields;

use Hydra\Builder;

class RadiosField extends Field {
  private $options;
  public function setOptions($options) {
    $this->options = $options;
  }

  public function __construct($name, $label = '',  $options = array()) {
    $this->options = $options;
    parent::__construct($name, 'radio', $label);
  }

  public function renderInputElement($name = null, $value = null) {
    $output = '';

    $defaultValue = $this->getValue();
    if(!$name) {
      $name = $this->name;
    }
    // @TODO - unite handling of multiple values forms - like checkboxes, multiselect..
    $output .= "<ul class=\"list-unstyled\">";
    foreach($this->options as $key => $option) {
      $attr = '';

      if(is_array($defaultValue)) {
        if(isset($defaultValue[$key]) && $defaultValue[$key]) {
          $attr = 'checked="checked"';
        }
      } elseif($key == $this->getValue()) {
        $attr = 'checked="checked"';
      }
      $output .= "<li>";
      $output .= "<label>";
      $output .= "<input " . $this->printAttributes() . " type=\"$this->type\" value=\"".$key."\" name=\"$name\" $attr> " . $option;
      $output .= "</label>";
      $output .= "</li>";
    }
    $output .= "</ul>";

    return $output;
  }
}
