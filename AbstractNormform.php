<?php

require_once("Utilities.class.php");
require_once("View.php");
require_once("GenericParameter.php");
require_once("PostParameter.php");
require_once("vendor/smarty/smarty/libs/Smarty.class.php");

abstract class AbstractNormform {

    protected $currentView;

    protected $errorMessages;

    protected $statusMessage;

    protected $smarty;

    abstract protected function isValid(): bool;

    abstract protected function business();

    public function __construct(View $defaultView, string $templateDir = "templates", string $compileDir = "templates_c") {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $templateDir;
        $this->smarty->compile_dir = $compileDir;
        $this->currentView = $defaultView;
        $this->errorMessages = [];
        $this->statusMessage = "";
    }

    public function normForm() {
        if ($this->isFormSubmission()) {
            if ($this->isValid()) {
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
            $view = $this->currentView;
        }
        switch ($view->getType()) {
            case View::FORM:
                foreach ($view->getParameters() as $param) {
                    if ($param instanceof PostParameter) {
                        $this->smarty->assign($param->getName(), $param);
                    }
                    else if ($param instanceof GenericParameter) {
                        $this->smarty->assign($param->getName(), $param->getValue());
                    }
                }
                $this->smarty->display($view->getName());
                break;
            case View::TEMPLATE:
                foreach ($view->getParameters() as $param) {
                    if ($param instanceof GenericParameter) {
                        $this->smarty->assign($param->getName(), $param->getValue());
                    }
                }
                $this->smarty->display($view->getName());
                break;
            case View::URL:
                $queryParameters = [];
                foreach ($view->getParameters() as $key => $param) {
                    if ($param instanceof GenericParameter) {
                        $value = $param->getValue();
                        if (is_array($value)) {
                            $queryParameters = array_merge($queryParameters, $value);
                        }
                        else {
                            $queryParameters[$param->getName()] = $value;
                        }
                    }
                    else if (is_array($param)) {
                        $queryParameters = array_merge($queryParameters, $param);
                    }
                    else {
                        $queryParameters[$key] = $param;
                    }
                }
                header("Location: " . $view->getName() . "?" . http_build_query($queryParameters));
                break;
            default:
                // Throw an exception or show an error page
                break;
        }
    }

    protected function isEmptyPostField(string $index): bool {
        return (!isset($_POST[$index]) || strlen(trim($_POST[$index])) === 0);
    }
}
