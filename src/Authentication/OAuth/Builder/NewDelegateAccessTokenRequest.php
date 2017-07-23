<?php

namespace Yaspa\Authentication\OAuth\Builder;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as AccessTokenTransformer;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\RequestBuilderTrait;

/**
 * Class NewDelegateAccessTokenRequest
 *
 * @package Yaspa\Authentication\OAuth\Builder
 * @mixin RequestBuilderTrait
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
 *
 * Create a new delegate access token request.
 */
class NewDelegateAccessTokenRequest implements RequestBuilderInterface
{
    use RequestBuilderTrait;

    const HTTP_METHOD = 'POST';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/access_tokens/delegate';
    const HEADERS = ['Accept' => 'application/json'];

    /**
     * Dependencies
     */
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;

    /**
     * Request properties
     */
    /** @var string $shop */
    protected $shop;
    /** @var AccessToken $accessToken */
    protected $accessToken;
    /** @var Scopes $scopes */
    protected $scopes;
    /** @var int $expiresIn */
    protected $expiresIn;

    /**
     * NewDelegateAccessTokenRequest constructor.
     *
     * @param AccessTokenTransformer $accessTokenTransformer
     */
    public function __construct(AccessTokenTransformer $accessTokenTransformer)
    {
        // Set dependencies
        $this->accessTokenTransformer = $accessTokenTransformer;

        // Set properties with defaults
        $this->httpMethod = self::HTTP_METHOD;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->headers = self::HEADERS;
    }

    /**
     * @return Request
     */
    public function toRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->shop));

        // Create headers
        $authenticatedRequestHeader = $this->accessTokenTransformer
            ->toAuthenticatedRequestHeader($this->accessToken);

        // Create headers
        $headers = array_merge($this->headers, $authenticatedRequestHeader);

        // Create request
        return new Request($this->httpMethod, $uri, $headers);
    }

    /**
     * @return array
     */
    public function toRequestOptions(): array
    {
        // Get access scopes
        $delegateScopesBodyParts = array_map(function (string $scope): array {
            return [
                'name' => 'delegate_access_scope[]',
                'contents' => $scope,
            ];
        }, $this->scopes->getRequested());

        // Get expires in
        $expiresInBodyParts = [
            [
                'name' => 'expires_in',
                'contents' => $this->expiresIn,
            ],
        ];

        // Combine and get non-empty body parts
        $bodyParts = array_merge($delegateScopesBodyParts, $expiresInBodyParts);
        $body = array_filter($bodyParts, function(array $part) {
            return empty($part['contents']) === false;
        });

        // Return multipart body as options
        return [
            RequestOptions::MULTIPART => $body,
        ];
    }

    /**
     * @param string $shop
     * @return NewDelegateAccessTokenRequest
     */
    public function withShop(string $shop): NewDelegateAccessTokenRequest
    {
        $new = clone $this;
        $new->shop = $shop;

        return $new;
    }

    /**
     * @param AccessToken $accessToken
     * @return NewDelegateAccessTokenRequest
     */
    public function withAccessToken(AccessToken $accessToken): NewDelegateAccessTokenRequest
    {
        $new = clone $this;
        $new->accessToken = $accessToken;

        return $new;
    }

    /**
     * @param Scopes $scopes
     * @return NewDelegateAccessTokenRequest
     */
    public function withScopes(Scopes $scopes): NewDelegateAccessTokenRequest
    {
        $new = clone $this;
        $new->scopes = $scopes;

        return $new;
    }

    /**
     * @param int $expiresIn
     * @return NewDelegateAccessTokenRequest
     */
    public function withExpiresIn(?int $expiresIn): NewDelegateAccessTokenRequest
    {
        $new = clone $this;
        $new->expiresIn = $expiresIn;

        return $new;
    }
}
