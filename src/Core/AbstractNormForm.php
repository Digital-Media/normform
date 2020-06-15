<?php

namespace Fhooe\NormForm\Core;

use Fhooe\NormForm\View\View;

/**
 * NormFom is a simple template application to gather, validate and process form data in a flexible way.
 *
 * This abstract class represents a well known process of gathering, validating and processing form data within a single
 * PHP structure. To use it, simple extend this class and implement the abstract methods isValid() (for validation) and
 * business() for processing/business logic. Then create an object of your subclass, supply an View object and
 * start the process by calling normForm.
 * The initial call will show the form supplied by the View object. Submitted form data will then be validated
 * by your implementation of isValid(). Occurring error messages can be passed on to the View object and
 * displayed in the template output. Once validation is passed, the data entered in the form can be processed in
 * business() in any suitable way.
 *
 * @package Fhooe\NormForm\Core
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.2.2
 */
abstract class AbstractNormForm
{
    /**
     * Holds the currently supplied view object that will be used in the template to render output.
     *
     * @var View
     */
    protected $currentView;

    /**
     * An array containing all error messages being set by isValid().
     *
     * @var array
     */
    protected $errorMessages;

    /**
     * An optional status message that can be set in business() when processing data was successful.
     *
     * @var string
     */
    protected $statusMessage;

    /**
     * Parameters, that are sent to the template
     *
     * @var array
     */
    protected $templateParameters;

    /**
     * Abstract method used to validate the form input. Must be implemented in the subclass.
     * @return bool Returns true if validation was successful, otherwise false.
     */
    abstract protected function isValid(): bool;

    /**
     * Abstract method for processing the validated form input (a.k.a. business logic). Must be implemented in the
     * subclass.
     */
    abstract protected function business(): void;

    /**
     * Creates a new instance for a norm form object and initializes all necessary fields. A View object is used to
     * initially define how and where output is displayed via the template engine and supply parameters to the template.
     * The template engine itself is also set up, two optional parameters allow setting the template paths.
     * @param View $defaultView Holds the initial @View object used for displaying the form.
     */
    public function __construct(View $defaultView)
    {
        $this->currentView = $defaultView;
        $this->errorMessages = [];
        $this->statusMessage = "";
        $this->templateParameters = [];
    }

    /**
     * Main "decision" method for the form processing. This decision tree uses isFormSubmission() to check if the form
     * is being initially displayed or shown again after a form submission and either calls show() to display the form
     * (using the supplied View object) or validate the received input in isValid(). If validation failed, show() is
     * called again. Possible error messages provided as parameters to the View object in isValid() can now be
     * displayed. Once the submission was correct, business() is called where the data can be processed as needed.
     */
    public function normForm(): void
    {
        if ($this->isValid()) {
            $this->business();
        }
        if ($this->currentView instanceof View) {
            $this->show();
        }
    }

    /**
     * Used to display output. The currently used object of type View is used to display the content by calling
     * the display() method. Depending on the type of View object, a certain template engine will be used to
     * render the output. The view object will handle passing on the parameters to the template engine.
     */
    public function show(): void
    {
        $this->currentView->display($this->templateParameters);
    }

    /**
     * Checks if the current request was an initial one (thus using GET) or a recurring one after a form submission
     * (where POST was used).
     * @return bool Returns true if a form was submitted or false if it was an initial call.
     */
    public static function getRoute(): array
    {

        $method = strip_tags($_SERVER["REQUEST_METHOD"]);
        switch ($method) {
            case "POST";
                $route['method'] = "POST";
                $route['route'] = strip_tags($_POST['route']);
                return $route;
                break;
            case "GET";
                $route['method'] = "GET";
                isset($_GET['route']) ? $route['route'] = strip_tags($_GET['route']) : $route['route'] = "normform" ;
                return $route;
                break;
        }
    }

    /**
     * Convenience method to check if a form field is empty, thus contains only an empty string. This is preferred to
     * PHP's own empty() method which also defines inputs such as "0" as empty.
     * @param string $index The index in the super global $_POST array.
     * @return bool Returns true if the form field is empty, otherwise false.
     */
    protected function isEmptyPostField(string $index): bool
    {
        return (!isset($_POST[$index]) || strlen(trim($_POST[$index])) === 0);
    }

    /**
     * Returns the supplied parameters.
     * @return array The parameters.
     */
    protected function getBodyParams(): array
    {
        return $this->params=$_POST;
    }

    /**
     * Performs a generic redirect using header(). GET-Parameters may optionally be supplied as an associative array.
     * @param string $location The target location for the redirect.
     * @param array $queryParameters GET-Parameters for HTTP-Request
     */
    public static function redirectTo(string $location, array $queryParameters = null): void
    {
        if (isset($queryParameters)) {
            header("Location: $location" . "?" . http_build_query($queryParameters));
        } else {
            header("Location: $location");
        }
        exit();
    }
}
