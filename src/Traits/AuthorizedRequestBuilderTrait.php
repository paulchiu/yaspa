<?php

namespace Yaspa\Traits;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Trait AuthorizedRequestBuilderTrait
 *
 * @package Yaspa\Traits
 *
 * This used to be two traits. One for authorized request, one for request builder, however
 * a pattern emerged where they tend to be used together quite often, therefore, this is the combined
 * result.
 */
trait AuthorizedRequestBuilderTrait
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
    /** @var string $bodyType */
    protected $bodyType;

    /**
     * Generate a Guzzle/PSR-7 request.
     *
     * @return Request
     */
    public function toRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->credentials->getShop()));

        // Create request
        return new Request(
            $this->httpMethod,
            $uri,
            $this->headers
        );
    }

    /**
     * Generate Guzzle request options.
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#query
     * @return array
     */
    public function toRequestOptions(): array
    {
        $requestOptions = [$this->bodyType => $this->toArray()];

        return array_merge($this->credentials->toRequestOptions(), $requestOptions);
    }

    /**
     * Default to array method, generally should be overwritten.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param RequestCredentialsInterface $credentials
     * @return self
     */
    public function withCredentials(RequestCredentialsInterface $credentials): self
    {
        $new = clone $this;
        $new->credentials = $credentials;

        return $new;
    }

    /**
     * @param string $httpMethod
     * @return self
     */
    public function withHttpMethod(string $httpMethod): self
    {
        $new = clone $this;
        $new->httpMethod = $httpMethod;

        return $new;
    }

    /**
     * @param string $uriTemplate
     * @return self
     */
    public function withUriTemplate(string $uriTemplate): self
    {
        $new = clone $this;
        $new->uriTemplate = $uriTemplate;

        return $new;
    }

    /**
     * @param array $headers
     * @return self
     */
    public function withHeaders(array $headers): self
    {
        $new = clone $this;
        $new->headers = $headers;

        return $new;
    }
}
