<?php

namespace Yaspa\Exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidJsonStringException
 *
 * @package Yaspa\Exceptions
 *
 * This is a general exception for when json_decode doesn't work.
 */
class InvalidJsonStringException extends Exception
{
    const MESSAGE_TEMPLATE = 'Could not parse JSON string due to: %s';

    /** @var string $jsonErrorMessage */
    protected $jsonErrorMessage;

    /**
     * InvalidJsonStringException constructor.
     *
     * @see http://php.net/manual/en/function.json-last-error-msg.php
     * @param string $jsonErrorMessage Get this by calling json_last_error_msg()
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $jsonErrorMessage, $code = 0, Throwable $previous = null)
    {
        $this->jsonErrorMessage = $jsonErrorMessage;
        parent::__construct($this->__toString(), $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $this->jsonErrorMessage);

        return $message;
    }
}
