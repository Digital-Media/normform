<?php

namespace Fhooe\NormForm\Parameter;

/**
 * A generic name/value parameter.
 *
 * This parameter consists of name and value. The name is always a string whereas the value can be any data type.
 *
 * @package Fhooe\NormForm\Parameter
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.0.0
 */
final class GenericParameter implements ParameterInterface
{
    /**
     * The name of the parameter. Always a string.
     *
     * @var string
     */
    private $name;

    /**
     * The value of the parameter. Can hold any data type.
     *
     * @var mixed
     */
    private $value;

    /**
     * Creates a new parameter using the supplied name and value.
     * @param string $name The name of the parameter.
     * @param mixed $value The value of the parameter.
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
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
     * Returns the parameter's value. Can be any data type.
     * @return mixed The value.
     */
    public function getValue()
    {
        return $this->value;
    }
}
