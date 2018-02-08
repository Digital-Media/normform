<?php
require_once("View.php");
require_once("GenericParameter.php");
require_once("PostParameter.php");
require_once("../vendor/smarty/smarty/libs/Smarty.class.php");

/**
 * The object oriented and template based norm form is used to gather, validate and process form data in a flexible way.
 *
 * This abstract class represents a well known process of gathering, validating and processing form data within a single
 * PHP structure. To use it, simple extend this class and implement the abstract methods isValid() (for validation) and
 * business() for processing/business logic. Then create an object of your subclass, supply a View object and start
 * the process by calling normForm.
 * The initial call will show the form supplied by the View object. Submitted form data will then be validated by your
 * implementation of isValid(). Occurring error messages can be passed on to the View object and displayed in the
 * template output. Once validation is passed, the data entered in the form can be processed in business() in any
 * suitable way. By returning a new View object in business() the processed data can be displayed flexibly (in a new
 * template or in a separate file). If nothing is returned the current (form) view also can be used to show output.
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 2017
 */
abstract class AbstractNormForm
{

    /**
     * @var Smarty $smarty Hold the reference to the Smarty template engine.
     */
    protected $smarty;

    /**
     * @var View $currentView Holds the currently supplied View object that will be used in the template to render
     * output.
     */
    protected $currentView;

    /**
     * @var array $errorMessages An array containing all error messages being set by isValid().
     */
    protected $errorMessages;

    /**
     * @var string $statusMessage An optional status message that can be set in business() when processing data was
     * successful.
     */
    protected $statusMessage;

    /**
     * Abstract method used to validate the form input. Must be implemented in the subclass.
     * @return bool Returns true if validation was successful, otherwise false.
     */
    abstract protected function isValid(): bool;

    /**
     * Abstract method for processing the validated form input (a.k.a. business logic). Must be implemented in the
     * subclass.
     * @return View|null Can return a View object to determine a new target for output or null to keep the same view.
     */
    abstract protected function business();

    /**
     * Creates a new instance for a norm form object and initializes all necessary fields. A View object is used to
     * initially define how and where output is displayed via the template engine and supply parameters to the template.
     * The template engine itself is also set up, two optional parameters allow setting the template paths.
     * @param View $defaultView Holds the initial @View object used for displaying the form.
     * @param string $templateDir Optional parameter for setting the path to the template files.
     * @param string $compileDir Optional parameter for setting the path for compiled templates.
     */
    public function __construct(
        View $defaultView,
        string $templateDir = "templates",
        string $compileDir = "templates_c"
    ) {
        $this->smarty = new Smarty();
        $this->smarty->template_dir = $templateDir;
        $this->smarty->compile_dir = $compileDir;
        $this->currentView = $defaultView;
        $this->errorMessages = [];
        $this->statusMessage = "";
    }

    /**
     * Main "decision" method for the form processing. This decision tree uses isFormSubmission() to check if the form
     * is being initially displayed or shown again after a form submission and either calls show() to display the form
     * (using the supplied View object) or validate the received input in isValid(). If validation failed, show() is
     * called again. Possible error messages provided as parameters to the View object in isValid() can now be
     * displayed. Once the submission was correct, business() is called where the data can be processed as needed. If
     * this method returns a new View object it is used to display the output as specified there, otherwise the current
     * view is kept.
     */
    public function normForm()
    {
        if ($this->isFormSubmission()) {
            if ($this->isValid()) {
                $this->business();
                $this->show();
            } else {
                $this->show();
            }
        } else {
            $this->show();
        }
    }

    /**
     * Checks if the current request was an initial one (thus using GET) or a recurring one after a form submission
     * (where POST was used).
     * @return bool Returns true if a form was submitted or false if it was an initial call.
     */
    protected function isFormSubmission(): bool
    {
        return ($_SERVER["REQUEST_METHOD"] === "POST");
    }

    /**
     * Used to display output. A View object is used to define the kind of output (either a template containing a form,
     * a template without a form or a new, external PHP page), its name and possible parameters. If the output is in a
     * template (types FORM or TEMPLATE) then the parameters supplied with the View object are passed on to the
     * template engine and the template file specified in the View object is displayed. If the output is in another,
     * external PHP file (type URL), the parameters supplied in the View object are converted to a valid query
     * parameter string which is then appended to the defined file name and a HTTP redirect to the assembled URL is
     * initiated.
     * @param View|null $view An optional View object used to display output or null to use the initially supplied
     * view.
     */
    protected function show()
    {
        foreach ($this->currentView->getParameters() as $param) {
            if ($param instanceof PostParameter) {
                $this->smarty->assign($param->getName(), $param);
            } else {
                if ($param instanceof GenericParameter) {
                    $this->smarty->assign($param->getName(), $param->getValue());
                }
            }
        }
        $this->smarty->display($this->currentView->getName());
    }

    /**
     * Convenience method to check if a form field is empty, thus contains only an empty string. This is preferred to
     * PHP's own empty() method which also defines inputs such as "0" as empty.
     * @param string $index The index in the superglobal $_POST array.
     * @return bool Returns true if the form field is empty, otherwise false.
     */
    protected function isEmptyPostField(string $index): bool
    {
        return (!isset($_POST[$index]) || strlen(trim($_POST[$index])) === 0);
    }
}
