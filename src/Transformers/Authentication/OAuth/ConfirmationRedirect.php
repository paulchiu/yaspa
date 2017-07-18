<?php

namespace Yaspa\Transformers\OAuth;

use GuzzleHttp\Psr7\Uri;
use Yaspa\Models\Authentication\OAuth\ConfirmationRedirect as ConfirmationRedirectModel;
use Yaspa\Models\Authentication\OAuth\Credentials as CredentialsModel;

/**
 * Class ConfirmationRedirect
 * @package Yaspa\Transformers\OAuth
 */
class ConfirmationRedirect
{
    const REQUEST_ACCESS_TOKEN_URI_TEMPLATE = 'https://%s/admin/oauth/access_token';

    /**
     * Generates a request access token URI from a confirmation redirect response.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @param ConfirmationRedirectModel $confirmationRedirect
     * @return Uri
     */
    public function toRequestAccessTokenUri(ConfirmationRedirectModel $confirmationRedirect): Uri {
        // Prepare parameters
        $baseUri = sprintf(self::REQUEST_ACCESS_TOKEN_URI_TEMPLATE, $confirmationRedirect->getShop());

        return new Uri($baseUri);
    }

    /**
     * Generates the POST body content for a request access token request.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @param ConfirmationRedirectModel $confirmationRedirect
     * @param CredentialsModel $credentials
     * @return array
     */
    public function toRequestAccessTokenPostBody(
        ConfirmationRedirectModel $confirmationRedirect,
        CredentialsModel $credentials
    ) {
        return [
            'client_id' => $credentials->getApiKey(),
            'client_secret' => $credentials->getApiSecretKey(),
            'code' => $confirmationRedirect->getCode(),
        ];
    }
}
