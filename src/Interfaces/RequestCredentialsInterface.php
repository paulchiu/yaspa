<?php

namespace Yaspa\Interfaces;

/**
 * Interface RequestCredentialsInterface
 *
 * @package Yaspa\Interfaces
 *
 * Implementation of this interface indicates that a class is able to provide details
 * required to construct an authenticated Guzzle client request.
 */
interface RequestCredentialsInterface
{
    /**
     * Returns the subdomain used for the Shopify shop. This is where all resource endpoints are addressed to.
     *
     * @return null|string
     */
    public function getShop():? string;

    /**
     * Return Guzzle request options that should enable the request to pass any authentication checks.
     *
     * @return array
     */
    public function toRequestOptions(): array;
}
