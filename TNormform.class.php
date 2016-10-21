<?php
/**
 * Einbinden der define-Angaben für die TNormform-Klasse
 */
require_once 'defines.inc.php';
/**
 * Einbinden der Klasse mit den statischen Hilfsfunktionen
 */
require_once 'Utilities.class.php';
/**
 * siehe defines.inc.php für gültigen Pfad
 */
require_once SMARTY_CLASS_PATH;


/**
 * Das objektorientierte und templatebasierte PHP-Normformular dient zur Erfassung, Verarbeitung und Validierung von Formulardaten.
 *
 * Das objektorientierte und templatebasierte PHP-Normformular stellt einen standardisierten Ablauf zur Erfassung, Validierung und
 * Verarbeitung von Formulareingaben dar. All diese Prozesse finden dabei in einer einzigen PHP-Datei statt. Zunächst wird beim
 * initialen Aufruf das Formular angezeigt - es können Daten eingegeben werden. Nach dem Absenden werden diese auf Korrektheit
 * überprüft. Traten fehlerhafte Eingaben auf, wird das Formular erneut vorgelegt und entsprechende Fehlermeldungen angezeigt.
 * Wurde das Formular korrekt ausgefüllt, wird die Ergbenisseite angezeigt. Das PHP-Normformular stellt weiterhin sicher, dass
 * Eingaben von BenutzerInnen überprüft und bereinigt werden, sodass Angriffe wie Cross-Site-Scripting ausgeschlossen werden.
 * Diese abstrakte Basisklasse enthält alle allgemeinen Methoden des Normformulars. Anwendungsspezifische Methoden (wie etwa für
 * Formularfelder oder die Generierung des Ergebnisses müssen in einer konkreten, abgeleiteten Klasse implementiert werden.
 * Diese Version des Normformulars verwendet Smarty-Templates, um HTML- von PHP-Code zu trennen.
 *
 * Der Hauptmethode @see normForm() legt einen Ablauf fest, der ein einfaches MVC-Pattern implementiert.
 * MVC: Model-View-Controller
 * M: @see process() verarbeitet die Daten und schreibt sie in die Datenbank oder ins Filesystem
 * V: @see show() zeigt das Ergebnis an, bzw. liest die Daten, die schon beim ersten Anzeigen einer Seite vorhanden sein müssen
 * C: @see isValidForm() Validiert die Daten und entscheidet, ob Daten verarbeitet werden könnnen, oder zur erneuten Bearbeitung dem Benutzer vorgelegt werden
 *
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2016
 */
abstract class TNormForm {
    /**
     * Abstrakte Methode zur Ausgabe des Formularfeldinhalts. Muss in der abgeleiteten Klasse implementiert werden.
     */
    abstract protected function prepareFormFields();

    /**
     * Abstrakte Methode zur Angabe des Smarty-Templates, das angezeigt werden soll. Muss in der abgeleiteten Klasse implementiert werden.
     */
    abstract protected function display();

    /**
     * Abstrakte Methode zur Validierung des Formulars. Muss in der abgeleiteten Klasse implementiert werden.
     * @return bool Gibt <pre>true</pre> zurück, wenn alle Kriterien erfüllt wurden, ansonsten <pre>false</pre>.
     */
    abstract protected function isValid();

    /**
     * Abstrakte Methode zur Verarbeitung der Eingaben. Muss in der abgeleiteten Klasse implementiert werden.
     */
    abstract protected function process();

    /**
     * @var array $errMsg Speichert alle bei der Validierung auftretenden Fehlermeldungen.
     */
    protected $errMsg;

    /**
     * @var array $statusMsg Speichert die Rückmeldung bei erfolgreicher Verarbeitung.
     */
    protected $statusMsg;

    /**
     * @var object $smarty Das Smarty-Objekt zur Arbeit mit dem Template-System.
     */
    protected $smarty;

    /**
     * Erzeugt ein neues Normform-Objekt
     *
     * löscht bzw. initialisiert das Array mit den Fehlermeldungen
     * löscht bzw. initialisiert die Statusmeldung
     * erzeugt ein neues Smarty-Objekt
     * Legt die Pfade zu den gespeicherten Templates und compilierten Templates fest
     */
    public function __construct($template_dir=SMARTY_TEMPLATE_DIR, $compile_dir=SMARTY_COMPILE_DIR)
    {
        $this->errMsg = array();
        $this->statusMsg = "";
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $template_dir;
        $this->smarty->compile_dir = $compile_dir;
    }

