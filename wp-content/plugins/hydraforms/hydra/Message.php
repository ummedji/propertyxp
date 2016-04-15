<?php
namespace Hydra;

class Message {
  private $text;
  private $type;
  private $fieldName;

  public function __construct($text, $type, $name = NULL) {
    $this->type = $type;
    $this->text = $text;

    $this->fieldName = 'GLOBAL';
    if($name) {
      $this->fieldName = $name;
    }
  }

  public function render() {
    return "<div class=\"alert alert-$this->type\">$this->text</div>";
  }

  public function getFieldName() {
    return $this->fieldName;
  }

  public function getType() {
    return $this->type;
  }

  public function getText() {
    return $this->text;
  }

}