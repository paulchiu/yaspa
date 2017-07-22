<?php

namespace Yaspa\Authentication\OAuth;

use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Authentication\OAuth\Models\AuthorizationCode;
use Yaspa\Authentication\OAuth\Models\Credentials;
use Yaspa\Authentication\OAuth\Models\SecurityCheckResult;

/**
 * Class SecurityChecks
 * @package Yaspa\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Provides security checks defined in OAuth confirmation documentation.
 */
class SecurityChecks
{
    const VALID_HOSTNAME_REGEX = '/^[a-zA-Z0-9-.]+.myshopify.com$/';
    const HMAC_ALGORITHM = 'sha256';

    /**
     * @param AuthorizationCode $authorizationCode
     * @param Credentials $credentials
     * @param null|string $nonce
     * @return SecurityCheckResult
     */
    public function checkAuthorizationCode(
        AuthorizationCode $authorizationCode,
        Credentials $credentials,
        ?string $nonce = null
    ): SecurityCheckResult {
        // Prepare result
        $result = new SecurityCheckResult(false);

        // Perform security checks
        if (!$this->nonceIsSame($authorizationCode, $nonce)) {
            $result->setFailureException(new FailedSecurityChecksException(
                'nonce',
                $nonce,
                $authorizationCode->getState()
            ));
        }

        if (!$this->hostnameIsValid($authorizationCode)) {
            $result->setFailureException(new FailedSecurityChecksException(
                'shop',
                'match for pattern '.SecurityChecks::VALID_HOSTNAME_REGEX,
                $authorizationCode->getShop()
            ));
        }

        if (!$this->hmacIsValid($authorizationCode, $credentials)) {
            $result->setFailureException(new FailedSecurityChecksException(
                'hmac',
                $this->generateHmac($authorizationCode, $credentials),
                $authorizationCode->getHmac()
            ));
        }

        // Determine whether the code has passed
        $result->setPassed(empty($result->getFailureException()));

        // Return result
        return $result;
    }

    /**
     * Ensure the provided nonce is the same one that your application provided to Shopify during the Step 2: Asking
     * for permission.
     *
     * @param AuthorizationCode $authorizationCode
     * @param string $nonce
     * @return bool
     */
    public function nonceIsSame(AuthorizationCode $authorizationCode, ?string $nonce): bool
    {
        $nonceEqualsState = $authorizationCode->getState() === $nonce;
        $bothEmpty = empty($authorizationCode->getState()) && empty($nonce);

        return $nonceEqualsState || $bothEmpty;
    }

    /**
     * Ensure the provided hostname parameter is a valid hostname, ends with myshopify.com, and does not contain
     * characters other than letters (a-z), numbers (0-9), dots, and hyphens.
     *
     * @param AuthorizationCode $authorizationCode
     * @return bool
     */
    public function hostnameIsValid(AuthorizationCode $authorizationCode): bool
    {
        return preg_match(self::VALID_HOSTNAME_REGEX, $authorizationCode->getShop()) === 1;
    }

    /**
     * Confirms the returned HMAC matches our independently generated one.
     *
     * This is just a convenience function for self::generateHmac
     *
     * @param AuthorizationCode $authorizationCode
     * @param Credentials $credentials
     * @return bool
     */
    public function hmacIsValid(
        AuthorizationCode $authorizationCode,
        Credentials $credentials
    ): bool {
        $untrustedHmac = $authorizationCode->getHmac();
        $trustedHmac = $this->generateHmac($authorizationCode, $credentials);

        return $untrustedHmac === $trustedHmac;
    }

    /**
     * Generates a HMAC value based on Shopify's instructions.
     *
     * Please note that this method is tested through self::hmacIsValid
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#verification
     * @param AuthorizationCode $authorizationCode
     * @param Credentials $credentials
     * @return string
     */
    public function generateHmac(
        AuthorizationCode $authorizationCode,
        Credentials $credentials
    ): string {
        $queryString = http_build_query([
            'code' => $authorizationCode->getCode(),
            'shop' => $authorizationCode->getShop(),
            'state' => $authorizationCode->getState(),
            'timestamp' => $authorizationCode->getTimestamp(),
        ]);

        $hmac = hash_hmac(self::HMAC_ALGORITHM, $queryString, $credentials->getApiSecretKey());

        return $hmac;
    }
}
