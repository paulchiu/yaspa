<?php

namespace Yaspa\Exceptions;

use Exception;
use Throwable;

/**
 * Class MissingExpectedAttributeException
 *
 * @package Yaspa\Exceptions
 *
 * This is a general exception for use with Shopify response parsing that have attribute checks.
 */
class MissingExpectedAttributeException extends Exception
{
    const MESSAGE_TEMPLATE = 'Expected attribute "%s" does not exist';

    /** @var string $expectedAttributeName */
    protected $expectedAttributeName;

    /**
     * MissingExpectedAttributeException constructor.
     *
     * @param string $expectedAttributeName
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $expectedAttributeName, $code = 0, Throwable $previous = null)
    {
        $this->expectedAttributeName = $expectedAttributeName;
        parent::__construct($this->__toString(), $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $this->expectedAttributeName);

        return $message;
    }
}
