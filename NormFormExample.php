<?php

require_once("AbstractNormForm.php");

/**
 * Example implementation of the norm form class that validates a simple form with two required and one optional parameter.
 *
 * This is an implementation of the @AbstractNormForm class. It defines a concrete example how to validate a form with three
 * input fields where two are required (and therefore checked for emptiness). It also defines a very simple business logic
 * where the resulting contents of the superglobal $_POST are first stored in an variable, then passed on the the view where
 * they are displayed as a table.
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 2017
 */
class NormFormExample extends AbstractNormForm {

    /** @var string FIRST_NAME Form field constant that defines how the form field for holding a first name is called (id/name). */
    const FIRST_NAME = "firstname";

    /** @var string LAST_NAME Form field constant that defines how the form field for holding a last name is called (id/name). */
    const LAST_NAME = "lastname";

    /** @var string MESSAGE Form field constant that defines how the form field for holding a message is called (id/name). */
    const MESSAGE = "message";

    /** @var array $result Holds the results of the form submission (assigned in @business(). */
    private $result;

    /**
     * Validates the form submission. The criteria for this example are non-empty fields for first and last name. These are
     * checked using @isEmptyPostField() in two separate if-clauses. If a criterion is violated, an entry in @errorMessages
     * is created. The array holding these error messages is then added to the parameters of the current view. If no error
     * messages where created, validation is seen as successful.
     * @return bool Returns true if validation was successful, otherwise false.
     */
    protected function isValid(): bool {
        if ($this->isEmptyPostField(self::FIRST_NAME)) {
            $this->errorMessages[self::FIRST_NAME] = "First name is required.";
        }
        if ($this->isEmptyPostField(self::LAST_NAME)) {
            $this->errorMessages[self::LAST_NAME] = "Last name is required.";
        }

        $this->currentView->setParameter(new GenericParameter("errorMessages", $this->errorMessages));

        return (count($this->errorMessages) === 0);
    }

    /**
     * Business logic method used to process the data that was used after a successful validation. In this example the
     * received data is stored in @result and passed on to the view. In more complex scenarios this would be the place
     * to add things to a database or perform other tasks before displaying the data. This method can optionally return
     * a @View object. This is then used by the subsequently called @show method and allows for a flexible display of
     * the processed data in a new template or even a new, separate PHP file. If nothing is returned, the current view
     * is kept (useful if the initial template containing the form should directly display the output underneath).
     * @return View|null A new @View object for display output or null to keep the current view.
     */
    protected function business() {
        $this->result = $_POST;
        $this->currentView->setParameter(new GenericParameter("result", $this->result));

        $this->statusMessage = "Processing successful!";
        $this->currentView->setParameter(new GenericParameter("statusMessage", $this->statusMessage));

        // Update the three form parameters with empty content so that the form fields are empty upon result display.
        $this->currentView->setParameter(new PostParameter(self::FIRST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::LAST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::MESSAGE, true));

        // null can also be explicitly returned to keep the same view.
        // return null;
    }
}

// --- This is the main call of the norm form process

/* First, define a View object. It will usually be of type FORM. You'll usually need to supply parameters for the template.
 * These parameters are used for setting name and id parameters (and "for" in the label) in the input element as well as
 * its value (see PostParameter class for details).
 */
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
