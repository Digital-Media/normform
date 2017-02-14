<?php

require_once("Utilities.class.php");
require_once("View.php");
require_once("GenericParameter.php");
require_once("PostParameter.php");
require_once("vendor/smarty/smarty/libs/Smarty.class.php");

abstract class AbstractNormform {

    protected $defaultView;

    protected $errorMessages;

    protected $statusMessage;

    protected $smarty;

    abstract protected function isValid(): bool;

    abstract protected function business();

    public function __construct(View $defaultView, string $templateDir = "templates", string $compileDir = "templates_c") {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $templateDir;
        $this->smarty->compile_dir = $compileDir;
        $this->defaultView = $defaultView;
        $this->errorMessages = [];
        $this->statusMessage = "";
    }

    public function normForm() {
        if ($this->isFormSubmission()) {
            if ($this->isValid()) {
                $view = null;
                $view = $this->business();
                $this->show($view);
            }
            else {
                $this->show();
            }
        }
        else {
            $this->show();
        }
    }

    protected function isFormSubmission(): bool {
        return ($_SERVER["REQUEST_METHOD"] === "POST");
    }

    protected function show(View $view = null) {
        if (is_null($view)) {
            $view = $this->defaultView;
        }
        switch ($view->type) {
            case View::FORM:
                foreach ($view->args as $param) {
                    if ($param instanceof PostParameter) {
                        $this->smarty->assign($param->getName(), $param);
                    }
                    else if ($param instanceof GenericParameter) {
                        $this->smarty->assign($param->getName(), $param->getValue());
                    }
                }
                $this->smarty->display($view->name);
                break;
            case View::TEMPLATE:
                foreach ($view->args as $param) {
                    if ($param instanceof GenericParameter) {
                        $this->smarty->assign($param->getName(), $param->getValue());
                    }
                }
                $this->smarty->display($view->name);
                break;
            case View::URL:
                header("Location: " . $view->name . "?" . http_build_query($view->args));
                break;
            default:
                // Throw an exception or show an error page
                break;
        }
    }

    protected function isEmptyPostField(string $index): bool {
        return (!isset($_POST[$index]) || strlen(trim($_POST[$index])) === 0);
    }

    protected function autofillFormField(string $name) {
        return isset($_POST[$name]) ? Utilities::sanitizeFilter(trim($_POST[$name])) : "";
    }
}
