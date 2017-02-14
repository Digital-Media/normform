<?php

require_once ("ParameterInterface.php");

class PostParameter implements ParameterInterface {
    private $name;
    private $value;

    function __construct(string $postName) {
        $this->name = $postName;
        $this->updateValue();
    }

    private function updateValue() {
        $this->value = isset($_POST[$this->name]) ? Utilities::sanitizeFilter($_POST[$this->name]) : "";
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        $this->updateValue();
        return $this->value;
    }
}