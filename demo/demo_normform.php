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
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2017
 */

/**
 * Konstanten für ein HTML Attribute <input name='vorname' id='vornamel' ...> --> <input name=EMAIL id=EMAIL ...> usw.
 * Diese Konstanten sind in der OO-TNormform später Klassenkonstanten, die mit const definiert werden
 * Daher sind sie auch in der prozeduralen Normform nicht ausgelagert.
 * Variablen, die in einem eigenen define.inc.php liegen, benötigen wir hier noch nicht,
 * wird es aber bei der OO-TNormform geben.
 */
define("VORNAME", "vorname");
define("NACHNAME", "nachname");
define("NACHRICHT", "nachricht");


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
function is_form_submission(): bool {
    return ($_SERVER["REQUEST_METHOD"] === "POST");
}

/**
 * Überprüft, ob der Inhalt eines Formularfelds beim Absenden leer war, d.h. nichts außer evtl. Whitespaces enthalten
 * hat. Existiert (aus welchem Grund auch immer) der Eintrag im $_POST-Array nicht, wird das Feld ebenfalls als leer angesehen.
 * @param string $name Der Name des zu überprüfenden Formularfelds.
 * @return bool Gibt <pre>true</pre> zurück, falls das Formularfeld leer war, sonst <pre>false</pre>.
 */
function is_empty_postfield($name): bool {
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
    print_errmsg();
    print_statusmsg();
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
function autofill_formfield(string $name): string {
    return isset($_POST[$name]) ? trim(sanitize_filter($_POST[$name])) : "";
}

/**
 * Diese Funktion filtert ungewünschte HTML-Tags aus einem String und gibt den gefilterten Text zurück.
 * @param string $str Der Eingabestring mit möglichen, zu filternden HTML-Inhalten.
 * @return string Der gefilterte String, der gefahrlos weiterverwendet werden kann.
 */
function sanitize_filter(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5);
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
        $errlines = "<div class=\"Error\">" . PHP_EOL;
        $errlines .= "<ul class=\"Error-list\">" . PHP_EOL;
        foreach ($errmsg as $e) {
            $errlines .= "<li class=\"Error-listItem\">$e</li>" . PHP_EOL;
        }
        $errlines .= "</ul>" . PHP_EOL;
        $errlines .= "</div>" . PHP_EOL;
    }
}

function print_statusmsg() {
    global $statusmsg;
    global $statuslines;
    if (isset($statusmsg)) {
        $statuslines = "<div class=\"Status\">" . PHP_EOL;
        $statuslines .= "<p class=\"Status-message\"><i class=\"fa fa-check\"></i>$statusmsg</p>" . PHP_EOL;
        $statuslines .= "</div>" . PHP_EOL;
    }
}


/**
 * Erzeugt die HTML-Seite und zeigt sie an (Später werden hier Smarty-Templates eingesetzt)
 */
