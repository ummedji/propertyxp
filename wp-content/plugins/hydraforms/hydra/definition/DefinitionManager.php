<?php

namespace Hydra\Definitions;

require_once 'FieldDefinition.php';

class DefinitionManager {
    private $form;

    public function __construct($form = NULL) {
        $this->form = $form;
    }

    public function createDefinition($name, $item = NULL, $widgetType = 'field') {
        $definition = hydra_field_get_definition($name);
        $instanceArgs = array($this->form, $widgetType);

        if (file_exists($definition['file'])) {
            try {
                require_once $definition['file'];
                $reflection = new \ReflectionClass($definition['class']);
                $definitionClass = $reflection->newInstanceArgs($instanceArgs);

                if ($this->form) {
                    $definitionClass->buildDefinition($item);
                }

                return $definitionClass;
            } catch (Exception $e) {
                // @todo create custom exceptions
                // echo $e->getMessage();
            }
        }
    }
}
