<?php

namespace Yaspa\Interfaces;

use GuzzleHttp\Psr7\Request;

/**
 * Interface RequestBuilderInterface
 *
 * @package Yaspa\Interfaces
 *
 * Implementation of this interface indicates that a class is capable of creating a
 * Guzzle/PSR-7 compliant request.
 */
interface RequestBuilderInterface
{
    /**
     * Build a Guzzle/PSR compliant request
     *
     * @see http://docs.guzzlephp.org/en/stable/psr7.html#requests
     * @return Request
     */
    public function toRequest(): Request;

    /**
     * Return request options that can be used with a `\GuzzleHttp\Client::sendAsync`
     * or `\GuzzleHttp\Client::send` call.
     *
     * The returned array is optional and can be an empty array if not used.
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return array
     */
    public function toRequestOptions(): array;
}
