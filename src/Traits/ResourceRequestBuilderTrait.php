<?php

namespace Yaspa\Traits;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Trait ResourceRequestBuilderTrait
 *
 * @package Yaspa\Traits
 *
 * This trait is used by request builders that work with a specific, identifiable, resource.
 *
 * The expectation is that this trait will be combined with \Yaspa\Traits\AuthorizedRequestBuilderTrait to enable
 * the fulfilment of all required Guzzle client send parameters.
 */
trait ResourceRequestBuilderTrait
{
    /**
     * Builder properties
     */
    /** @var RequestCredentialsInterface $credentials */
    protected $credentials;
    /** @var string $httpMethod */
    protected $httpMethod;
    /** @var string $uriTemplate */
    protected $uriTemplate;
    /** @var string $headers */
    protected $headers;

    /**
     * Generate a Guzzle/PSR-7 request with a given resource id.
     *
     * This is generally used for quests that work with a single resource.
     *
     * @return Request
     */
    public function toResourceRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->credentials->getShop(), $this->toResourceId()));

        // Create request
        return new Request(
            $this->httpMethod,
            $uri,
            $this->headers
        );
    }

    /**
     * Return the resource id to be used for a resource request. Should be overwritten.
     *
     * @return mixed
     */
    public function toResourceId()
    {
        return '';
    }
}
