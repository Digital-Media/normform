<?php

/**
 * Created by PhpStorm.
 * User: P21737
 * Date: 13.02.2017
 * Time: 13:49
 */

require_once("Utilities.class.php");
require_once("FormView.class.php");
require_once("vendor/smarty/smarty/libs/Smarty.class.php");

abstract class NewNormform {

    //protected $defaultTemplate;

    protected $defaultView;

    protected $errorMessages;

    protected $statusMessage;

    protected $smarty;

    public function __construct(FormView $defaultView, string $templateDir = "templates", string $compileDir = "templates_c") {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $templateDir;
        $this->smarty->compile_dir = $compileDir;
        //$this->defaultTemplate = $defaultTemplate;
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
                //$this->show(["type" => "form", "name" => $this->defaultTemplate, "args" => $this->prepareFormFields(["fields", "values", "errorStatus"])]);
                //$this->show(new FormView("form", "demoMain.tpl", $this->prepareFormFields(["fields", "values", "errorStatus"])));
                $this->show();
            }
        }
        else {
            //$this->show(["type" => "form", "name" => $this->defaultTemplate, "args" => $this->prepareFormFields(["fields"])]);
            //$this->show(new FormView("form", "demoMain.tpl", $this->prepareFormFields(["fields"])));
            $this->show();
        }
    }

    protected function isFormSubmission(): bool {
        return ($_SERVER["REQUEST_METHOD"] === "POST");
    }

    abstract protected function isValid(): bool;

    abstract protected function business();

    abstract protected function prepareFormFields(array $parts, array $args = []): array;

    /*protected function show(array $view = ["type" => "form", "name" => "form.tpl", "args" => null]) {
        switch ($view["type"]) {
            case "form":
                foreach ($view["args"] as $key => $value) {
                    $this->smarty->assign($key, $value);
                }
                $this->smarty->display($view["name"]);
                break;
            case "template":
                $this->smarty->display($view["name"]);
                // check args
                break;
            case "url":
                header("Location: " . $view["name"] . "?" . http_build_query($view["args"], "", "&amp;"));
                break;
            default:
                break;
        }
    }*/

    protected function show(FormView $view = null) {
        if (is_null($view)) {
            $view = $this->defaultView;
        }
        switch ($view->type) {
            case "form":
                /*foreach ($view->args as $key => $value) {
                    $this->smarty->assign($key, $value);
                }*/
                foreach ($view->args as $param) {
                    if($param instanceof FormParam) {
                        $this->smarty->assign("$param->name", $param);
                    }
                }
                $this->smarty->display($view->name);
                break;
            case "template":
                $this->smarty->display($view->name);
                // check args
                break;
            case "url":
                header("Location: " . $view->name . "?" . http_build_query($view->args, "", "&amp;"));
                break;
            default:
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
