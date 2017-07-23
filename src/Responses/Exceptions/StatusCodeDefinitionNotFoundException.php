<?php

namespace Yaspa\Responses\Exceptions;

use Exception;
use Throwable;

/**
 * Class StatusCodeDefinitionNotFoundException
 *
 * @package Yaspa\Responses\Exceptions
 */
class StatusCodeDefinitionNotFoundException extends Exception
{
    const MESSAGE_TEMPLATE = <<<MESSAGE_TEMPLATE
The status code %s could not be found, please confirm it exists in the most recent Shopify documentation.

See: https://help.shopify.com/api/getting-started/response-status-codes
MESSAGE_TEMPLATE;

    /** @var int $statusCode */
    protected $statusCode;

    /**
     * StatusCodeDefinitionNotFoundException constructor.
     * @param int $statusCode
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(int $statusCode, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $statusCode);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
