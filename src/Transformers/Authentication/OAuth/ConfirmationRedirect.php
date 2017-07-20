<?php

namespace Yaspa\Transformers\Authentication\OAuth;

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
    const EXPECTED_REDIRECT_PARAMETERS = [
        'code' => '',
        'shop' => '',
        'state' => null,
        'timestamp' => '',
        'hmac' => '',
    ];

    /**
     * Generates a request access token URI from a confirmation redirect response.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @param ConfirmationRedirectModel $confirmationRedirect
     * @return Uri
     */
    public function toRequestAccessTokenUri(ConfirmationRedirectModel $confirmationRedirect): Uri {
        $baseUri = sprintf(self::REQUEST_ACCESS_TOKEN_URI_TEMPLATE, $confirmationRedirect->getShop());

        return new Uri($baseUri);
    }

    /**
     * Generates the POST body content for a request access token request.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @param ConfirmationRedirectModel $confirmationRedirect
     * @param CredentialsModel $credentials
     * @return array
     */
    public function toRequestAccessTokenPostBody(
        ConfirmationRedirectModel $confirmationRedirect,
        CredentialsModel $credentials
    ): array {
        return [
            [
                'name' => 'client_id',
                'contents' => $credentials->getApiKey(),
            ],
            [
                'name' => 'client_secret',
                'contents' => $credentials->getApiSecretKey(),
            ],
            [
                'name' => 'code',
                'contents' => $confirmationRedirect->getCode(),
            ],
        ];
    }

    /**
     * Parse an array of confirmation redirect values. This will usually be
     * the GET parameters sent by Shopify as described in their guide.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @param array $redirectParameters
     * @return ConfirmationRedirectModel
     */
    public function fromArray(array $redirectParameters): ConfirmationRedirectModel
    {
        $fullSetRedirectParameters = array_replace(self::EXPECTED_REDIRECT_PARAMETERS, $redirectParameters);

        $confirmationRedirect = (new ConfirmationRedirectModel())
            ->setCode($fullSetRedirectParameters['code'])
            ->setShop($fullSetRedirectParameters['shop'])
            ->setState($fullSetRedirectParameters['state'])
            ->setTimestamp($fullSetRedirectParameters['timestamp'])
            ->setHmac($fullSetRedirectParameters['hmac']);

        return $confirmationRedirect;
    }
}
