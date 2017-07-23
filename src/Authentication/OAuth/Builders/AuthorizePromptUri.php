<?php

namespace Yaspa\Authentication\OAuth\Builders;

use GuzzleHttp\Psr7\Uri;
use Yaspa\Authentication\OAuth\Exceptions\MissingRequiredParameterException;
use Yaspa\Authentication\OAuth\Transformers\Scopes as ScopesTransformer;

/**
 * Class AuthorizePromptUri
 * @package Yaspa\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission
 *
 * OAuth authorization prompt URI builder.
 *
 * Example - Get URI string to request read content scope
 *
 * ```
 * $scope = Factory::make(Scopes::class)
 *      ->withReadContent();
 *
 * $authPromptUriString = (new AuthorizePromptUri('http://foo.example.com'))
 *     ->withShop('bar')
 *     ->withApiKey('baz')
 *     ->withScopes($scope)
 *     ->toUri()
 *     ->__toString();
 * ```
 */
class AuthorizePromptUri
{
    /**
     * Access modes are defined in the `{option}` definition in https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission
     *
     * For more information see https://help.shopify.com/api/getting-started/authentication/oauth#api-access-modes
     */
    const GRANT_OPTION_ONLINE_ACCESS = 'per-user';
    const GRANT_OPTION_OFFLINE_ACCESS = null;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/oauth/authorize';

    /** @var string $shop The name of the user’s shop */
    protected $shop;
    /** @var string $apiKey The app’s API Key */
    protected $apiKey;
    /** @var Scopes $scopes List of scopes to be included */
    protected $scopes;
    /** @var string $redirectUri The URL where you want to redirect the users after they authorize the client */
    protected $redirectUri;
    /** @var string $nonce A randomly selected value provided by your application, which is unique for each authorization request */
    protected $nonce;
    /** @var string $option Contains value "per-user" if the access mode is online, defaults to blank for offline */
    protected $option;

    /** @var ScopesTransformer $scopesTransformer */
    protected $scopesTransformer;

    /**
     * AuthorizePromptUri constructor.
     *
     * @param ScopesTransformer $scopesTransformer
     */
    public function __construct(ScopesTransformer $scopesTransformer)
    {
        $this->scopesTransformer = $scopesTransformer;
    }

    /**
     * @return Uri
     * @throws MissingRequiredParameterException
     */
    public function toUri(): Uri
    {
        // Check requirements
        if (empty($this->redirectUri)) {
            throw new MissingRequiredParameterException('redirectUri');
        }

        // Compute URI values
        $baseUri = sprintf(self::URI_TEMPLATE, $this->shop);
        $scope = ($this->scopes) ? $this->scopesTransformer->toCommaSeparatedList($this->scopes) : null;

        // Create URI query
        $query = http_build_query([
            'client_id' => $this->apiKey,
            'scope' => $scope,
            'redirect_uri' => $this->redirectUri,
            'state' => $this->nonce,
            'grant_options[]' => $this->option,
        ]);

        // Create URI
        $uri = (new Uri($baseUri))->withQuery($query);

        return $uri;
    }

    /**
     * @param string $shop
     * @return AuthorizePromptUri
     */
    public function withShop(string $shop): AuthorizePromptUri
    {
        $new = clone $this;
        $new->shop = $shop;

        return $new;
    }

    /**
     * @param string $apiKey
     * @return AuthorizePromptUri
     */
    public function withApiKey(string $apiKey): AuthorizePromptUri
    {
        $new = clone $this;
        $new->apiKey = $apiKey;

        return $new;
    }

    /**
     * @param Scopes $scopes
     * @return AuthorizePromptUri
     */
    public function withScopes(Scopes $scopes): AuthorizePromptUri
    {
        $new = clone $this;
        $new->scopes = $scopes;

        return $new;
    }

    /**
     * @param string $redirectUri
     * @return AuthorizePromptUri
     */
    public function withRedirectUri(string $redirectUri): AuthorizePromptUri
    {
        $new = clone $this;
        $new->redirectUri = $redirectUri;

        return $new;
    }

    /**
     * @param string $nonce
     * @return AuthorizePromptUri
     */
    public function withNonce(string $nonce): AuthorizePromptUri
    {
        $new = clone $this;
        $new->nonce = $nonce;

        return $new;
    }

    /**
     * @return AuthorizePromptUri
     */
    public function withOnlineAccess(): AuthorizePromptUri
    {
        $new = clone $this;
        $new->option = self::GRANT_OPTION_ONLINE_ACCESS;

        return $new;
    }

    /**
     * @return AuthorizePromptUri
     */
    public function withOfflineAccess(): AuthorizePromptUri
    {
        $new = clone $this;
        $new->option = self::GRANT_OPTION_OFFLINE_ACCESS;

        return $new;
    }
}
