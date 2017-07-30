<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\Authentication\OAuth\Builders\NewDelegateAccessTokenRequest;
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
class OAuthService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var SecurityChecks $securityChecks */
    protected $securityChecks;
    /** @var AuthorizationCodeTransformer $authorizationCodeTransformer */
    protected $authorizationCodeTransformer;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param SecurityChecks $securityChecks
     * @param AuthorizationCodeTransformer $authorizationCodeTransformer
     * @param AccessTokenTransformer $accessTokenTransformer
     */
    public function __construct(
        Client $httpClient,
        SecurityChecks $securityChecks,
        AuthorizationCodeTransformer $authorizationCodeTransformer,
        AccessTokenTransformer $accessTokenTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->securityChecks = $securityChecks;
        $this->authorizationCodeTransformer = $authorizationCodeTransformer;
        $this->accessTokenTransformer = $accessTokenTransformer;
    }

    /**
     * Request a permanent access token.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
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
     * Request a permanent access token. Async version.
     *
     * Please note that the response will need to be transformed. See self::requestPermanentAccessToken for an
     * example of how to use the access token transformer.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
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
     * Request a new delegate access token.
     *
     * Please note that delegate access tokens cannot have more permissions than the token it is delegated from,
     * and it will also be revoked once the parent is revoked.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
     * @param NewDelegateAccessTokenRequest $request
     * @return AccessToken
     */
    public function createNewDelegateAccessToken(NewDelegateAccessTokenRequest $request): AccessToken {
        $response = $this->asyncCreateNewDelegateAccessToken($request)->wait();

        return $this->accessTokenTransformer->fromResponse($response);
    }

    /**
     * Request a new delegate access token. Async version.
     *
     * Please note that the response will need to be transformed. See self::createNewDelegateAccessToken for an
     * example of how to use the access token transformer.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
     * @param NewDelegateAccessTokenRequest $request
     * @return PromiseInterface
     */
    public function asyncCreateNewDelegateAccessToken(NewDelegateAccessTokenRequest $request): PromiseInterface
    {
        // Create new delegate access token request
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }
}
