<?php

namespace Example;

use Fhooe\NormForm\Core\AbstractNormForm;
use Fhooe\NormForm\Parameter\GenericParameter;
use Fhooe\NormForm\Parameter\PostParameter;

class NormFormDemo extends AbstractNormForm
{

    /**
     * @var string FIRST_NAME Form field constant that defines
     *                        how the form field for holding a first name is called (id/name).
     */
    const FIRST_NAME = "firstname";

    /**
     * @var string LAST_NAME Form field constant that defines
     *                       how the form field for holding a last name is called (id/name).
     */
    const LAST_NAME = "lastname";

    /**
     * @var string MESSAGE Form field constant that defines
     *                     how the form field for holding a message is called (id/name).
     */
    const MESSAGE = "message";

    /** @var array $result Holds the results of the form submission (assigned in @business(). */
    private $result;

    /**
     * Validates the form submission. The criteria for this example are non-empty fields for first and last name.
     * These are checked using @isEmptyPostField() in two separate if-clauses.
     * If a criterion is violated, an entry in @errorMessages is created.
     * The array holding these error messages is then added to the parameters of the current view. If no error
     * messages where created, validation is seen as successful.
     *
     * @return bool Returns true if validation was successful, otherwise false.
     */
    protected function isValid(): bool
    {
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
     * @return AbstractView|null A new @View object for display output or null to keep the current view.
     */
    protected function business()
    {
        $this->result = $_POST;
        $this->currentView->setParameter(new GenericParameter("result", $this->result));

        $this->statusMessage = "Processing successful!";
        $this->currentView->setParameter(new GenericParameter("statusMessage", $this->statusMessage));

        // Update the three form parameters with empty content so that the form fields are empty upon result display.
        $this->currentView->setParameter(new PostParameter(self::FIRST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::LAST_NAME, true));
        $this->currentView->setParameter(new PostParameter(self::MESSAGE, true));

        // null can also be explicitly returned to keep the same view.
        return null;
    }
}