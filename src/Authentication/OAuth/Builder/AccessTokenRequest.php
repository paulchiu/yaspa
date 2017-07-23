<?php

namespace Yaspa\Authentication\OAuth\Builder;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;

/**
 * Class AccessTokenRequest
 *
 * @package Yaspa\Authentication\OAuth\Builder
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Generates a access token request to use with Guzzle.
 */
class AccessTokenRequest
{
    const HEADERS = ['Accept' => 'application/json'];
    const HTTP_METHOD = 'POST';
    const URI_TEMPLATE = 'https://%s/admin/oauth/access_token';

    /** @var string $shop */
    protected $shop;
    /** @var string $clientId */
    protected $clientId;
    /** @var string $clientSecret */
    protected $clientSecret;
    /** @var string $code */
    protected $code;
    /** @var string $uriTemplate */
    protected $uriTemplate;

    /**
     * AccessTokenRequest constructor.
     *
     * @param string $uriTemplate
     */
    public function __construct(string $uriTemplate = self::URI_TEMPLATE)
    {
        $this->uriTemplate = $uriTemplate;
    }

    /**
     * @return Request
     */
    public function toRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->shop));

        // Create headers
        $headers = [
            RequestOptions::HEADERS => self::HEADERS,
        ];

        // Create request
        return new Request(self::HTTP_METHOD, $uri, $headers);
    }

    /**
     * Request options for multi-part form data.
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @return array
     */
    public function toRequestOptions(): array
    {
        return [
            RequestOptions::MULTIPART => [
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

    /**
     * @param string $uriTemplate
     * @return AccessTokenRequest
     */
    public function withUriTemplate(string $uriTemplate): AccessTokenRequest
    {
        $new = clone $this;
        $new->uriTemplate = $uriTemplate;

        return $new;
    }
}
