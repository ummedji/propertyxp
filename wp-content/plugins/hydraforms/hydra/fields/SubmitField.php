<?php

namespace Hydra\Fields;
use Hydra\Builder;

class SubmitField extends Field {

    public function __construct($name, $value = 'Submit') {
        $this->type = 'submit';
        $this->name = $name;
        $this->value = $value;
        $this->addAttribute('class', 'btn');
    }

    private $onSuccess;
    private $onValidation;

    public function getOnSuccess() {
        return $this->onSuccess;
    }

    public function getOnValidation() {
        return $this->onValidation;
    }

    public function setBuilder(Builder $builder) {
        $this->builder = $builder;
        $this->builder->addSubmitField($this->name);
    }

    // nesting may appear;
    public function setName($name) {
        // new name is submitted, thus old handler needs to be removed
        if ($this->getName()) {
            $this->getBuilder()->removeSubmitField($this->getName());
        }

        $this->getBuilder()->addSubmitField($name);
        $this->name = $name;
    }

    /**
     * @param $callback
     * @param null $object
     * @return $this
     */
    public function addOnSuccess($callback, $object = NULL) {
        $this->onSuccess[] = array(
            'callback' => $callback,
            'object' => $object,
        );

        return $this;
    }

    /**
     * @param $callback
     * @param null $object
     * @return $this
     */
    public function addOnValidation($callback, $object = NULL) {
        $this->onValidation[] = array(
            'callback' => $callback,
            'object' => $object,
        );

        return $this;
    }

    public function renderLabel() {
        return '';
    }


}