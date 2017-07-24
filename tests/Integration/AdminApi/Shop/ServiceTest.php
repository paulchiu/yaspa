<?php

namespace Yaspa\Tests\Integration\AdminApi\Shop;

use DateTime;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Shop\Models\Shop;
use Yaspa\AdminApi\Shop\Service;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class ServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanGetShopWithOAuthToken()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth(
                $shop->myShopifySubdomainName,
                $shop->oAuthAccessToken
            );

        // Test method
        $service = Factory::make(Service::class);
        $shop = $service->getShop($credentials);
        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertInstanceOf(DateTime::class, $shop->getCreatedAt());
    }

    /**
     * @group integration
     */
    public function testCanGetShopWithPrivateCredentials()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Test method
        $service = Factory::make(Service::class);
        $shop = $service->getShop($credentials);
        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertInstanceOf(DateTime::class, $shop->getCreatedAt());
    }
}
