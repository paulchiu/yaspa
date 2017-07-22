<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use GuzzleHttp\Psr7\Uri;
use Yaspa\Authentication\OAuth\Models\AuthorizationCode as AuthorizationCodeModel;
use Yaspa\Authentication\OAuth\Models\Credentials as CredentialsModel;

/**
 * Class AuthorizationCode
 * @package Yaspa\Transformers\OAuth
 */
class AuthorizationCode
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
     * @param AuthorizationCodeModel $authorizationCode
     * @return Uri
     */
    public function toRequestAccessTokenUri(AuthorizationCodeModel $authorizationCode): Uri {
        $baseUri = sprintf(self::REQUEST_ACCESS_TOKEN_URI_TEMPLATE, $authorizationCode->getShop());

        return new Uri($baseUri);
    }

    /**
     * Generates the POST body content for a request access token request.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @param AuthorizationCodeModel $authorizationCode
     * @param CredentialsModel $credentials
     * @return array
     */
    public function toRequestAccessTokenPostBody(
        AuthorizationCodeModel $authorizationCode,
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
                'contents' => $authorizationCode->getCode(),
            ],
        ];
    }

    /**
     * Parse an array of authorization code values. This will usually be
     * the GET parameters sent by Shopify as described in their guide.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @param array $redirectParameters
     * @return AuthorizationCodeModel
     */
    public function fromArray(array $redirectParameters): AuthorizationCodeModel
    {
        $fullSetRedirectParameters = array_replace(self::EXPECTED_REDIRECT_PARAMETERS, $redirectParameters);

        $authorizationCode = (new AuthorizationCodeModel())
            ->setCode($fullSetRedirectParameters['code'])
            ->setShop($fullSetRedirectParameters['shop'])
            ->setState($fullSetRedirectParameters['state'])
            ->setTimestamp($fullSetRedirectParameters['timestamp'])
            ->setHmac($fullSetRedirectParameters['hmac']);

        return $authorizationCode;
    }
}
