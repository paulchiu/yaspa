<?php

namespace Yaspa\Tests\Integration\AdminApi\ScriptTag;

use GuzzleHttp\Exception\ClientException;
use Yaspa\AdminApi\ScriptTag\Builders\CountScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ModifyExistingScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ScriptTagFields;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\ScriptTagService;
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

        return $newScriptTag;
    }

    /**
     * @group integration
     */
    public function testCannotCreateAScriptTagWithoutSrc()
    {
        // Expect Guzzle client exception due to response 422
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

        // Create request parameters
        $scriptTag = (new ScriptTag())->setEvent('onload')
            ->setDisplayScope('online_store');

        // Create new scripttag
        $service = Factory::make(ScriptTagService::class);
        $service->createNewScriptTag($credentials, $scriptTag);
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     */
    public function testCanGetAllScriptTagsShowingOnlySomeAttributes()
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

        // Create request
        $fields = Factory::make(ScriptTagFields::class)
            ->withId()
            ->withSrc()
            ->withEvent();
        $request = Factory::make(GetScriptTagsRequest::class)
            ->withCredentials($credentials)
            ->withScriptTagFields($fields)
            ->withLimit(1);

        // Get and test results
        $service = Factory::make(ScriptTagService::class);
        $scriptTags = $service->getScriptTags($request);
        $this->assertTrue(is_iterable($scriptTags));
        foreach ($scriptTags as $scriptTag) {
            $this->assertInstanceOf(ScriptTag::class, $scriptTag);
            $this->assertNotEmpty($scriptTag->getId());
            break;
        }
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     */
    public function testCanGetAllScriptTags()
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

        // Create request
        $request = Factory::make(GetScriptTagsRequest::class)
            ->withCredentials($credentials)
            ->withLimit(20);

        // Get and test results
        $service = Factory::make(ScriptTagService::class);
        $scriptTags = $service->getScriptTags($request);
        $this->assertTrue(is_iterable($scriptTags));
        foreach ($scriptTags as $scriptTag) {
            $this->assertInstanceOf(ScriptTag::class, $scriptTag);
            $this->assertNotEmpty($scriptTag->getId());
            break;
        }
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     * @param ScriptTag $newScriptTag
     */
    public function testCanGetAListOfSpecificScriptTags(ScriptTag $newScriptTag)
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

        // Create request
        $request = Factory::make(GetScriptTagsRequest::class)
            ->withCredentials($credentials)
            ->withIds([$newScriptTag->getId()]);

        // Get and test results
        $service = Factory::make(ScriptTagService::class);
        $scriptTags = $service->getScriptTags($request);
        $this->assertTrue(is_iterable($scriptTags));
        foreach ($scriptTags as $scriptTag) {
            $this->assertInstanceOf(ScriptTag::class, $scriptTag);
            $this->assertEquals($newScriptTag->getId(), $scriptTag->getId());
        }
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     */
    public function testCanCountAllScriptTags()
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

        // Create request
        $request = Factory::make(CountScriptTagsRequest::class)
            ->withCredentials($credentials);

        // Get and test results
        $service = Factory::make(ScriptTagService::class);
        $scriptTagsCount = $service->countScriptTags($request);
        $this->assertGreaterThan(0, $scriptTagsCount);
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
        $result = $service->deleteScriptTag($credentials, $originalScriptTag->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
