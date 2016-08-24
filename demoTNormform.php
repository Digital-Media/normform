<?php

require("TNormform.class.php");

/*
 * Das objektorientierte und templatebasierte PHP-Normformular dient zur Erfassung, Verarbeitung und Validierung von Formulardaten.
 *
 * Diese konkrete Klasse erweitert die abstrakte Basisklasse TNormform.
 * Weiters benötigt es die Klasse DBaccess für Datenbankzugriffe, die die Klasse FileAccess ersetzt
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2016
 */
class DemoTNormForm extends TNormForm {
    /**
     *  Konstanten für ein HTML Attribute <input name='vorname' id='vornamel' ...> --> <input name=EMAIL id=EMAIL ...> usw.
     */
    const VORNAME = "vorname";
    const NACHNAME = "nachname";
    const NACHRICHT = "nachricht";

    /**
     * Übergibt die konkreten Inhalte an das Formularfeld. Dies sind einerseits die Bezeichnungen der Felder, die aus den
     * Konstanten stammen, als auch eventuell vorauszufüllende Werte, die über die Funktion {@see param()} eingesetzt werden.
     * Sie muss implementiert werden, weil sie in TNormform eine abstracte Klasse ist.
     */
    protected function prepareFormFields() {
        $this->smarty->assign("vornameKey", self::VORNAME);
        $this->smarty->assign("vornameValue", $this->autofillFormField(self::VORNAME));
        $this->smarty->assign("nachnameKey", self::NACHNAME);
        $this->smarty->assign("nachnameValue", $this->autofillFormField(self::NACHNAME));
        $this->smarty->assign("nachrichtKey", self::NACHRICHT);
        $this->smarty->assign("nachrichtValue", $this->autofillFormField(self::NACHRICHT));
    }

    /**
     * Diese Methode gibt das Template aus. Sie muss implementiert werden, weil sie in TNormform eine abstracte Klasse ist.
     */
    protected  function display()
    {
        $this->smarty->display('demoMain.tpl');
    }

    /**
     * Überprüft, ob das Formularfeld korrekt ausgefüllt wurde. Die Kriterien werden in dieser Funktion anhand verschiedener
     * if-Bedingungen selbst angegeben. Schlägt ein Kriterium fehl, erfolgt ein Eintrag in die Eigenschaft <pre>$errMsg</pre>.
     *
     * @return bool Gibt <pre>true</pre> zurück, wenn alle Kriterien erfüllt wurden, ansonsten <pre>false</pre>.
     */
    protected function isValid() {
        if ($this->isEmptyPostField(self::VORNAME)) {
            $this->errMsg[self::VORNAME] = "Vorname fehlt.";
        }
        if ($this->isEmptyPostField(self::NACHNAME)) {
            $this->errMsg[self::NACHNAME] = "Nachname fehlt.";
        }
        return (count($this->errMsg) === 0);
    }

    /**
     * Da keine Verarbeitung der Daten stattfindet, passiert hier nichts
     */
    protected function process() {
        return true;
    }
}

/**
 * Hauptaufruf - dies ist der Startpunkt des Normformular-Ablaufs.
 */
$form = new DemoTNormForm('./basetemplates', './basetemplates');
$form->normForm();