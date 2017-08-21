<?php

namespace Yaspa\Tests\Integration\AdminApi\Metafield;

use Yaspa\AdminApi\Metafield\Builders\MetafieldFields;
use Yaspa\AdminApi\Metafield\MetafieldService;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldsRequest;
use Yaspa\Tests\Utils\Config as TestConfig;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use PHPUnit\Framework\TestCase;

class MetafieldServiceTest extends TestCase
{
    /**
     * @group integration
     * @todo Finish create new metafield
     */
    public function testCanGetAllMetafieldsAfterTheSpecifiedId()
    {
        $this->markTestIncomplete();

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

    }
    /**
     * @group integration
     * @todo Finish create new metafield
     */
    public function testCanGetAllMetafieldsThatBelongToAStore()
    {
        $this->markTestIncomplete();

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
        $request = Factory::make(GetMetafieldsRequest::class)
            ->withCredentials($credentials);

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafields = $service->getMetafields($request);
        dump($metafields);
    }
}
