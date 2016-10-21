<?php
/**
 * Das PHP-Normformular dient zur Erfassung, Verarbeitung und Validierung von Formulardaten.
 *
 * Das PHP-Normformular stellt einen standardisierten Ablauf zur Erfassung, Valisierung und Verarbeitung von Formulareingaben dar.
 * All diese Prozesse findet dabei in einer einzigen PHP-Datei statt. Zunächst wird beim initialen Aufruf das Formular angezeigt -
 * es können Daten eingegeben werden. Nach dem Absenden werden diese auf Korrektheit überprüft. Traten fehlerhafte Eingaben auf,
 * wird das Formular erneut vorgelegt und entsprechende Fehlermeldungen angezeigt. Wurde das Formular korrekt ausgefüllt, wird die
 * Ergbenisseite angezeigt. Das PHP-Normformular stellt weiterhin sicher, dass Eingaben von BenutzerInnen überprüft und bereinigt
 * werden, sodass Angriffe wie Cross-Site-Scripting ausgeschlossen werden.
 *
 * Die Namensgebung bei Funktionen entspricht den Konventionen beim prozeduralen Programmieren mit PHP
 * In der OO-TNormform werden die gleichwertigen Methoden daher anders heißen, weil sie sich an OO-Konventionen orientieren
 *
 * Der Hauptaufruf @see normform() legt einen Ablauf fest, der ein einfaches MVC-Pattern implementiert.
 * MVC: Model-View-Controller
 * M: @see process_form() verarbeitet die Daten und schreibt sie in die Datenbank oder ins Filesystem
 * V: @see show_form() zeigt das Ergebnis an, bzw. liest die Daten, die schon beim ersten Anzeigen einer Seite vorhanden sein müssen
 * C: @see is_valid_form() validiert die Daten und entscheidet, ob Daten verarbeitet werden könnnen, oder zur erneuten Bearbeitung dem Benutzer vorgelegt werden
 *
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2016
 */

/**
 * Einfinden von Definitionen über ein eigenes File defines.inc.php hier noch nicht notwendig, weil wir Debuggen erst später einführen
 * und Smarty-Templates ebenfalls erst später eingeführt werden und daher auch keine Pfadangaben dafür notwendig sind
 */

/**
 * Einbinden von Hilfsfunktionen
 */
require_once 'utilities.inc.php';

/**
 * Die Hauptfunktion des Normformulars. Hier befindet sich der Entscheidungsbaum, der überprüft, ob es sich um einen
 * initialen Aufruf oder um ein abgesendetes Formular handelt (mittels {@see is_form_submission()}) und entweder das
 * Formular anzeigt (@see show_form()}) oder zunächst das Formular validiert {@see is_valid_form()} und bei
 * Korrektheit das Ergebnis anzeigt {@see show_form()} oder sonst wieder das Formular vorlegt
 * ({@see show_form()}).
 */
function normform() {
    if (is_form_submission()) {
        if (is_valid_form()) {
            process_form();
        }
    }
    show_form();
}

/**
 * Überprüft, ob es sich beim aktuellen Aufruf der Seite um einen neuen, d.h. initialen Aufruf handelt, oder ob die
 * Seite durch das Absenden des Formulars erneut aufgerufen wurde. Ein initialer Aufruf erfolgt immer über die GET-
 * Übertragungsmethode, beim Absenden des Formulars wird POST verwendet.
 * @return bool Gibt <pre>true</pre> zurück, wenn es sich um ein abgesendets Formular handelt, sonst <pre>false</pre>.
 */
function is_form_submission() {
    return ($_SERVER["REQUEST_METHOD"] === "POST");
}

/**
 * Überprüft, ob der Inhalt eines Formularfelds beim Absenden leer war, d.h. nichts außer evtl. Whitespaces enthalten
 * hat. Existiert (aus welchem Grund auch immer) der Eintrag im $_POST-Array nicht, wird das Feld ebenfalls als leer angesehen.
 * @param string $name Der Name des zu überprüfenden Formularfelds.
 * @return bool Gibt <pre>true</pre> zurück, falls das Formularfeld leer war, sonst <pre>false</pre>.
 */
function is_empty_postfield($name) {
    if (isset($_POST[$name])) {
        return (strlen(trim($_POST[$name])) === 0);
    }
    return true;
}

/**
 * Übernimmt die Ausgabe und Anzeige des gesamten Formularfeldes. Hier werden aufgetretene
 * Fehlermeldungen mittels {@see print_errmsg()} ausgegeben.
 */
function show_form() {
    // Diesen Aufruf gibt es in der OO-Normform nicht mehr, weil diese Funktionalität von den Smarty-Templates umgesetzt wird
    print_errmsg();
    // wie OO-TNormform
    prepare_formfields();
    // Eine Übergabe von Variablen an Smarty ist noch nicht notwendig, weil wir Smarty-Templates erst später einführen
    // display wird später durch die gleichnamige Smarty-Methode $smarty->dislplay(irgendeinTemplate.tpl) ersetzt
    display();
}

/**
 * Überprüft, ob in $_POST bereits ein Wert für das angegebenen Formularfeld existiert. Wenn ja, wird dieser Wert
 * gefiltert zurückgegeben, ansonsten ein leerer String. Diese Funktion übernimmt somit das Befüllen bereits
 * ausfgefüllter Formularfelder nach einem erfolglosen Absenden. Mittels {@see sanitize_filter()} werden schadhafte Eingaben
 * bereinigt (XSS-Angriffe verhindern), trim() dient zum Entfernen ungewünschter Leerzeichen am Anfang und am Ende.
 * @param string $name Der Name des Formularfelds, das überprüft werden soll.
 * @return string Der vorausgefüllte Wert des Formularfelds oder ein leerer String (falls es zuvor noch leer war).
 */
function autofill_formfield($name) {
    return isset($_POST[$name]) ? trim(sanitize_filter($_POST[$name])) : "";
}

/**
 * Gibt alle Fehlermeldungen aus, die beim Validieren des Formulars aufgetreten sind. Die Abarbeitung des Arrays übernimmt in der OO-TNormform Smarty im Template
 * PHP_EOL fügt immer die plattformspezifischen EndOfLine-Zeichen ein. Es wird auf Linux/Unix ein Linux/Unix-Zeilenumbruch erzeugt. Unter Windows ein Windows-Zeilenumbruch
 * Damit ist der erzeugte HTML-Seitenquelltext leichter lesbar, weil auch dort meherere Zeilen erzeugt werden.
 * In der OO-TNormform wird diese Funktionalität im Template abgewickelt
 */
function print_errmsg() {
    global $errmsg;
    global $errlines;
    if (isset($errmsg)) {
        $errlines = "<p>Bitte folgende Fehler korrigieren:</p>" . PHP_EOL;
        $errlines .= "<ul>" . PHP_EOL;
        foreach ($errmsg as $e) {
            $errlines .= "<li>$e</li>" . PHP_EOL;
        }
        $errlines .= "</ul>" . PHP_EOL;
    }
}