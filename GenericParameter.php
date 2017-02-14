<?php

require_once("ParameterInterface.php");

class GenericParameter implements ParameterInterface {
    private $name;
    private $value;

    function __construct(string $name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }
}