<?php

namespace Hydra;

require_once 'Message.php';

class MessageManager {

  private $form_id;
  private $messages = array();
  private $errors = array();
  public function __construct($form_id) {
    $this->form_id = $form_id;
  }

  public function clearMessages() {
    $this->messages = array();
    $this->errors = array();
  }

  public function addError($message) {
    $this->errors[] = $message;
  }

  public function getErrors() {
    if(!is_array($this->errors) || !count($this->errors)) {
      $this->errors = $this->initErrors();
    }

    $errors = $this->errors;
    // Called only once ! afterwards we need to scratch the data
    return $errors;
  }

  /**
   * Add single message
   * @param $message
   */
  public function addMessage($message) {
    if($message->getType() == "danger") {
      $this->addError($message);
    }

    $this->messages[] = $message;
  }

  /**
   * Add array of messages
   * @param $messages
   */
  public function addMessages($messages) {
    if (is_array($messages) && count($messages)) {
      foreach($messages as $message) {
        $this->addMessage($message);
      }
    }
  }

  public function initMessages() {
    $messages = array();
    if (isset($_SESSION['hydra']['messages'][$this->form_id])) {
      $messages = $_SESSION['hydra']['messages'][$this->form_id];
      $this->messages = array();
      $this->flushMessages();
      $messages = $this->initHydraMessages($messages);
    }

    return $messages;
  }

  private function initErrors() {
    $errors = array();
    if (isset($_SESSION['hydra']['errors'][$this->form_id])) {
      $errors = $_SESSION['hydra']['errors'][$this->form_id];
      $this->errors = array();
      $this->flushErrors();
      $errors = $this->initHydraMessages($errors);
    }

    return $errors;
  }

  /**
   * @return array
   */
  public function getMessages() {
    if(!is_array($this->messages) || !count($this->messages)) {
      $messages = $this->initMessages();
      $this->messages = $messages;
    }

    return $this->messages;
  }

  // render messages related to form
  public function renderMessages() {

    if(isset($_SESSION['hydra']['message_render'][$this->form_id])) {
      unset($_SESSION['hydra']['message_render'][$this->form_id]);
      $this->flushMessages();
      $this->flushErrors();
      return;
    }

    $messages = $this->getMessages(TRUE);
    $output = "";
    if(count($messages)) {
      $output = "<ul class=\"messages\">";
      foreach ($messages as $message) {
        $output .= "<li>";
        $output .= $message->render();
        $output .= "</li>";
      }
      $output .= "</ul>";
    }

    return $output;
  }

  private function initHydraMessages($messages) {

    $hydraMessages = array();
    if (count($messages)) {
      foreach ($messages as $message) {
        $hydraMessages[] = new Message($message['text'], $message['type'], $message['field_name']);
      }
    }

    return $hydraMessages;

  }


  /**
   * Move messages from object to session
   */
  public function store() {
    if (!count($this->messages)) {
      return;
    }
    $this->flushMessages();
    $this->flushErrors();

    foreach ($this->messages as $message) {
      $_SESSION['hydra']['messages'][$this->form_id][] = array(
        'type' => $message->getType(),
        'field_name' => $message->getFieldName(),
        'text' => $message->getText(),
      );
    }

    foreach($this->errors as $error) {
      $_SESSION['hydra']['errors'][$this->form_id][] = array(
        'type' => $error->getType(),
        'field_name' => $error->getFieldName(),
        'text' => $error->getText(),
      );
    }
  }

  private function flushErrors() {
    unset($_SESSION['hydra']['errors'][$this->form_id]);
  }

  private function flushMessages() {
    unset($_SESSION['hydra']['messages'][$this->form_id]);
  }


  public static function flushAllMessages() {
    unset($_SESSION['hydra']['messages']);
  }

  // get all messages - not just form related
  public static function getAllMessages($init = FALSE) {
    $messages = array();

    if (isset($_SESSION['hydra']['messages'])) {
      foreach ($_SESSION['hydra']['messages'] as $index => $formMessages) {
        $_SESSION['hydra']['message_render'][$index] = true;

        if ($init) {
          if (count($formMessages)) {
            foreach ($formMessages as $formMessage) {
              $messages[] = new Message($formMessage['text'], $formMessage['type'], $formMessage['field_name']);
            }
          }
        }
        else {
          $messages += $formMessages;
        }
      }
    }

    MessageManager::flushAllMessages();
    return $messages;
  }

  public static function renderAllMessages() {
    $messages = MessageManager::getAllMessages(TRUE);

    $output = "<ul class=\"messages\">";
    foreach ($messages as $message) {
      $output .= "<li>";
      $output .= $message->render();
      $output .= "</li>";
    }
    $output .= "</ul>";


    return $output;
  }
}