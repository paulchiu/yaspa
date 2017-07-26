<?php

namespace Yaspa\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ArrayResponseTransformerInterface
 *
 * @package Yaspa\Interfaces
 */
interface ArrayResponseTransformerInterface
{
    /**
     * Given a HTTP client response, return an array of transformed objects.
     *
     * @param ResponseInterface $response
     * @return array
     */
    public function fromArrayResponse(ResponseInterface $response): array;
}
