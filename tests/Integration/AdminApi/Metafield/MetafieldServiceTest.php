<?php

namespace Yaspa\Tests\Integration\AdminApi\Metafield;

use GuzzleHttp\Exception\ClientException;
use Yaspa\AdminApi\Metafield\MetafieldService;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldsRequest;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\Tests\Utils\Config as TestConfig;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class MetafieldServiceTest
 *
 * @package Yaspa\Tests\Integration\AdminApi\Metafield
 *
 * Please note that resource related tests at in resource specific tests. These are:
 *
 * - Get metafields that belong to a product
 * - Get metafields that belong to a product image
 */
class MetafieldServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanCreateANewMetafieldForAStore()
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
        $metafield = (new Metafield())
            ->setNamespace('inventory')
            ->setKey('warehouse')
            ->setValue(25)
            ->setValueType('integer');

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $createdMetafield = $service->createNewMetafield($credentials, $metafield);
        $this->assertNotEmpty($createdMetafield->getId());

        return $createdMetafield;
    }

    /**
     * @group integration
     */
    public function testCannotCreateAMetafieldWithoutAKey()
    {
        // Expect Guzzle client exception due to response 422, unprocessable entity
        $this->expectException(ClientException::class);

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
        $metafield = new Metafield();

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $newMetafield = $service->createNewMetafield($credentials, $metafield);

        return $newMetafield;
    }

    /**
     * @depends testCanCreateANewMetafieldForAStore
     * @group integration
     * @param Metafield $originalMetafield
     */
    public function testCanGetAllMetafieldsAfterTheSpecifiedId(Metafield $originalMetafield)
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
        $request = Factory::make(GetMetafieldsRequest::class)
            ->withCredentials($credentials)
            ->withSinceId($originalMetafield->getId() - 1);

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafields = $service->getMetafields($request);
        $this->assertNotEmpty($metafields);
    }

    /**
     * @depends testCanCreateANewMetafieldForAStore
     * @group integration
     */
    public function testCanGetAllMetafieldsThatBelongToAStore()
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
        $request = Factory::make(GetMetafieldsRequest::class)
            ->withCredentials($credentials)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafields = $service->getMetafields($request);
        $this->assertCount(1, $metafields);

        return $metafields;
    }

    /**
     * @depends testCanCreateANewMetafieldForAStore
     * @group integration
     * @param Metafield $storeMetafield
     */
    public function testCanGetASingleStoreMetafieldById(Metafield $storeMetafield)
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

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafield = $service->getMetafieldById($credentials, $storeMetafield->getId());
        $this->assertEquals($storeMetafield->getId(), $metafield->getId());
        $this->assertEquals($storeMetafield->getKey(), $metafield->getKey());
        $this->assertEquals($storeMetafield->getValue(), $metafield->getValue());
    }

    /**
     * @depends testCanCreateANewMetafieldForAStore
     * @group integration
     * @param Metafield $storeMetafield
     */
    public function testCanUpdateAStoreMetafield(Metafield $storeMetafield)
    {
        // Create fixture and confirm uniqueness
        $newValue = 3;
        $this->assertNotEquals($storeMetafield->getValue(), $newValue);


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
        $storeMetafield->setValue($newValue);

        // Test method and results
        $service = Factory::make(MetafieldService::class);
        $updatedMetafield = $service->updateMetafield($credentials, $storeMetafield);
        $this->assertEquals($storeMetafield->getId(), $updatedMetafield->getId());
        $this->assertEquals($storeMetafield->getKey(), $updatedMetafield->getKey());
        $this->assertEquals($storeMetafield->getValue(), $updatedMetafield->getValue());
    }

    /**
     * @depends testCanCreateANewMetafieldForAStore
     * @group integration
     * @param Metafield $originalMetafield
     */
    public function testCanDeleteMetafieldById(Metafield $originalMetafield)
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

        // Test pre-state
        $this->assertNotEmpty($originalMetafield->getId());

        // Test service method
        $service = Factory::make(MetafieldService::class);
        $result = $service->deleteMetafieldById($credentials, $originalMetafield->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }

    /**
     * @todo Do "Get a single product metafield by its ID"
     */
}
