<?php

require "NormFormExample.php";
require "../vendor/autoload.php";

use Fhooe\NormForm\Parameter\PostParameter;
use Fhooe\NormForm\View\View;

// --- This is the main call of the norm form process

/* First, define a View object. It will usually be of type FORM. You'll usually need to supply parameters for the template.
 * These parameters are used for setting name and id parameters (and "for" in the label) in the input element as well as
 * its value (see PostParameter class for details).
 */

//echo "hallo";

$view = new View("normFormExample.tpl", [
    new PostParameter(NormFormExample::FIRST_NAME),
    new PostParameter(NormFormExample::LAST_NAME),
    new PostParameter(NormFormExample::MESSAGE),
]);



/* Create a new instance of your class, supply the view object and (optionally) the paths for the template engine.
 * Then call normForm() to get the party started!
 */
$form = new NormFormExample($view);
$form->normForm();

//phpinfo();


