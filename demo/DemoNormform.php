<?php

require_once("../AbstractNormform.php");
require_once("../GenericParameter.php");
require_once("../PostParameter.php");

class DemoNormform extends AbstractNormform {

    const FIRSTNAME = "lastname";
    const LASTNAME = "firstname";
    const MESSAGE = "message";

    private $result;

    protected function isValid(): bool {
        if ($this->isEmptyPostField(self::FIRSTNAME)) {
            $this->errorMessages[self::FIRSTNAME] = "First name is required.";
        }
        if ($this->isEmptyPostField(self::LASTNAME)) {
            $this->errorMessages[self::LASTNAME] = "Last name is required.";
        }

        $this->defaultView->addArg(new GenericParameter("errorMessages", $this->errorMessages));

        return (count($this->errorMessages) === 0);
    }

    protected function business() {
        $this->result = $_POST;
        $this->defaultView->addArg(new GenericParameter("result", $this->result));

        $this->statusMessage = "Processing successful!";
        $this->defaultView->addArg(new GenericParameter("statusMessage", $this->statusMessage));

        return (new View(View::TEMPLATE, "noFormOutput.tpl", [new GenericParameter("result", $this->result)]));
        //return (new View(View::URL, "externalresult.php", $this->result));
    }
}

$view = new View(View::FORM, "mainForm.tpl", [
    new PostParameter(DemoNormform::FIRSTNAME),
    new PostParameter(DemoNormform::LASTNAME),
    new PostParameter(DemoNormform::MESSAGE),
]);

$form = new DemoNormform($view, "../basetemplates", "../basetemplates_c");
$form->normForm();