    /**
     * Die Hauptmethode des Normformulars. Hier befindet sich der Entscheidungsbaum, der überprüft, ob es sich um einen
     * initialen Aufruf oder um ein abgesendetes Formular handelt (mittels {@see isFormSubmission()}). Danach entweder das
     * Formular anzeigt (mittels {@see printForm()}) oder zunächst das Formular validiert ({@see isValidForm()}) und bei
     * Korrektheit das Ergebnis anzeigt ({@see processForm()}) oder sonst wieder das Formular vorlegt.
     * ({@see printForm()}). Treten bei der Verarbeitung in ({@see processForm() }) Fehler oder Rückgabewerte auf,
     * werden diese nochmals in {@see printForm()} angezeigt.
     * Wird in @see processForm() eine Weiterleitung header(Location: ... ) auf eine andere Seite eingeleitet wird das danach folgende
     * @see printForm() nicht erreicht. Umkehrschluss: Umleitungen haben in @see processForm() zu erfolgen.
     */
    public function normForm()
    {
        if ($this->isFormSubmission()) {
            if ($this->isValid()) {
                $this->process();
            }
        }
        $this->show();
    }

    /**
     * Überprüft, ob es sich beim aktuellen Aufruf der Seite um einen neuen, d.h. initialen Aufruf handelt, oder ob die
     * Seite durch das Absenden des Formulars erneut aufgerufen wurde. Ein initialer Aufruf erfolgt immer über die GET-
     * Übertragungsmethode, beim Absenden des Formulars wird POST verwendet.
     * @return bool Gibt <pre>true</pre> zurück, wenn es sich um ein abgesendets Formular handelt, sonst <pre>false</pre>.
     */
    protected function isFormSubmission()
    {
        return ($_SERVER["REQUEST_METHOD"] === "POST");
    }

    /**
     * Überprüft, ob der Inhalt eines Formularfelds beim Absenden leer war, d.h. nichts außer evtl. Whitespaces enthalten
     * hat. Existiert (aus welchem Grund auch immer) der Eintrag im $_POST-Array nicht, wird das Feld ebenfalls als leer angesehen.
     * @param string $index Der Name des zu überprüfenden Formularfelds <input name='$index' ... >.
     * @return bool Gibt <pre>true</pre> zurück, falls das Formularfeld leer war, sonst <pre>false</pre>.
     */
    protected function isEmptyPostField($index)
    {
        return (strlen(trim($_POST[$index])) === 0);
    }

    /**
     * Übernimmt die Ausgabe und Anzeige des Formularfeldes. Eventuell auftretende Fehlermeldungen werden an das
     * Template übergeben, in der Methode (@link prepareFormFields()) wird der Formularfeldinhalt vorbereitet und an
     * das Template übergeben. Das Template wird mit @see display() schließlich angezeigt.
     */
    protected function show()
    {
        $this->prepareFormFields();
        $this->smarty->assign("errorMessages", $this->errMsg);
        $this->smarty->assign("statusMessage", $this->statusMsg);
        $this->display();
    }

    /**
     * Überprüft, ob in $_POST bereits ein Wert für das angegebene Formularfeld existiert. Wenn ja, wird dieser Wert
     * gefiltert zurückgegeben, ansonsten ein leerer String. Diese Methode übernimmt somit das Befüllen bereits
     * ausfgefüllter Formularfelder nach einem erfolglosen Absenden. Mittels {@see sanitizeFilter()} werden schadhafte Eingaben
     * bereinigt, trim() dient zum Entfernen ungewünschter Leerzeichen am Anfang und am Ende.
     *
     * @param string $name Der Name des Formularfelds, das überprüft werden soll.
     * @return string Der vorausgefüllte Wert des Formularfelds oder ein leerer String (falls es zuvor noch leer war).
     */
    protected function autofillFormField($name)
    {
        return isset($_POST[$name]) ? Utilities::sanitizeFilter($_POST[$name]) : "";
    }

}