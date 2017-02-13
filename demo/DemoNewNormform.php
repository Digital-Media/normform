<?php
/**
 * Created by PhpStorm.
 * User: P21737
 * Date: 13.02.2017
 * Time: 13:53
 */

require("../NewNormform.class.php");

class DemoNewNormform extends NewNormform {

    const VORNAME = "vorname";
    const NACHNAME = "nachname";
    const NACHRICHT = "nachricht";

    private $result;

    protected function isValid(): bool {
        if ($this->isEmptyPostField(self::VORNAME)) {
            $this->errorMessages[self::VORNAME] = "First name is required.";
        }
        if ($this->isEmptyPostField(self::NACHNAME)) {
            $this->errorMessages[self::NACHNAME] = "Last name is required.";
        }

        return (count($this->errorMessages) === 0);
    }

    protected function business() {
        $this->result = $_POST;
        $this->statusMessage = "Processing successful!";

        return ["type" => "form", "name" => $this->defaultTemplate, "args" => $this->prepareFormFields(["fields", "errorStatus"], ["result" => $this->result])];
    }


    protected function prepareFormFields(array $parts, array $args = []): array {
        $result = [];

        $fields = [
            "vornameKey" => self::VORNAME,
            "nachnameKey" => self::NACHNAME,
            "nachrichtKey" => self::NACHRICHT
        ];
        if (in_array("fields", $parts)) {
            $result = array_merge($result, $fields);
        }

        $values = [
            "vornameValue" => $this->autofillFormField(self::VORNAME),
            "nachnameValue" => $this->autofillFormField(self::NACHNAME),
            "nachrichtValue" => $this->autofillFormField(self::NACHRICHT)
        ];
        if (in_array("values", $parts)) {
            $result = array_merge($result, $values);
        }

        $errorStatus = [
            "errorMessages" => $this->errorMessages,
            "statusMessage" => $this->statusMessage
        ];
        if (in_array("errorStatus", $parts)) {
            $result = array_merge($result, $errorStatus);
        }

        $result = array_merge($result, $args);

        return $result;
    }
}

$form = new DemoNewNormform("demoMain.tpl", "../basetemplates", "../basetemplates_c");
$form->normForm();