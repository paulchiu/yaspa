<?php

namespace Yaspa\Authentication\OAuth\Builders;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\RequestBuilderTrait;

/**
 * Class AccessTokenRequest
 *
 * @package Yaspa\Authentication\OAuth\Builder
 * @mixin RequestBuilderTrait
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Generates a access token request to use with Guzzle.
 */
class AccessTokenRequest implements RequestBuilderInterface
{
    use RequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s/admin/oauth/access_token';

    /** @var string $shop */
    protected $shop;
    /** @var string $clientId */
    protected $clientId;
    /** @var string $clientSecret */
    protected $clientSecret;
    /** @var string $code */
    protected $code;

    /**
     * AccessTokenRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::POST_HTTP_METHOD;
        $this->headers = RequestBuilder::ACCEPT_JSON_HEADERS;
    }

    /**
     * Generate a Guzzle/PSR-7 request.
     *
     * @return Request
     */
    public function toRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->shop));

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
        return [
            RequestBuilder::MULTIPART_BODY_TYPE => [
                [
                    'name' => 'client_id',
                    'contents' => $this->clientId,
                ],
                [
                    'name' => 'client_secret',
                    'contents' => $this->clientSecret,
                ],
                [
                    'name' => 'code',
                    'contents' => $this->code,
                ],
            ],
        ];
    }

    /**
     * @param string $shop
     * @return AccessTokenRequest
     */
    public function withShop(string $shop): AccessTokenRequest
    {
        $new = clone $this;
        $new->shop = $shop;

        return $new;
    }

    /**
     * @param string $clientId
     * @return AccessTokenRequest
     */
    public function withClientId(string $clientId): AccessTokenRequest
    {
        $new = clone $this;
        $new->clientId = $clientId;

        return $new;
    }

    /**
     * @param string $clientSecret
     * @return AccessTokenRequest
     */
    public function withClientSecret(string $clientSecret): AccessTokenRequest
    {
        $new = clone $this;
        $new->clientSecret = $clientSecret;

        return $new;
    }

    /**
     * @param string $code
     * @return AccessTokenRequest
     */
    public function withCode(string $code): AccessTokenRequest
    {
        $new = clone $this;
        $new->code = $code;

        return $new;
    }
}
