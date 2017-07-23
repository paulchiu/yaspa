<?php

namespace Yaspa\Authentication\Factory;

use Yaspa\Authentication\Builders\ApiCredentials as ApiCredentialsBuilder;
use Yaspa\Authentication\OAuth\Models\AccessToken as OAuthAccessToken;
use Yaspa\Authentication\PrivateAuthentication\Models\Credentials as PrivateAuthCredentials;
use Yaspa\Factory;

/**
 * Class ApiCredentials
 *
 * @package Yaspa\Authentication\Factory
 *
 * Factory class to create API credential builders quickly.
 */
class ApiCredentials
{
    /**
     * Make API credentials from an OAuth access token for a particular shop.
     *
     * @param string $shop
     * @param string $accessToken
     * @return ApiCredentialsBuilder
     */
    public function makeOAuth(
        string $shop,
        string $accessToken
    ): ApiCredentialsBuilder {
        $token = new OAuthAccessToken();
        $token->setAccessToken($accessToken);

        return Factory::make(ApiCredentialsBuilder::class)
            ->withShop($shop)
            ->withOAuthAccessToken($token);
    }

    /**
     * Make API credentials from private app auth details.
     *
     * @param string $shop
     * @param string $apiKey
     * @param string $password
     * @return ApiCredentialsBuilder
     */
    public function makePrivate(
        string $shop,
        string $apiKey,
        string $password
    ): ApiCredentialsBuilder {
        $privateCredentials = new PrivateAuthCredentials();
        $privateCredentials
            ->setApiKey($apiKey)
            ->setPassword($password);

        return Factory::make(ApiCredentialsBuilder::class)
            ->withShop($shop)
            ->withPrivateAuthCredentials($privateCredentials);
    }
}
