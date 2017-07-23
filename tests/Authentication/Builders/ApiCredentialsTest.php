<?php

namespace Yaspa\Tests\Authentication\Builders;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\Builders\ApiCredentials;
use Yaspa\Authentication\OAuth\Models\AccessToken as OAuthAccessToken;
use Yaspa\Authentication\PrivateAuthentication\Models\Credentials as PrivateAuthCredentials;
use Yaspa\Exceptions\MissingRequiredParameterException;
use Yaspa\Factory;

class ApiCredentialsTest extends TestCase
{
    public function testCanCreateRequestOptionsFromOAuth()
    {
        // Prepare parameters
        $shop = 'foo';
        $token = new OAuthAccessToken();
        $token->setAccessToken('bar');

        // Set expectations
        $expectedOptions = [
            'headers' => [
                'X-Shopify-Access-Token' => 'bar',
            ],
        ];

        // Test method
        $apiCredentials = Factory::make(ApiCredentials::class)
            ->withShop($shop)
            ->withOAuthAccessToken($token);
        $options = $apiCredentials->toRequestOptions();
        $this->assertEquals($expectedOptions, $options);
    }

    public function testCanCreateRequestOptionsFromPrivateCredentials()
    {
        // Prepare parameters
        $shop = 'foo';
        $privateCredentials = new PrivateAuthCredentials();
        $privateCredentials
            ->setApiKey('bar')
            ->setPassword('baz');

        // Set expectations
        $expectedOptions = [
            'auth' => [
                'bar',
                'baz',
            ],
        ];

        // Test method
        $apiCredentials = Factory::make(ApiCredentials::class)
            ->withShop($shop)
            ->withPrivateAuthCredentials($privateCredentials);
        $options = $apiCredentials->toRequestOptions();
        $this->assertEquals($expectedOptions, $options);
    }
}
