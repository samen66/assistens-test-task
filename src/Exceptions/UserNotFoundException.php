<?php

namespace AssistensTestTask\Exceptions;

/**
 * Exception thrown when a user is not found in the system.
 *
 * This exception should be used to indicate that an operation, such as retrieving
 * or processing a user, has failed due to the non-existence of the specified user.
 */
class UserNotFoundException extends \Exception
{

    /**
     * Constructor method.
     *
     * @param string $string A string parameter to initialize the object.
     * @return void
     */
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}