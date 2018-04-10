<?php

namespace Fhooe\NormForm\Parameter;

/**
 * Defines an interface for parameters that are passed on to a View object.
 *
 * Parameters always consist of name and value. This interface defines that there are methods to return these
 * properties.
 *
 * @package Fhooe\NormForm\Parameter
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @version 1.0.0
 */
interface ParameterInterface
{
    /**
     * Returns the name of the parameter. This is always a string.
     * @return string The name of the parameter.
     */
    public function getName(): string;

    /**
     * Returns the value of the parameter. Can be any data type.
     * @return mixed The value of the parameter.
     */
    public function getValue();
}
