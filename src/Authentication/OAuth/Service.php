<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\Authentication\OAuth\Builder\NewDelegateAccessTokenRequest;
use Yaspa\Authentication\OAuth\Builder\Scopes;
use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Models\AuthorizationCode;
use Yaspa\Authentication\OAuth\Models\Credentials;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as AccessTokenTransformer;
use Yaspa\Authentication\OAuth\Transformers\AuthorizationCode as AuthorizationCodeTransformer;

/**
 * Class Service
 *
 * @package Yaspa\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth
 *
 * The OAuth service class enables tasks defined in the Shopify OAuth authentication guide.
 */
class Service
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var SecurityChecks $securityChecks */
    protected $securityChecks;
    /** @var AuthorizationCodeTransformer $authorizationCodeTransformer */
    protected $authorizationCodeTransformer;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;
    /** @var NewDelegateAccessTokenRequest $newDelegateAccessTokenRequestBuilder */
    protected $newDelegateAccessTokenRequestBuilder;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param SecurityChecks $securityChecks
     * @param AuthorizationCodeTransformer $authorizationCodeTransformer
     * @param AccessTokenTransformer $accessTokenTransformer
     * @param NewDelegateAccessTokenRequest $newDelegateAccessTokenRequestBuilder
     */
    public function __construct(
        Client $httpClient,
        SecurityChecks $securityChecks,
        AuthorizationCodeTransformer $authorizationCodeTransformer,
        AccessTokenTransformer $accessTokenTransformer,
        NewDelegateAccessTokenRequest $newDelegateAccessTokenRequestBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->securityChecks = $securityChecks;
        $this->authorizationCodeTransformer = $authorizationCodeTransformer;
        $this->accessTokenTransformer = $accessTokenTransformer;
        $this->newDelegateAccessTokenRequestBuilder = $newDelegateAccessTokenRequestBuilder;
    }

    /**
     * @param AuthorizationCode $authorizationCode
     * @param Credentials $credentials
     * @param null|string $nonce
     * @return AccessToken
     * @throws ClientException
     */
    public function requestPermanentAccessToken(
        AuthorizationCode $authorizationCode,
        Credentials $credentials,
        ?string $nonce = null
    ): AccessToken {
        $response = $this->asyncRequestPermanentAccessToken(
            $authorizationCode,
            $credentials,
            $nonce
        )->wait();

        return $this->accessTokenTransformer->fromResponse($response);
    }

    /**
     * @param AuthorizationCode $authorizationCode
     * @param Credentials $credentials
     * @param string|null $nonce
     * @return PromiseInterface
     * @throws FailedSecurityChecksException
     */
    public function asyncRequestPermanentAccessToken(
        AuthorizationCode $authorizationCode,
        Credentials $credentials,
        ?string $nonce = null
    ): PromiseInterface {
        // Security check authorization code
        $securityCheckResult = $this->securityChecks->checkAuthorizationCode(
            $authorizationCode,
            $credentials,
            $nonce
        );

        // If didn't pass security check, throw failure exception
        if (!$securityCheckResult->passed()) {
            throw $securityCheckResult->getFailureException();
        }

        // Prepare request
        $accessTokenRequest = $this->authorizationCodeTransformer->toAccessTokenRequest(
            $authorizationCode,
            $credentials
        );

        // Create code exchange request
        return $this->httpClient->sendAsync(
            $accessTokenRequest->toRequest(),
            $accessTokenRequest->toRequestOptions()
        );
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
        // Build request
        $delegateAccessTokenRequest = $this->newDelegateAccessTokenRequestBuilder
            ->withShop($shop)
            ->withAccessToken($accessToken)
            ->withScopes($delegateScopes)
            ->withExpiresIn($expiresIn);

        // Create new delegate access token request
        return $this->httpClient->sendAsync(
            $delegateAccessTokenRequest->toRequest(),
            $delegateAccessTokenRequest->toRequestOptions()
        );
    }
}
