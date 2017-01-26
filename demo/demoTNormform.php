<?php
/*
 * Das objektorientierte und templatebasierte PHP-Normformular dient zur Erfassung, Verarbeitung und Validierung von
 * Formulardaten.
 *
 * Diese konkrete Klasse erweitert die abstrakte Basisklasse TNormform, die grundlegende Abläufe festlegt, die bei allen Webseiten, die darauf beruhen,
 * gleich abgehandelt werden.
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2017
 */
require("../TNormform.class.php");

class DemoTNormForm extends TNormForm {
    /**
     *  Konstanten für ein HTML Attribute <input name='vorname' id='vornamel' ...> --> <input name=EMAIL id=EMAIL ...> usw.
     */
    const VORNAME = "vorname";
    const NACHNAME = "nachname";
    const NACHRICHT = "nachricht";

    /**
     * Zeigt im Fehlerfall vom Nutzer bereits eingegebene Werte wieder an.
     * Falls von einem vorigen Absenden noch Werte vorhanden sind, werden diese über die Funktion {@see autofillFormField()} wieder eingefügt,
     * Die Namen der Input-Felder <input name=EMAIL> usw. werden zugewiesen.
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
     * Diese Methode gibt das Template aus.
     * Sie muss implementiert werden, weil sie in TNormform eine abstracte Klasse ist.
     */
    protected function display() {
        $this->smarty->display('demoMain.tpl');
    }

    /**
     * Überprüft, ob das Formularfeld korrekt ausgefüllt wurde. Die Kriterien werden in dieser Funktion anhand verschiedener
     * if-Bedingungen selbst angegeben. Schlägt ein Kriterium fehl, wird ein Eintrag in die Eigenschaft <pre>$errMsg</pre>
     * geschrieben.
     *
     * Passende Funktionen für spezielle Eingabefelder finde sich in der Klasse Utilities.class.php.
     *
     * @return bool Gibt <pre>true</pre> zurück, wenn alle Kriterien erfüllt wurden, ansonsten <pre>false</pre>.
     */
    protected function isValid(): bool {
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
$form = new DemoTNormForm('../basetemplates', '../basetemplates');
$form->normForm();