<?php
/**
 * @var bool DEBUG gibt an, ob Fehlermeldungen im Browser ausgegeben werden sollen (TRUE) oder mit error_log() (FALSE).
 */
define("DEBUG", TRUE); // Fehler im Browser ausgeben. Diese Zeile einkommentieren für eine Entwicklungsumgebung
//define("DEBUG",FALSE); // Fehler mit error_log() schreiben und auf errorpage.html umlenken. Diese Zeile einkommentieren für eine Produktivumgebung
/**
 * comment set_error_handler() to see only html_errors.
 * uncomment set_error_handler to see full debug_page.
 */
set_error_handler('my_error_handler');
// Alle ini_set() entfernen in einer Produktivumgebung
ini_set('error_reporting', 32767);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('track_errors', '1');
ini_set('html_errors', '1');

function my_error_handler($errno, $error, $file, $line, $context) {
    ob_start();
    var_dump($context);
    $out1 = ob_get_contents();
    ob_clean();
    // PHP Call Stack vom Ausgabepuffer in eine Zwischenvariable schreiben und leeren, sodass nichts mehr direkt in den Browser ausgegeben wird
    ob_start();
    debug_print_backtrace();
    $out2 = ob_get_contents();
    // Das Ganze noch etwas lesbarer formatieren
    $phpcallstack = str_replace('#', '<br>#', $out2);
    ob_clean();
    $debugpage = <<<ERROR
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DEBUG Error Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div>
    <!-- Styles not needed for IMAR, therefore not in css. So its easier to reuse IMAR -->
<style type="text/css" scoped>
    {literal}
    p {text-align:left;
       color: red;
       font: 20px arial, sans-serif;
       }
    {/literal}
</style>
        <p class='warning'><td><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Warning: $error in $file:$line</p>
    </div>
    <div>
        <p>Full Context</p>
        $out1
    </div>
    <div>
        <p>Full PHP Callstack</p>
        $phpcallstack
    </div>
</body>
</html>
ERROR;
    if (DEBUG) {
        print $debugpage;
        exit;
    }
    else {
        error_log($debugpage . $out1);
        header("Location: errorpage.html");
        exit;
    }
}