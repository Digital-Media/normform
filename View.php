<?php

require_once("Utilities.class.php");

class View {
    const FORM = 1;
    const TEMPLATE = 2;
    const URL = 3;

    private $type;
    private $name;
    private $params;

    function __construct(int $type = 1, string $name = "form.tpl", array $params = []) {
        $this->type = $type;
        $this->name = $name;
        $this->params = $params;
    }

    public function getType(): int {
        return $this->type;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getParameters() : array {
        return $this->params;
    }

    public function addParameter(ParameterInterface $param) {
        $this->params[] = $param;
    }

    public function updateParameter(ParameterInterface $param) {
        foreach ($this->params as &$arg) {
            if (strcmp($arg->getName(), $param->getName()) === 0) {
                $arg = $param;
                break;
            }
        }
    }
}
