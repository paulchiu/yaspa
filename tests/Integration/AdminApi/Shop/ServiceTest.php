<?php

namespace Yaspa\Tests\Integration\AdminApi\Shop;

use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Shop\Service;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class ServiceTest extends TestCase
{
    /**
     * @todo Update scopes to easily add all
     */
    public function testCanGetShopWithOAuthToken()
    {
        $this->markTestIncomplete();
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
        dump($service->getShop($credentials));
    }
}
