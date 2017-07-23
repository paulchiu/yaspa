<?php

namespace Yaspa\Traits;

/**
 * Trait RequestBuilderTrait
 *
 * @package Yaspa\Traits
 */
trait RequestBuilderTrait
{
    /**
     * Builder properties
     */
    /** @var string $httpMethod */
    protected $httpMethod;
    /** @var string $uriTemplate */
    protected $uriTemplate;
    /** @var string $headers */
    protected $headers;

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
