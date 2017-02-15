<?php

require_once("ParameterInterface.php");

class PostParameter implements ParameterInterface {
    private $name;
    private $value;
    private $forceEmpty;

    function __construct(string $postName, bool $forceEmpty = false) {
        $this->forceEmpty = $forceEmpty;
        $this->name = $postName;
        $this->updateValue();
    }

    private function updateValue() {
        if ($this->forceEmpty) {
            $this->value = "";
        }
        else {
            $this->value = isset($_POST[$this->name]) ? Utilities::sanitizeFilter($_POST[$this->name]) : "";
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        $this->updateValue();
        return $this->value;
    }
}