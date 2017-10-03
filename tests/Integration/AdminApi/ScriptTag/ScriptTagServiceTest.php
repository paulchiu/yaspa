<?php

namespace Yaspa\Tests\Integration\AdminApi\ScriptTag;

use GuzzleHttp\Exception\ClientException;
use DateTime;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\ScriptTag\Builders\CountScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ModifyExistingScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ScriptTagFields;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\ScriptTagService;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class ScriptTagServiceTest extends TestCase
{
    /**
     * @group integration
     * @return ScriptTag
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
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js')
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
     * @return ScriptTag
     */
    public function testCanCreateWithOrderStatusDisplayScope()
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
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.js')
            ->setEvent('onload')
            ->setDisplayScope('order_status');

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

        // Create new Script Tag
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
     * @group integration
     */
    public function testCanGetScriptTags()
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
            ->withEvent()
            ->withCreatedAt()
            ->withUpdatedAt()
            ->withDisplayScope();
        $request = Factory::make(GetScriptTagsRequest::class)
            ->withCredentials($credentials)
            ->withScriptTagFields($fields)
            ->withLimit(1)
            ->withCreatedAtMin(new DateTime('-1 year'));

        // Get and test results
        $service = Factory::make(ScriptTagService::class);
        $scriptTags = $service->getScriptTags($request);

        // Confirm we can move through pages seamlessly
        $targetIterations = 2;
        $timesIterated = 0;
        foreach ($scriptTags as $index => $scriptTag) {
            if ($timesIterated >= $targetIterations) {
                break;
            }

            $this->assertInstanceOf(ScriptTag::class, $scriptTag);
            $timesIterated++;
        }
        $this->assertGreaterThanOrEqual($targetIterations, $timesIterated);
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

        // Test service method
        $service = Factory::make(ScriptTagService::class);
        $result = $service->countScriptTags($request);
        $this->assertGreaterThan(0, $result);
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     * @param ScriptTag $originalScriptTag
     */
    public function testCanModifyExistingScriptTagWithNewSrc(ScriptTag $originalScriptTag)
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
        $scriptTagUpdate = (new ScriptTag())
            ->setId($originalScriptTag->getId())
            ->setSrc('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.0/moment.min.js');
        $request = Factory::make(ModifyExistingScriptTagRequest::class)
            ->withCredentials($credentials)
            ->withScriptTag($scriptTagUpdate);

        // Get and Test results
        $service = Factory::make(ScriptTagService::class);
        $updatedScriptTag = $service->modifyExistingScriptTag($request);
        $this->assertEquals($originalScriptTag->getId(), $updatedScriptTag->getId());
        $this->assertNotEquals($originalScriptTag->getSrc(), $updatedScriptTag->getSrc());
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     * @param ScriptTag $scriptTag
     */
    public function testCanGetScriptTagById(ScriptTag $scriptTag)
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
        $service = Factory::make(ScriptTagService::class);
        $retrievedScriptTag = $service->getScriptTag($credentials, $scriptTag->getId());
        $this->assertEquals($scriptTag->getId(), $retrievedScriptTag->getId());
        $this->assertNotEmpty($retrievedScriptTag->getSrc());
    }

    /**
     * @depends testCanCreateNewScriptTag
     * @group integration
     * @param ScriptTag $scriptTag
     */
    public function testCanDeleteScriptTag(ScriptTag $scriptTag)
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
        $this->assertNotEmpty($scriptTag->getId());

        // Test service method
        $service = Factory::make(ScriptTagService::class);
        $result = $service->deleteScriptTag($credentials, $scriptTag->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}

