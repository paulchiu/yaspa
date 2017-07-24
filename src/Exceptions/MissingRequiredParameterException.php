<?php

namespace Yaspa\Exceptions;

use Exception;
use Throwable;

/**
 * Class MissingRequiredParameterException
 *
 * @package Yaspa\Exceptions
 *
 * This is a general exception for use with builder classes that have pre-checked requirements.
 */
class MissingRequiredParameterException extends Exception
{
    const MESSAGE_TEMPLATE = 'Required parameter "%s" is not set or is empty';

    /** @var string $requiredParameterName */
    protected $requiredParameterName;

    /**
     * MissingRequiredParameterException constructor.
     *
     * @param string $requiredParameterName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $requiredParameterName, $code = 0, Throwable $previous = null)
    {
        $this->requiredParameterName = $requiredParameterName;
        parent::__construct($this->__toString(), $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $this->requiredParameterName);

        return $message;
    }
}
