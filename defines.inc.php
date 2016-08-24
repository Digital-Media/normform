<?php
/**
 * In define.inc.php werden Konstanten festgelegt, die für auf TNormform basierende Webapplikationen
 * gültig sind (superglobal, $GLOBALS)
 */

/**
 * @var bool DEBUG gibt an, ob Fehlermeldungen im Browser ausgegeben werden sollen (TRUE) oder mit error_log() (FALSE).
 */
//define("DEBUG",TRUE); // Fehler im Browser ausgeben
define("DEBUG",FALSE); // Fehler mit error_log() schreiben

/*
 * Smarty Constants
 * Hier werden die Pfade für Smarty festgelegt, damit man im Code installationsunabhängig wird.
 * @var string SMARTY_CLASS_PATH hängt von der Installation ab. Wenn Pfad in php.ini gilt Smarty.class.php allein.
 *                               Ansonsten gilt der auskommentierte Eintrag darüber, wenn man Smarty direkt im Document Root entpackt hat
 *
 * @var string SMARTY_CLASS_PATH Pfad zur Klasse Smarty.class.php
 * @var string TEMPLATE Pfad zu den Smarty Templates
 * @var string TEMPLATE_C Pfad zu den compilierten Smarty Templates
 */
//define("SMARTY_CLASS_PATH","../smarty/libs/Smarty.class.php"); // Pfad ist nicht in php.ini angegeben und liegt innerhalb von Document Root (relativ zu TNormform.class.php)
define("SMARTY_CLASS_PATH","Smarty.class.php"); // Pfad ist in php.ini angegeben
define("SMARTY_TEMPLATE_DIR","templates");
define("SMARTY_COMPILE_DIR","templates_c");