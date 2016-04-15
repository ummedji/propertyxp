<?php

namespace Hydra\Decorators;

class TableDecorator {

  public function __construct($null = array()) {

  }

  public function render($fields) {
    if(!count($fields)) {
        return '';
    }
    $output = '<table>';

    foreach ($fields as $field) {
      if($field->getType() == 'hidden') { continue; }

      if($field->getType() == 'fieldset') {
        $output .= "<tr>";
        $output .= '<td colspan=2>' . $field->render() . '</td>';
        $output .= "</tr>";
      } else {
        $output .= '<tr>';
        $output .= '<th>' . $field->renderLabel() . '</th>';
        $output .= '<td>' . $field->renderInput() . $field->renderDescription() . '</td>';
        $output .= '</tr>';
      }

    }
    $output .= '</table>';

    foreach($fields as $field) {

      if($field->getType() == 'hidden') {
        $field->renderField();
      }
    }
    return $output;
  }
}