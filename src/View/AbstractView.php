<?php

namespace Fhooe\NormForm\View;

use Fhooe\NormForm\Parameter\ParameterInterface;

/**
 * Encapsulates data for displaying a form or result of a form submission.
 *
 * This abstract class contains the common code for all views. It managages the parameters that are involved in the form
 * (which should implement ParameterInterface) and allows for a general PHP redirect. Displaying the form or the results
 * itself is handled in special subclasses. These usually make use of a sepcific templating engine, which is why
 * display() has to be implemented in the subclass. This method will pass on the parameters stored in the view to the
 * template engine and render/display the form.
 *
 * @package Fhooe\NormForm\View
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.0.0
 */
abstract class AbstractView
{
    /** @var string $templateName The name of the view (the template file that is to be rendered). */
    protected $templateName;

    /** @var string $templateDirectory The relative path to the directory where the template files are stored.*/
    protected $templateDirectory;

    /** @var string $templateCacheDirectory The relative path where cached/compiled templates are to be stored. */
    protected $templateCacheDirectory;

    /** @var array $params An array of parameters used for display. */
    protected $params;

    /**
     * Creates a new view with the main template to be displayed, the path to the template and compiled templates
     * directory as well as parameters of the form.
     * @param string $templateName The name of the template to be displayed.
     * @param string $templateDirectory The path where the template file is located (default is "templates").
     * @param string $templateCacheDirectory The path where cached template files are to be stored (default is
     * "templates_c").
     * @param array $params The parameters used when displaying the view.
     */
    public function __construct(
        string $templateName,
        string $templateDirectory = "templates",
        string $templateCacheDirectory = "templates_c",
        array $params = []
    ) {
        $this->templateName = $templateName;
        $this->templateDirectory = $templateDirectory;
        $this->templateCacheDirectory = $templateCacheDirectory;
        $this->params = $params;
    }

    /**
     * Returns the view's name.
     * @return string The name.
     */
    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    /**
     * Returns the supplied parameters.
     * @return array The parameters.
     */
    public function getParameters(): array
    {
        return $this->params;
    }

    /**
     * Allows to add or redefine parameters when the view object already exists. This avoids having to create a
     * completely new view object just because one parameter has changed or needs to be added. This method first checks
     * if a parameter with the given name is already stored within the view. If so, it updates its value with the one
     * supplied in $param. If the parameter is not present in the view, it is being added.
     * @param ParameterInterface $param The parameter to be added or updated.
     */
    public function setParameter(ParameterInterface $param)
    {
        $paramName = $param->getName();
        foreach ($this->params as &$arg) {
            if ($arg->getName() === $paramName) {
                $arg = $param;
                return;
            }
        }
        $this->params[] = $param;
    }

    /**
     * Performs a generic redirect using header().
     * @param string $location The target location for the redirect.
     * @param array $queryParameters GET-Parameters for HTTP-Request.
     */
    public static function redirectTo(string $location, $queryParameters = null)
    {
        if (isset($queryParameters)) {
            header("Location: $location" . "?" . http_build_query($queryParameters));
        } else {
            header("Location: $location");
        }
        exit();
    }

    abstract public function display();
}
