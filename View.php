<?php

require_once("Utilities.class.php");

class View {
    const FORM = 0;
    const TEMPLATE = 1;
    const URL = 2;

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

    public function setParameter(ParameterInterface $param) {
        $paramName = $param->getName();
        foreach ($this->params as &$arg) {
            if ($arg->getName() === $paramName) {
                $arg = $param;
                return;
            }
        }
        $this->params[] = $param;
    }
}