function display() {
    // Als Objekteigenschaften in der OO-TNormform über $this->errmsg usw. von überall ansprechbar. Man benötigt in OO kein global.
    global $errmsg;
    global $result;
    global $errlines;
    global $statuslines;
    $resultlines = '';
    // Diese Anweisung verschwindet später im Smarty-Template
    $script_name = $_SERVER["SCRIPT_NAME"];
    // Die folgenden Werte werden später mit $smarty->assign() an das Template weitergegeben.
    $vorname_key = VORNAME;
    $nachname_key = NACHNAME;
    $nachricht_key = NACHRICHT;
    // Falls das Formular im Gutfall erneut angezeigt werden soll, werden die zuvor eingegebenen Werte nicht mehr angezeigt und das Formular geleert
    if (isset($errmsg) && count($errmsg) !== 0) {
        $vorname_value = autofill_formfield(VORNAME);
        $nachname_value = autofill_formfield(NACHNAME);
        $nachricht_value = autofill_formfield(NACHRICHT);
    }
    else {
        $vorname_value = null;
        $nachname_value = null;
        $nachricht_value = null;
    }
    // Das Ergebnis von $this->process wird hier formatiert. Im wesentlichen sind es die Keys und Values des POST-Arrays.
    if (isset($result)) {
        $resultlines = "<table class=\"Table u-tableW100\">" . PHP_EOL;
        $resultlines .= "<colgroup span=\"2\" class=\"u-tableW50\"></colgroup>" . PHP_EOL;
        $resultlines .= "<thead>" . PHP_EOL;
        $resultlines .= "<tr class=\"Table-row\">" . PHP_EOL;
        $resultlines .= "<th class=\"Table-header\">Key</th>" . PHP_EOL;
        $resultlines .= "<th class=\"Table-header\">Value</th>" . PHP_EOL;
        $resultlines .= "</tr>" . PHP_EOL;
        $resultlines .= "</thead>" . PHP_EOL;
        $resultlines .= "<tbody>" . PHP_EOL;
        foreach ($result as $key => $value) {
            $resultlines .= "<tr class=\"Table-row\">" . PHP_EOL;
            $resultlines .= "<td class=\"Table-data\">$key</td>" . PHP_EOL;
            $resultlines .= "<td class=\"Table-data\">" . nl2br(sanitize_filter($value)) . "</td>" . PHP_EOL;
            $resultlines .= "</tr>" . PHP_EOL;
        }
        $resultlines .= "</tbody>" . PHP_EOL;
        $resultlines .= "</table>" . PHP_EOL;
    }

    /**
     * Hier wird HEREDOC-Syntax verwendet, um Strings zu bilden
     */

    $page = <<<PAGE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo Normform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="Site">
   <main class="Site-content">
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Normform Demo</h2>
            $errlines
            $statuslines
            <form action="$script_name" method="post">
                <div class="Grid Grid--gutters">
                    <div class="InputCombo Grid-full">
                        <label for="$vorname_key" class="InputCombo-label">Vorname:</label>
                        <input type="text" id="$vorname_key" name="$vorname_key" value="$vorname_value" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="$nachname_key" class="InputCombo-label">Nachname:</label>
                        <input type="text" id="$nachname_key" name="$nachname_key" value="$nachname_value" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="$nachricht_key" class="InputCombo-label">Nachricht:</label>
                        <textarea name="$nachricht_key" id="$nachricht_key" class="InputCombo-field">$nachricht_value</textarea>
                    </div>
                    <div class="Grid-full">
                        <button type="submit" class="Button">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Result in \$_POST</h2>
            $resultlines
        </div>
    </section>
</main> 
<footer class="Site-footer">
    <div class="Footer Footer--small">
        <p class="Footer-credits">Created and maintained by <a href="mailto:martin.harrer@fh-hagenberg.at">Martin Harrer</a> and <a href="mailto:wolfgang.hochleitner@fh-hagenberg.at">Wolfgang Hochleitner</a>.</p>
        <p class="Footer-version"><i class="fa fa-file-text-o" aria-hidden="true"></i>Normform Demo Version 2017</p>
        <p class="Footer-credits"><i class="fa fa-github" aria-hidden="true"></i><a href="https://github.com/Digital-Media/normform">GitHub</a></p>
    </div>
</footer>
</body>
</html>
PAGE;
    // Ausgabe der Seite
    echo $page;
}

/**
 * Überprüft, ob das Formularfeld korrekt ausgefüllt wurde. Die Kriterien werden in dieser Funktion anhand verschiedener
 * if-Bedingungen selbst angegeben. Schlägt ein Kriterium fehl, wird ein Eintrag in das globale Array <pre>$errMsg</pre>
 * geschrieben.
 * Passende Funktionen für spezielle Eingabefelder finden sich in utilities.inc.php
 *
 * @global array $errMsg Beinhaltet mögliche Fehlermeldungen, die bei der Validierung aufgetreten sind und später
 * mit @see print_errmsg() von normform.inc.php ausgegeben werden.
 * @return bool Gibt <pre>true</pre> zurück, wenn alle Kriterien erfüllt wurden, ansonsten <pre>false</pre>.
 */
function is_valid_form(): bool {
    global $errmsg;

    if (is_empty_postfield(VORNAME)) {
        $errmsg[VORNAME] = "Vorname fehlt.";
    }
    if (is_empty_postfield(NACHNAME)) {
        $errmsg[NACHNAME] = "Nachname fehlt.";
    }
    return !isset($errmsg);
}

/**
 * Verabeitet die Dateun und gibt die Ergebnisseite aus.
 * In diesem Grundgerüst wird lediglich der Inhalt der Variable <pre>$_POST</pre> ausgegeben.
 * Hier wird in späteren Übungen sinnvollerer Inhalt stehen.
 */
function process_form() {
    //global $statusmsg;
    global $result;
    global $statusmsg;
    $result = $_POST;

    $statusmsg = "Verarbeitung erfolgreich!";
}

/**
 * Hauptaufruf - dies ist der Startpunkt des Normformular-Ablaufs.
 */
normform();
