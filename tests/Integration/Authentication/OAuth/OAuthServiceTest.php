<?php

namespace Yaspa\Tests\Integration\Authentication\OAuth;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\OAuth\Builders\NewDelegateAccessTokenRequest;
use Yaspa\Authentication\OAuth\OAuthService;
use Yaspa\Authentication\OAuth\Builders\Scopes;
use Yaspa\Factory;
use Yaspa\Authentication\OAuth\Models\AccessToken;
use Yaspa\Tests\Utils\Config as TestConfig;

class OAuthServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanDelegateAccessToken()
    {
        // Prepare parameters
        $testConfig = new TestConfig();
        $testShop = $testConfig->get('shopifyShop');

        $accessToken = new AccessToken();
        $accessToken->setAccessToken($testShop->oAuthAccessToken);

        $scopes = (new Scopes())
            ->withWriteOrders()
            ->withWriteCustomers();

        $delegateAccessTokenRequest = Factory::make(NewDelegateAccessTokenRequest::class)
            ->withShop($testShop->myShopifySubdomainName)
            ->withAccessToken($accessToken)
            ->withScopes($scopes)
            ->withExpiresIn(10);

        // Test service method
        $instance = Factory::make(OAuthService::class);
        $delegateToken = $instance->createNewDelegateAccessToken($delegateAccessTokenRequest);

        // Test results
        $this->assertInstanceOf(AccessToken::class, $delegateToken);
        $this->assertNotEmpty($delegateToken->getAccessToken());
        $this->assertNotEmpty($delegateToken->getScopes());
        $this->assertNotEmpty($delegateToken->getExpiresIn());
    }

    /**
     * @group integration
     */
    public function testCanDelegateAccessTokenThatDoesNotExpire()
    {
        // Prepare parameters
        $testConfig = new TestConfig();
        $testShop = $testConfig->get('shopifyShop');

        $accessToken = new AccessToken();
        $accessToken->setAccessToken($testShop->oAuthAccessToken);

        $scopes = (new Scopes())
            ->withWriteOrders()
            ->withWriteCustomers();

        $delegateAccessTokenRequest = Factory::make(NewDelegateAccessTokenRequest::class)
            ->withShop($testShop->myShopifySubdomainName)
            ->withAccessToken($accessToken)
            ->withScopes($scopes);

        // Test service method
        $instance = Factory::make(OAuthService::class);
        $delegateToken = $instance->createNewDelegateAccessToken($delegateAccessTokenRequest);

        // Test results
        $this->assertInstanceOf(AccessToken::class, $delegateToken);
        $this->assertNotEmpty($delegateToken->getAccessToken());
        $this->assertNotEmpty($delegateToken->getScopes());
        $this->assertEmpty($delegateToken->getExpiresIn());
    }
}
