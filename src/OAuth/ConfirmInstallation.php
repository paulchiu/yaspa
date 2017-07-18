<?php

namespace Yaspa\OAuth;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\Models\Authentication\OAuth\ConfirmationRedirect;
use Yaspa\Models\Authentication\OAuth\Credentials;
use Yaspa\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Transformers\OAuth\ConfirmationRedirect as ConfirmationRedirectTransformer;

/**
 * Class ConfirmInstallation
 * @package Yaspa\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Provides functionality defined in OAuth confirmation documentation.
 */
class ConfirmInstallation
{
    /** @var SecurityChecks $securityChecks */
    protected $securityChecks;
    /** @var ConfirmationRedirectTransformer $confirmationRedirectTransformer */
    protected $confirmationRedirectTransformer;

    /**
     * ConfirmInstallation constructor.
     * @param SecurityChecks $securityChecks
     * @param ConfirmationRedirectTransformer $confirmationRedirectTransformer
     */
    public function __construct(
        SecurityChecks $securityChecks,
        ConfirmationRedirectTransformer $confirmationRedirectTransformer
    ) {
        $this->securityChecks = $securityChecks;
        $this->confirmationRedirectTransformer = $confirmationRedirectTransformer;
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
        string $nonce = null
    ): PromiseInterface {
        // Perform security checks
        if ($nonce && !$this->securityChecks->nonceIsSame($confirmationRedirect, $nonce)) {
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
        $guzzle = new Client();
        return $guzzle->postAsync($requestUri, [
            'json' => $requestBody,
        ]);
    }
}
