<?php

namespace Yaspa\Authentication\OAuth\Exceptions;

use Exception;
use Throwable;

/**
 * Class FailedSecurityChecksException
 * @package Yaspa\OAuth\Exceptions
 */
class FailedSecurityChecksException extends Exception
{
    const MESSAGE_TEMPLATE = 'Security check for a valid %s has failed';

    /** @var string $checkedProperty */
    protected $checkedProperty;
    /** @var string $expected */
    protected $expected;
    /** @var string $received */
    protected $received;

    /**
     * FailedSecurityChecksException constructor.
     *
     * @param string $checkedProperty
     * @param string|null $expected
     * @param string|null $received
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $checkedProperty,
        string $expected = null,
        string $received = null,
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->checkedProperty = $checkedProperty;
        $this->expected = $expected;
        $this->received = $received;
        parent::__construct($this->__toString(), $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $messageParts = [];
        $messageParts[] = sprintf(self::MESSAGE_TEMPLATE, $this->checkedProperty);

        if ($this->expected) {
            $messageParts[] = sprintf('expected: "%s"', $this->expected);
        }

        if ($this->received) {
            $messageParts[] = sprintf('received: "%s"', $this->received);
        }

        return implode('; ', $messageParts);
    }
}
