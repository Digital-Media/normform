<?php

require_once("Utilities.class.php");

/**
 * Encapsulates data for displaying a form or result of a form submission.
 *
 * Defines a type of view which can be either @FORM (a template containing a form), @TEMPLATE
 * (a template without a form) or @URL (an external PHP file). Also holds the name of the view
 * (a Smarty .tpl file for @FORM and @TEMPLATE or a PHP filename for @URL) and allows to specify
 * Parameters that should be used for displaying. Parameters should be classes implementing
 * @ParameterInterface (e.g. @GenericParameter or @PostParameter). When using an external PHP file
 * (type @URL) a simple array can also be used for simplicity's sake.
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 2017
 */
class View {
    /** @var int FORM Constant for specifying a view using a template containing a form. */
    const FORM = 0;

    /** @var int TEMPLATE Constant for specifying a view using a template without a form. */
    const TEMPLATE = 1;

    /** @var int URL Constant for specifying a view using an external PHP file. */
    const URL = 2;

    /** @var int $type The current type of the view (either @FORM, @TEMPLATE or @URL). */
    private $type;

    /** @var string $name name of the view (a .tpl file name or a PHP file name). */
    private $name;

    /** @var array $params An array of parameters used for display. */
    private $params;

    /**
     * Creates a new view with the specified type, name and parameters.
     * @param int $type The type of view.
     * @param string $name The name of the file involved.
     * @param array $params The parameters used when displaying the view.
     */
    function __construct(int $type = 1, string $name = "form.tpl", array $params = []) {
        $this->type = $type;
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * Returns the view's type.
     * @return int The current type.
     */
    public function getType(): int {
        return $this->type;
    }

    /**
     * Returns the view's name.
     * @return string The name.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Returns the supplied paramters.
     * @return array The parameters.
     */
    public function getParameters() : array {
        return $this->params;
    }

    /**
     * Allows to add or redefine parametes when the view object already exists. This avoids
     * having to create a completly new view object just because on parameter has changed or
     * needs to be added. This method first checks if a parameter with the given name is already
     * stored within the view. If so, it updates its value with the one supplied in @param.
     * If the parameter is not present in the view, it is being added.
     * @param ParameterInterface $param The parameter to be added or updated.
     */
    public function setParameter(ParameterInterface $param) {
        $paramName = $param->getName();
        foreach ($this->params as &$arg) {
            if ($arg->getName() === $paramName) {
                $arg = $param;
                return;
            }
        }
        $this->params[] = $param;
    }
}
