<?php

/**
 * Diese Funktion filtert ungewünschte HTML-Tags aus einem String und gibt den gefilterten Text zurück.
 * @param string $str Der Eingabestring mit möglichen, zu filternden HTML-Inhalten.
 * @return string Der gefilterte String, der gefahrlos weiterverwendet werden kann.
 */
function sanitize_filter($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5);
}

/**
 * Check email address:
 * More information can be found on http://www.regular-expressions.info/email.html
 * easy $email_pattern = "/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/";
 * only some existing top-level-domains are validated, has to be updated if a new one is registered
 *
 * @param $string
 * @return bool true if regular expression is matched
 */
function is_email($string) {

    $email_pattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i";
    if (preg_match($email_pattern, $string)) {
        return true;
    } else {
        return false;
    }
}