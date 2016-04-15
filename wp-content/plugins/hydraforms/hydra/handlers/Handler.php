<?php


namespace Hydra\Handlers;

use Hydra\Builder;

class Handler {
    public $name;

    public function __construct() {
        $this->name = 'generic';
    }

    // settings field to return
    public function getSettings($parentElement) {

    }

    // action to do
    public function action($handler, $form, $values) {

    }

    public function replaceTokens($value) {

    }

    /**
     * Get instance of handler
     * @param $name
     * @return Handler
     */
    public static function getHandler($name) {
        static $handlers;

        $name = ucfirst($name);
        // we might want to call the same formatter multiple times
        // don't initialize the same formatter again as
        $handlerClass = '\\Hydra\\Handlers\\' . $name . 'Handler';

        try {
        // "Lazy" load
        // require_once $name . 'Handler.php';
            $reflection = new \ReflectionClass($handlerClass);
            $handlers[$name] = $reflection->newInstanceArgs(array());
            return $handlers[$name];
        } catch (Exception $e) {
            // @todo create custom exceptions
            // echo $e->getMessage();
        }

        return NULL;
    }
}

class MailHandler extends Handler {

    public function __construct() {
        $this->name = 'mail';
    }

    public function getSettings($parentElement) {
        parent::getSettings($parentElement);
        $parentElement->removeAllDecorators();
        $parentElement->addField('text', array('subject', __('Mail Subject', 'hydraforms')))
            ->enableTranslatable();

        $parentElement->addField('textarea', array('mail_to', __('Mail To', 'hydraforms')))
            ->addAttribute('class', 'token-area');

        $parentElement->addField('textarea', array('message', __('Message text', 'hydraforms')))
            ->addAttribute('class', 'token-area')
            ->enableTranslatable();
    }

    public function action($settings, $form, $values) {
        $headers = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=iso-8859-1',
        );

        $message = nl2br($settings['message']);
        wp_mail($settings['mail_to'], $settings['subject'], $message, $headers);

    }
}

class MessageHandler extends Handler {
    public function __construct() {
        $this->name = 'message';
    }

    public function getSettings($parentElement) {
        $parentElement->removeAllDecorators();
        $parentElement->addField('textarea', array('message', __('Message', 'hydraforms')))
            ->addAttribute('class', 'token-area')
            ->setRows("3")
            ->setCols("80")
            ->enableTranslatable();
    }

    public function action($settings, $form, $values) {
        $form->addSuccessMessage($settings['message']);
    }
}

