<?php

namespace Fhooe\NormForm\Parameter;

/**
 * A special parameter that represents an entry in the $_POST superglobal.
 *
 * This parameter is specified by the index in the $_POST superglobal. If a form field called "foo" (name attribute)
 * should be tracked then "foo" needs to be supplied as $postName parameter. The class will set this index as its
 * name and will automatically set its value by doing a lookup in $_POST. If there is an entry present at the
 * supplied index, it will be set as the value, otherwise an empty string will be used.
 * When the value of this parameter is queried via getValue() it will perform the update again before returning the
 * value. If the parameter's value was empty at creation but the $_POST superglobal has been filled through a
 * form submission in the meantime, this class will consider it when returning the value.
 * To disable this mechanism and create a parameter with an always empty value (e.g. when you want an empty form
 * field in your view), set the optional second parameter $forceEmpty to true.
 *
 * @package Fhooe\NormForm\Parameter
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.0.0
 */
class PostParameter implements ParameterInterface
{
    /** @var string $name The name of the parameter. Always a string. */
    private $name;

    /** @var mixed $value The value of the parameter. Can hold any data type. */
    private $value;

    /** @var bool $forceEmpty A switch for forcing an always empty parameter object. */
    private $forceEmpty;

    /**
     * Creates a new parameter for the form field/$_POST entry with the name specified in $postName.
     * @param string $postName The index value in the $_POST superglobal this parameter should encapsulate.
     * @param bool $forceEmpty Forces the parameter to be always empty when true, otherwise the contents of $_POST are
     * used.
     */
    public function __construct(string $postName, bool $forceEmpty = false)
    {
        $this->forceEmpty = $forceEmpty;
        $this->name = $postName;
        $this->updateValue();
    }

    /**
     * Private method for updating the parameter's value. Checks if there is an entry in the $_POST superglobal.
     * If present, the entry is set as a value. Otherwise an empty string is used. If $forceEmpty is set to true the
     * value is always set as an empty string.
     * Be aware that no sanitation (htmlspecialchars, etc.) is performed on the values at this point. This is (expected
     * to be) done by the template engine in the View class.
     */
    private function updateValue(): void
    {
        if ($this->forceEmpty) {
            $this->value = "";
        } else {
            $this->value = $_POST[$this->name] ?? "";
        }
    }

    /**
     * Returns the parameter's name. Always a string.
     * @return string The name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Updates the parameters value and then returns it. Always a string since it's form field data.
     * @return string The value.
     */
    public function getValue(): string
    {
        $this->updateValue();
        return $this->value;
    }
}
