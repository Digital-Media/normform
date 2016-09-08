<?php
class Utilities {
   /**
    * Diese Klasse bietet nur statische (static) Hilfsfunktionen, die von überall (public) aufgerufen werden können
    * Usage: Utilities::method($param, ...);
    *
    * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
    * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
    * @package hm2, dba
    * @version 2016
    */

    /**
     * Umleitung auf eine Seite, die im gleichen Verzeichnis gespeichert ist
     * Gesteuert wird die Funktion über das vordefinierte Array REDIRECT_PAGES in defines.inc.php von IMAR oder Onlineshop mit Seiten, die durch ein Login geschützt werden sollen
     * Es wird $_SERVER['SCRIPT_NAME'] verwendet, weil es im Gegensatz zu $_SERVER['PHP_SELF'] an die URL angehängte GET-Parameter nicht enthält (Forced Browsing verhindern)
     * Usage: Utilities::redirectTo($page);
     *
     * @var string $page ist optional und gibt die Seite an, auf die umgelenkt werden soll.
     *                   Für die Standardabläufe für die geschützen Seiten ist $page leer.
     */
    public static function redirectTo($page = null) {
        $redirect=FALSE;
        // Falls keine spezielle Seite in $page übergeben wurde, wird das aufrufende Script verwendet
        if (!isset($page)) {
            $page = basename($_SERVER['SCRIPT_NAME']);
        }
        // Entscheiden, ob eine Umlenkung notwendig ist
        switch ($page) {
            case 'logout.php':
                // Nach dem Ausloggen wird die Startseite angezeigt
                $page = INDEX;
                $redirect=true;
                break;
            case 'login.php':
                if (isset($_SESSION[ISLOGGEDIN]) && strcmp($_SESSION[ISLOGGEDIN], sha1( $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $_SESSION['iduser'])) === 0) {
                    if (isset($_SESSION['redirect_url'])) {
                        // User wurde von einer geschützten Seite auf Login umgelenkt
                        $page = $_SESSION['redirect_url'];
                        //unset ($_SESSION['redirect_url']);
                    } else {
                        // User ist bereits eingeloggt und versucht das ein zweites Mal: Umlenkung auf Startseite.
                        $page = INDEX;
                    }
                    $redirect=true;
                } elseif (basename($_SERVER['SCRIPT_NAME']) === REGISTER) {
                    $page = LOGIN;
                    $redirect = true;
                }
                break;
            // Seite ist unter den durch Login geschützten Seiten
            case in_array($page, REDIRECT_PAGES ):
                if (!isset($_SESSION[ISLOGGEDIN]) || strcmp($_SESSION[ISLOGGEDIN], sha1( $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . $_SESSION['iduser'])) !== 0) {
                    // User ist noch nicht eingeloggt, daher zuerst zur Login-Seite und merken von welcher Seite man gekommen ist
                    $_SESSION['redirect_url'] = basename($_SERVER['SCRIPT_NAME']);
                    $page = LOGIN;
                    $redirect = true;
                } else {
                    if (!(strcmp(basename($_SERVER['SCRIPT_NAME']), $page) === 0)) {
                        // User ist eingeloggt und wird auf eine weitere geschützte Seite weitergeleitet (z.B. von mycart.php auf checkout.php)
                        $redirect = true;
                    } else {
                        // Jemand leitet ein Script auf sich selbst um, wir wollen aber keine Endlosschleife produzieren
                        $redirect = false;
                    }
                }
                    break;
            default:
                // Keine Umlenkung notwendig oder bereits eingeloggt
                $redirect=FALSE;
        }
        if ($redirect) {
            if (isset($_SERVER["HTTPS"]) && strcmp($_SERVER["HTTPS"], "on") === 0) {
                $schema="https";
            } else {
                $schema="http";
            }
            $host  = $_SERVER['SERVER_NAME'];
            $port = $_SERVER['SERVER_PORT'];
            $uri   = trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
            $location = "Location: $schema://$host:$port/$uri/$page";
            // Umlenkung wird hier schon auf https durchgeführt, damit es nicht zu einer zweiten Umlenkung in session.inc.php kommt
            header("$location");
            exit;
        }
    }

