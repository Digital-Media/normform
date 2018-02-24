<?php

require "../vendor/autoload.php";

use Example\NormFormDemo;
use Fhooe\NormForm\Parameter\PostParameter;
use Fhooe\NormForm\View\SmartyView;
use Fhooe\NormForm\View\TwigView;
use Fhooe\NormForm\View\View;


/*
 * define a global constant
 */
define('DEBUG', true);
/*
 * activate debugging with HTML errors to display in Browser
 */
if (DEBUG) {
    echo "<br>WARNING: Debugging is enabled. Set DEBUG to false for production use in " . __FILE__;
    echo "<br>Connect via SSH and send tail -f /var/log/apache2/error.log to see errors not displayed in Browser";
    echo " (HTTP Status 5xx, white screens, ...)<br><br>";
    error_reporting(E_ALL);
    ini_set('html_errors', 1);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
}

/*$view = new SmartyView("normFormDemo.tpl", [
    new PostParameter(NormFormDemo::FIRST_NAME),
    new PostParameter(NormFormDemo::LAST_NAME),
    new PostParameter(NormFormDemo::MESSAGE),
]);*/

$view = new TwigView("normFormDemo.html.twig", [
    new PostParameter(NormFormDemo::FIRST_NAME),
    new PostParameter(NormFormDemo::LAST_NAME),
    new PostParameter(NormFormDemo::MESSAGE),
]);

$form = new NormFormDemo($view);
$form->normForm();
