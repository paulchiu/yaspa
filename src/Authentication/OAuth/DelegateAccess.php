<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Yaspa\Authentication\OAuth\Builder\Scopes;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as AccessTokenTransformer;
use Yaspa\Authentication\OAuth\Transformers\Scopes as ScopesTransformer;

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
    const DELEGATE_ACCESS_HEADERS = ['Accept' => 'application/json'];
    const CREATE_NEW_DELETE_ACCESS_TOKEN_URI_TEMPLATE = 'https://%s.myshopify.com/admin/access_tokens/delegate';

    /** @var Client $httpClient */
    protected $httpClient;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;
    /** @var ScopesTransformer $scopesTransformer */
    protected $scopesTransformer;

    /**
     * DelegateAccess constructor.
     *
     * @param Client $httpClient
     * @param AccessTokenTransformer $accessTokenTransformer
     * @param ScopesTransformer $scopesTransformer
     */
    public function __construct(
        Client $httpClient,
        AccessTokenTransformer $accessTokenTransformer,
        ScopesTransformer $scopesTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->accessTokenTransformer = $accessTokenTransformer;
        $this->scopesTransformer = $scopesTransformer;
    }

    /**
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
     * @param string $shop The shop subdomain
     * @param AccessToken $accessToken The primary access token we will create a delegate from
     * @param Scopes $delegateScopes Scopes of the delegate, this is limited by the primary access token
     * @param int $expiresIn Expire the delegate token in a number of seconds
     * @return AccessToken
     */
    public function createNewDelegateAccessToken(
        string $shop,
        AccessToken $accessToken,
        Scopes $delegateScopes,
        ?int $expiresIn = null
    ): AccessToken {
        $response = $this->asyncCreateNewDelegateAccessToken(
            $shop,
            $accessToken,
            $delegateScopes,
            $expiresIn
        )->wait();

        return $this->accessTokenTransformer->fromResponse($response);
    }

    /**
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
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

        // Create post body
        $delegateScopesBodyParts = $this->scopesTransformer->toCreateNewDelegateAccessTokenPostBody($delegateScopes);
        $expiresInBodyParts = [
            [
                'name' => 'expires_in',
                'contents' => $expiresIn,
            ],
        ];
        $bodyParts = array_merge($delegateScopesBodyParts, $expiresInBodyParts);
        $body = array_filter($bodyParts, function(array $part) {
            return empty($part['contents']) === false;
        });

        // Create request
        return $this->httpClient->postAsync($uri, [
            RequestOptions::HEADERS => $headers,
            RequestOptions::MULTIPART => $body,
        ]);
    }
}
