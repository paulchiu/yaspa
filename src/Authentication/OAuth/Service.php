<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Yaspa\Authentication\OAuth\Builder\Scopes;
use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Models\ConfirmationRedirect;
use Yaspa\Authentication\OAuth\Models\Credentials;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as AccessTokenTransformer;
use Yaspa\Authentication\OAuth\Transformers\ConfirmationRedirect as ConfirmationRedirectTransformer;
use Yaspa\Authentication\OAuth\Transformers\Scopes as ScopesTransformer;

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
    const REQUEST_PERMANENT_ACCESS_TOKEN_HEADERS = ['Accept' => 'application/json'];
    const DELEGATE_ACCESS_HEADERS = ['Accept' => 'application/json'];
    const CREATE_NEW_DELETE_ACCESS_TOKEN_URI_TEMPLATE = 'https://%s.myshopify.com/admin/access_tokens/delegate';

    /** @var Client $httpClient */
    protected $httpClient;
    /** @var SecurityChecks $securityChecks */
    protected $securityChecks;
    /** @var ConfirmationRedirectTransformer $confirmationRedirectTransformer */
    protected $confirmationRedirectTransformer;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;
    /** @var ScopesTransformer $scopesTransformer */
    protected $scopesTransformer;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param SecurityChecks $securityChecks
     * @param ConfirmationRedirectTransformer $confirmationRedirectTransformer
     * @param AccessTokenTransformer $accessTokenTransformer
     * @param ScopesTransformer $scopesTransformer
     */
    public function __construct(
        Client $httpClient,
        SecurityChecks $securityChecks,
        ConfirmationRedirectTransformer $confirmationRedirectTransformer,
        AccessTokenTransformer $accessTokenTransformer,
        ScopesTransformer $scopesTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->securityChecks = $securityChecks;
        $this->confirmationRedirectTransformer = $confirmationRedirectTransformer;
        $this->accessTokenTransformer = $accessTokenTransformer;
        $this->scopesTransformer = $scopesTransformer;
    }

    /**
     * @param ConfirmationRedirect $confirmationRedirect
     * @param Credentials $credentials
     * @param null|string $nonce
     * @return AccessToken
     * @throws ClientException
     */
    public function requestPermanentAccessToken(
        ConfirmationRedirect $confirmationRedirect,
        Credentials $credentials,
        ?string $nonce = null
    ): AccessToken {
        $response = $this->asyncRequestPermanentAccessToken(
            $confirmationRedirect,
            $credentials,
            $nonce
        )->wait();

        return $this->accessTokenTransformer->fromResponse($response);
    }

    /**
     * @param ConfirmationRedirect $confirmationRedirect
     * @param Credentials $credentials
     * @param string|null $nonce
     * @return PromiseInterface
     * @throws FailedSecurityChecksException
     */
    public function asyncRequestPermanentAccessToken(
        ConfirmationRedirect $confirmationRedirect,
        Credentials $credentials,
        ?string $nonce = null
    ): PromiseInterface {
        // Perform security checks
        if (!$this->securityChecks->nonceIsSame($confirmationRedirect, $nonce)) {
            throw new FailedSecurityChecksException(
                'nonce',
                $nonce,
                $confirmationRedirect->getState()
            );
        }

        if (!$this->securityChecks->hostnameIsValid($confirmationRedirect)) {
            throw new FailedSecurityChecksException(
                'shop',
                'match for pattern '.SecurityChecks::VALID_HOSTNAME_REGEX,
                $confirmationRedirect->getShop()
            );
        }

        if (!$this->securityChecks->hmacIsValid($confirmationRedirect, $credentials)) {
            throw new FailedSecurityChecksException(
                'hmac',
                $this->securityChecks->generateHmac($confirmationRedirect, $credentials),
                $confirmationRedirect->getHmac()
            );
        }

        // Prepare request parameters
        $requestUri = $this->confirmationRedirectTransformer->toRequestAccessTokenUri($confirmationRedirect);
        $requestBody = $this->confirmationRedirectTransformer->toRequestAccessTokenPostBody($confirmationRedirect, $credentials);

        // Create code exchange request
        return $this->httpClient->postAsync($requestUri, [
            RequestOptions::HEADERS => self::REQUEST_PERMANENT_ACCESS_TOKEN_HEADERS,
            RequestOptions::MULTIPART => $requestBody,
        ]);
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
