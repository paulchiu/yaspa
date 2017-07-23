<?php

namespace Yaspa\AdminApi\Shop\Builders;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Interfaces\RequestCredentialsInterface;
use Yaspa\Traits\RequestBuilderTrait;

/**
 * Class GetShopRequest
 *
 * @package Yaspa\Authentication\OAuth\Builder
 * @mixin RequestBuilderTrait
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Generates a access token request to use with Guzzle.
 */
class GetShopRequest implements RequestBuilderInterface
{
    use RequestBuilderTrait;

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'GET';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/shop.json';

    /** @var RequestCredentialsInterface $credentials */
    protected $credentials;

    /**
     * GetShopRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->httpMethod = self::HTTP_METHOD;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->headers = self::HEADERS;
    }

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
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @return array
     */
    public function toRequestOptions(): array
    {
        return array_merge($this->credentials->toRequestOptions(), []);
    }

    /**
     * @param RequestCredentialsInterface $credentials
     * @return GetShopRequest
     */
    public function withCredentials(RequestCredentialsInterface $credentials): GetShopRequest
    {
        $new = clone $this;
        $new->credentials = $credentials;

        return $new;
    }
}
