<?php

namespace Yaspa\OAuth;

use Yaspa\Models\Authentication\OAuth\ConfirmationRedirect;
use Yaspa\Models\Authentication\OAuth\Credentials;

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
     * Ensure the provided nonce is the same one that your application provided to Shopify during the Step 2: Asking
     * for permission.
     *
     * @param ConfirmationRedirect $confirmationRedirect
     * @param string $nonce
     * @return bool
     */
    public function nonceIsSame(ConfirmationRedirect $confirmationRedirect, string $nonce): bool
    {
        $nonceEqualsState = $confirmationRedirect->getState() === $nonce;
        $bothEmpty = empty($confirmationRedirect->getState()) && empty($nonce);

        return $nonceEqualsState || $bothEmpty;
    }

    /**
     * Ensure the provided hostname parameter is a valid hostname, ends with myshopify.com, and does not contain
     * characters other than letters (a-z), numbers (0-9), dots, and hyphens.
     *
     * @param ConfirmationRedirect $confirmationRedirect
     * @return bool
     */
    public function hostnameIsValid(ConfirmationRedirect $confirmationRedirect): bool
    {
        return preg_match(self::VALID_HOSTNAME_REGEX, $confirmationRedirect->getShop()) === 1;
    }

    /**
     * Confirms the returned HMAC matches our independently generated one.
     *
     * This is just a convenience function for self::generateHmac
     *
     * @param ConfirmationRedirect $confirmationRedirect
     * @param Credentials $credentials
     * @return bool
     */
    public function hmacIsValid(
        ConfirmationRedirect $confirmationRedirect,
        Credentials $credentials
    ): bool {
        $untrustedHmac = $confirmationRedirect->getHmac();
        $trustedHmac = $this->generateHmac($confirmationRedirect, $credentials);

        return $untrustedHmac === $trustedHmac;
    }

    /**
     * Generates a HMAC value based on Shopify's instructions.
     *
     * Please note that this method is tested through self::hmacIsValid
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#verification
     * @param ConfirmationRedirect $confirmationRedirect
     * @param Credentials $credentials
     * @return string
     */
    public function generateHmac(
        ConfirmationRedirect $confirmationRedirect,
        Credentials $credentials
    ): string {
        $queryString = http_build_query([
            'code' => $confirmationRedirect->getCode(),
            'shop' => $confirmationRedirect->getShop(),
            'state' => $confirmationRedirect->getState(),
            'timestamp' => $confirmationRedirect->getTimestamp(),
        ]);

        $hmac = hash_hmac(self::HMAC_ALGORITHM, $queryString, $credentials->getApiSecretKey());

        return $hmac;
    }
}
