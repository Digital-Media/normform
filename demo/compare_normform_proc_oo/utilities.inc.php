<?php



/**
 * Check email address:
 * More information can be found on http://www.regular-expressions.info/email.html
 * easy $email_pattern = "/^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$/";
 * only some existing top-level-domains are validated, has to be updated if a new one is registered
 *
 * @param $string
 * @return bool true if regular expression is matched
 */
function is_email(string $string): bool {
    $email_pattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i";
    if (preg_match($email_pattern, $string)) {
        return true;
    }
    else {
        return false;
    }
}