    /**
     * Diese Methode filtert ungewünschte HTML-Tags aus einem String und gibt den gefilterten Text zurück.
     * Usage: Utilities::sanitizeFilter()
     *
     * @see TNormform::autofillFormField()
     *
     * @param string $str Der Eingabestring mit möglichen, zu filternden HTML-Inhalten.
     *
     * @return string Der gefilterte String, der gefahrlos weiterverwendet werden kann.
     */
    public static function sanitizeFilter($str) {
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5 );
    }

    /**
     * Validiert einen String, ob er dem gegebenen Email-Pattern entspricht
     * Mehr Information gibt es auf http://www.regular-expressions.info/email.html
     * Ähnliches kann mit filter_var($email, FILTER_VALIDATE_EMAIL) erreicht werden
     * Testen kann man Reguläre Ausdrücke (engl. regular expressions kurz Regex) auf @link https://regex101.com/ speziell für php @link http://www.phpliveregex.com/
     * Usage: Utilities::isEmail($string);
     *
     * @param string $email
     *
     * @return bool TRUE falls $email dem email-Pattern entspricht. FALSE falls es keine Entsprechung gibt
     */
    public static function isEmail($string) {
        // $email_pattern = "/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/"; // easy pattern
        $email_pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/"; // more complicate pattern
        if (preg_match($email_pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Prüft, ob ein Eingabestring einer Telefonnummer entspricht
     * Beispiel für Telefonnummer, die dem Pattern entspricht: +43 732 1234-1234
     * Usage: Utilities::isPhone($string);
     *
     * $phone_pattern enthält einen möglichen regulären Ausdruck. Alternativen gibt es im Web viele zu finden.
     * Wenn jemand einen besseren Vorschlag hat, verwende ich ihn gerne hier.
     * Telefonnummern prüfen ist eine schwierige Sache, vor allem, wenn man internationale Standards einhalten will
     * und trotzdem länderspezifische Eigenheiten berücksichtigen will.
     * Es gibt von Google eine eigene Library: @link https://github.com/googlei18n/libphonenumber/blob/master/README.md
     * Testen kann man Reguläre Ausdrücke (engl. regular expressions kurz Regex) auf @link https://regex101.com/ speziell für php @link http://www.phpliveregex.com/
     *
     * @param string $string String, der eine Telefonnummer enthalten soll
     *
     * @return bool true falls der String dem gegebenen Pattern entspricht. Ansonsten false
     */
    public static function isPhone($string) {
        $phone_pattern= "/^(?!(?:\d*-){5,})(?!(?:\d* ){5,})\+?[\d- ]+$/";
        if (preg_match($phone_pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Prüft ob eine übergebener String einen Preis beinhaltet.
     * Keine Nullen am Anfang, einen Beistrich als Kommastelle, 2 Nachkommastellen
     * Für das Speichern in einer Datenbank ist der Beistrich durch einen Punkt zu ersetzen.
     * Datenbanken speichern im Format, das im angloamerikanischen Sprachraum gültig ist. Dort ist der Punkt das Trennzeichen für die Nachkommastellen.
     *
     * @param $string Der String, der geprüft wird, ob er ein gültiger Preis ist
     * @return bool TRUE, wenn der Preis ein gültiges Format hat, ansonsten FALSE
     */
    public static function isPrice($string) {
        $price_pattern="/(^[1-9])([0-9]*)(,[[:digit:]]{2})/";
        if (preg_match($price_pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Prüft einen String, ob er eine positive Ganzzahl ungleich 0 enthält
     * Kann auch mit filter_var($string, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" =>  100)))
     * durchgeführt werden, das zusätzlich eine Bereichseinschränkung zulässt und alle Integer abdeckt
     * Usage: Utilities::isInt($string);
     *
     * @param $string
     * @return bool
     */
    public static function isInt($string) {
        $int_pattern = "/(^[1-9]\d*$|0)/";
        if (!preg_match($int_pattern, $string)) {
            return false;
        } else {
             return true;
        }
    }

    /**
     * Führt ein Withelisting für die angegebenen Zeichen durch und prüft auf Mindest- und Maximallänge
     * Blank ist ausgeschlossen. Es wird also erzwunden, dass nur ein Suchbegriff eingegeben werden kann.
     * Das macht Sinn, weil LIKE im DAB-Übungsbeispiel eingesetzt wird und keine Volltextsuche.
     * Übungsbeispiel für LIKE!!! In der Praxis würde man wohl auf Lucene setzen oder die eigene Seite von Google durchsuchen lassen
     *
     * @param string $string Zu prüfender String
     * @param int $min Minimale Länge des Strings. Default = 0
     * @param int $max Maximale Länge des Strings. Default = 50
     * @return bool
     */
    public static function isSingleWord($string, $min=0, $max=50) {
        $string_pattern = '/^[a-zäöüA-ZÄÖÜ-]{'. $min . ',' . $max .'}$/i';
        if (preg_match($string_pattern, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Überprüft ob ein String eine Mindestlänge hat, und begrenzt die Gesamtlänge
     * Es werden nur die Zeichen, die im Regex-Pattern definiert sind zugelassen
     * Usage: Utilities::isPassword($string);
     *
     * @param string $string Übergebener Passwortstring
     *
     * @return bool TRUE wenn der String dem Pattern entspricht, FALSE, wenn das nicht der Fall ist.
     */
    public static function isPassword($string, $min, $max) {
        // return true if regular expression is matched
        // Check password and match against the confirmed password:
        $regex='/^[a-zA-Z0-9_]{' . $min . ',' . $max . '}$/';
        if (preg_match($regex, $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Überprüft, ob ein String leer ist, nachdem führende und nachfolgende Leerzeichen/Whitespaces entfernt wurden
     * Usage: Utilities::isEmptyString($string);
     *
     * @param string $string Beliebiger String
     *
     * @return bool TRUE, falls der String nach Entfernung von Leerzeichen/Whitespaces nichts mehr enthält. Ansonsten FALSE
     */
    public static function isEmptyString($string) {
        if (strlen(trim($string)) === 0) {
            return true;
        } else {
            return false;
        }
    }

    // TODO Brauchen wir diese Funktion? Zeichensätze richtig stellen und Entities reichen auch!?
    /**
     * Entfernt Umlaute aus einem Text
     * Usage: Utilities::replaceUmlauts($string);
     *
     * @param string $string Beliebieger Text
     * @return string Übergebener Text ohne Umlaute
     */
    public static function replaceUmlauts($string) {
        // Windows actually delivers e.g. an "ä", whereas MacOS does a diaeresis of a and two dots, which is seen as e.g. \x61\xcc\x88
        $charReplace = array('ä' => 'ae', "\x61\xcc\x88" => 'ae', 'Ä' => 'Ae', "\x41\xcc\x88" => 'Ae', 'ö' => 'oe', "\x6f\xcc\x88" => 'oe', 'Ö' => 'Oe', "\x4f\xcc\x88" => 'Oe', 'ü' => 'ue', "\x75\xcc\x88" => 'ue', 'Ü' => 'Ue', "\x55\xcc\x88" => 'Ue', 'ß' => 'ss', ' ' => '_');
        return strtr($string, $charReplace);
    }

    /**
     * Verschlüsselt das Passwort mit dem Algorithmus PASSWORD_BCRYPT, das derzeit Default ist.
     * Damit das Login auch nach einer Änderung des Default-Algorithmus weiter richtig mit password_verify() zusammenarbeitet, ist der Algorithmus angegeben.
     * Usage::encryptPWD($string);
     *
     * @param string $string unverschlüsseltes Passwort
     *
     * @return bool|string Das verschlüsselte Passwort
     */
    public static function encryptPWD($string) {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    /**
     * Prüft ein unverschlüsseltes Passwort mit dem Algorithmus PASSWORD_BCRYPT, ob er mit dem gehashten Passwort übereinsteimmt.
     * Damit das Login auch nach einer Änderung des Default-Algorithmus weiter richtig mit password_hash() zusammenarbeitet, ist der Algorithmus angegeben.
     * Usage::encryptPWD($string);
     *
     * @param string $string unverschlüsseltes Passwort
     * @param string $hash verschlüsseltes Passwort, Passworthash
     *
     * @return bool TRUE, wenn das Passwort dem Hash entspricht. Andernfalls FALSE
     */
    public static function proofPWD($string, $hash) {
        return password_verify($string, $hash);
    }
}