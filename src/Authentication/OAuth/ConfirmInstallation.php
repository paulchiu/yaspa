<?php

namespace Yaspa\Authentication\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Authentication\OAuth\Models\ConfirmationRedirect;
use Yaspa\Authentication\OAuth\Models\Credentials;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as AccessTokenTransformer;
use Yaspa\Authentication\OAuth\Transformers\ConfirmationRedirect as ConfirmationRedirectTransformer;

/**
 * Class ConfirmInstallation
 * @package Yaspa\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Provides functionality defined in OAuth confirmation documentation.
 *
 * For an example of how this should be used, see `tests/Manual/oauth/confirm-installation.php`
 */
class ConfirmInstallation
{
    const REQUEST_PERMANENT_ACCESS_TOKEN_HEADERS = ['Accept' => 'application/json'];

    /** @var Client $httpClient */
    protected $httpClient;
    /** @var SecurityChecks $securityChecks */
    protected $securityChecks;
    /** @var ConfirmationRedirectTransformer $confirmationRedirectTransformer */
    protected $confirmationRedirectTransformer;
    /** @var AccessTokenTransformer $accessTokenTransformer */
    protected $accessTokenTransformer;

    /**
     * ConfirmInstallation constructor.
     *
     * @param Client $httpClient
     * @param SecurityChecks $securityChecks
     * @param ConfirmationRedirectTransformer $confirmationRedirectTransformer
     * @param AccessTokenTransformer $accessTokenTransformer
     */
    public function __construct(
        Client $httpClient,
        SecurityChecks $securityChecks,
        ConfirmationRedirectTransformer $confirmationRedirectTransformer,
        AccessTokenTransformer $accessTokenTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->securityChecks = $securityChecks;
        $this->confirmationRedirectTransformer = $confirmationRedirectTransformer;
        $this->accessTokenTransformer = $accessTokenTransformer;
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
}
