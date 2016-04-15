<?php

class HydraAdminFormField extends HydraAdminField {

  public function __construct() {
    $this->slug = 'hydraform';
  }


  public function fieldFormSubmit($form, $values) {
    $record = parent::fieldFormSubmit($form, $values);

    $url = $this->createRoute(
      'form',
      'list',
      array(
        'post_type' => $values['post_type'],
      )
    );

    $form->setRedirect($url);
  }

  public function fieldFormDelete($form, $values) {
    // delete group
    parent::fieldFormDelete($form, $values);

    $url = $this->createRoute(
      'form',
      'list',
      array(
        'post_type' => $values['post_type'],
      )
    );

    $form->setRedirect($url);
  }

  protected function returnUrl($post_type) {
    return $this->createRoute(
      'form',
      'list',
      array(
        'post_type' => $post_type,
      )
    );
  }

}