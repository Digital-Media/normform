<?php

require_once("Utilities.class.php");

class View {
    const FORM = 1;
    const TEMPLATE = 2;
    const URL = 3;

    private $type;
    private $name;
    private $args;

    function __construct(int $type = 1, string $name = "form.tpl", array $args = []) {
        $this->type = $type;
        $this->name = $name;
        $this->args = $args;
    }

    function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function addArg($arg) {
        $this->args[] = $arg;
    }
}
