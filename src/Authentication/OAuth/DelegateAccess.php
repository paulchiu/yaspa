<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Models\Authentication\OAuth\AccessToken;
use Yaspa\Transformers\Authentication\OAuth\AccessToken as AccessTokenTransformer;

/**
 * Class DelegateAccess
 *
 * @package Yaspa\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
 *
 * Provides functionality to delegate access to subsystems.
 */
class DelegateAccess
{
    const DELEGATE_ACCESS_HEADERS = ['accepts' => 'application/json'];
    const CREATE_NEW_DELETE_ACCESS_TOKEN_URI_TEMPLATE = 'https://%s.myshopify.com/admin/access_tokens/delegate';

    /** @var Client $httpClient */
    protected $httpClient;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;

    /**
     * DelegateAccess constructor.
     *
     * @param Client $httpClient
     * @param AccessTokenTransformer $accessTokenTransformer
     */
    public function __construct(Client $httpClient, AccessTokenTransformer $accessTokenTransformer)
    {
        $this->httpClient = $httpClient;
        $this->accessTokenTransformer = $accessTokenTransformer;
    }

    /**
     * @param string $shop The shop subdomain
     * @param AccessToken $accessToken The primary access token we will create a delegate from
     * @param Scopes $delegateScopes Scopes of the delegate, this is limited by the primary access token
     * @param int $expiresIn Expire the delegate token in a number of seconds
     * @return PromiseInterface
     */
    public function asyncCreateNewDelegateAccessToken(
        string $shop,
        AccessToken $accessToken,
        Scopes $delegateScopes,
        ?int $expiresIn = null
    ): PromiseInterface {
        // Create request URI
        $baseUri = sprintf(self::CREATE_NEW_DELETE_ACCESS_TOKEN_URI_TEMPLATE, $shop);
        $uri = new Uri($baseUri);

        // Create headers
        $authenticatedRequestHeader = $this->accessTokenTransformer->toAuthenticatedRequestHeader($accessToken);
        $headers = array_merge(self::DELEGATE_ACCESS_HEADERS, $authenticatedRequestHeader);

        // @todo Create form-data body using scopes transformer
        // @todo Add expires in to form-data
        // @todo post async request
    }
}
