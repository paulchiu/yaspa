<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Yaspa\Authentication\OAuth\Builders\AccessTokenRequest;
use Yaspa\Authentication\OAuth\Models\AuthorizationCode as AuthorizationCodeModel;
use Yaspa\Authentication\OAuth\Models\Credentials as CredentialsModel;
use Yaspa\Factory;

/**
 * Class AuthorizationCode
 * @package Yaspa\Transformers\OAuth
 */
class AuthorizationCode
{
    const EXPECTED_REDIRECT_PARAMETERS = [
        'code' => '',
        'shop' => '',
        'state' => null,
        'timestamp' => '',
        'hmac' => '',
    ];

    /**
     * @param AuthorizationCodeModel $authorizationCode
     * @param CredentialsModel $credentials
     * @return AccessTokenRequest
     */
    public function toAccessTokenRequest(
        AuthorizationCodeModel $authorizationCode,
        CredentialsModel $credentials
    ): AccessTokenRequest {
        $accessTokenRequest = Factory::make(AccessTokenRequest::class)
            ->withShop($authorizationCode->getShop())
            ->withClientId($credentials->getApiKey())
            ->withClientSecret($credentials->getApiSecretKey())
            ->withCode($authorizationCode->getCode());

        return $accessTokenRequest;
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
