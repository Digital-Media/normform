<?php

/**
 * Created by PhpStorm.
 * User: P21737
 * Date: 13.02.2017
 * Time: 16:56
 */
require_once("Utilities.class.php");

class FormView {
    private $type;
    private $name;
    private $args;

    function __construct(string $type = "form", string $name = "form.tpl", array $args = []) {
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
}

class FormParam {
    private $name;
    private $value;

    function __construct(string $postName) {
        $this->name = $postName;
        $this->setValue($postName);
    }

    public function setValue(string $postName) {
        $this->value = isset($_POST[$postName]) ? Utilities::sanitizeFilter($_POST[$postName]) : "";
    }

    function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }
}
