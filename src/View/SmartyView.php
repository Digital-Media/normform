<?php

namespace Fhooe\NormForm\View;

use Fhooe\NormForm\Parameter\GenericParameter;
use Fhooe\NormForm\Parameter\PostParameter;
use Smarty;

/**
 * A view object that uses the Smarty template engine to render its output.
 *
 * This subclass of AbstractView initializes the Smarty template engine and passes the stored parameters to it. Smarty
 * is then used to render and display the form as specified in the main template.
 *
 * @package Fhooe\NormForm\View
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.0.0
 */
class SmartyView extends AbstractView
{
    /** @var Smarty $smarty Holds the reference to the Smarty template engine. */
    private $smarty;

    /**
     * Creates a new view object that uses the Smarty template engine to render its output.
     * @param string $templateName The name of the main template file (extension is usually .tpl).
     * @param string $templateDirectory The directory where the template files are located (default is "templates").
     * @param string $templateCacheDirectory The directory where the cached/compiled templates should be stored (default
     * is "templates_c").
     * @param array $params The parameters used to populate the form.
     */
    public function __construct(
        string $templateName,
        string $templateDirectory = "templates",
        string $templateCacheDirectory = "templates_c",
        array $params = []
    ) {
        parent::__construct($templateName, $templateDirectory, $templateCacheDirectory, $params);

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($this->templateDirectory);
        $this->smarty->setCompileDir($this->templateCacheDirectory);
    }

    /**
     * Displays the current view. Iterates over all the parameters stored and assignes them to the smarty object. Smarty
     * then displays the main template file.
     */
    public function display()
    {
        foreach ($this->params as $param) {
            if ($param instanceof PostParameter) {
                $this->smarty->assign($param->getName(), $param);
            } else {
                if ($param instanceof GenericParameter) {
                    $this->smarty->assign($param->getName(), $param->getValue());
                }
            }
        }
        $this->smarty->display($this->templateName);
    }
}
