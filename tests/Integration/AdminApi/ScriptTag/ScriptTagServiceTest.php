<?php

namespace Yaspa\Tests\Integration\AdminApi\ScriptTag;

use GuzzleHttp\Exception\ClientException;
use Yaspa\AdminApi\ScriptTag\Builders\CountScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ModifyExistingScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ScriptTagFields;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\ProductService;
use Yaspa\Tests\Utils\Config as TestConfig;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use PHPUnit\Framework\TestCase;

class ScriptTagServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanCreateNewScriptTag()
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

        // Create request parameters
        $scriptTag = (new ScriptTag())
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js')
            ->setEvent('onload')
            ->setDisplayScope('online_store');

        // Create new script tag
        $service = Factory::make(ScriptTagService::class);
        $newScriptTag = $service->createNewScriptTag($credentials, $scriptTag);
        $this->assertInstanceOf(ScriptTag::class, $newScriptTag);
        $this->assertNotEmpty($newScriptTag->getId());
        $this->assertNotEmpty($newScriptTag->getSrc());
        $this->assertNotEmpty($newScriptTag->getEvent());
        $this->assertNotEmpty($newScriptTag->getDisplayScope());

        return $newProduct;
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     * @param ScriptTag $originalScriptTag
     */
    public function testCanDeleteScriptTag(ScriptTag $originalScriptTag)
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
        $this->assertNotEmpty($originalScriptTag->getId());

        // Test service method
        $service = Factory::make(ScriptTagService::class);
        $result = $service->deleteProduct($credentials, $originalScriptTag->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
