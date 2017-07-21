<?php

namespace Yaspa\Tests\Integration\Authentication\OAuth;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\OAuth\DelegateAccess;
use Yaspa\Authentication\OAuth\Scopes;
use Yaspa\Factory;
use Yaspa\Models\Authentication\OAuth\AccessToken;
use Yaspa\Tests\Utils\Config as TestConfig;

class DelegateAccessTest extends TestCase
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

        $instance = Factory::make(DelegateAccess::class);
        $delegateToken = $instance->createNewDelegateAccessToken(
            $testShop->myShopifySubdomainName,
            $accessToken,
            $scopes,
            10
        );
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

        $instance = Factory::make(DelegateAccess::class);
        $delegateToken = $instance->createNewDelegateAccessToken(
            $testShop->myShopifySubdomainName,
            $accessToken,
            $scopes
        );
        $this->assertInstanceOf(AccessToken::class, $delegateToken);
        $this->assertNotEmpty($delegateToken->getAccessToken());
        $this->assertNotEmpty($delegateToken->getScopes());
        $this->assertEmpty($delegateToken->getExpiresIn());
    }
}
