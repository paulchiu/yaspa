<?php

namespace Yaspa\Tests\Unit\AdminApi\Metafield;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldsRequest;
use Yaspa\AdminApi\Metafield\MetafieldService;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

/**
 * Class MetafieldServiceTest
 *
 * @package Yaspa\Tests\Unit\AdminApi\Metafield
 *
 * Get resource metafields are tested in resource specific test cases.
 *
 * For example, getting product metafields are tested in:
 *
 * `\Yaspa\Tests\Unit\AdminApi\Product\ProductServiceTest::testCanGetProductMetafields`
 */
class MetafieldServiceTest extends TestCase
{
    public function testCanCreateNewMetafield()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'metafield' => [
                        'id' => 3,
                        'key' => 'foo',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $metafield = (new Metafield())
            ->setNamespace('inventory')
            ->setKey('warehouse')
            ->setValue(25)
            ->setValueType('integer');

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $createdMetafield = $service->createNewMetafield($credentials, $metafield);
        $this->assertInstanceOf(Metafield::class, $createdMetafield);
    }

    public function testCanGetAllMetafields()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'metafields' => [
                        [
                            'id' => 3,
                            'key' => 'foo',
                        ],
                        [
                            'id' => 5,
                            'key' => 'bar',
                        ],
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetMetafieldsRequest::class)
            ->withCredentials($credentials);

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafields = $service->getMetafields($request);
        $this->assertNotEmpty($metafields);
    }

    public function testCanGetASingleStoreMetafieldById()
    {
        // Create mock data
        $storeMetafield = new Metafield();
        $storeMetafield
            ->setId(3)
            ->setKey('foo')
            ->setValue('bar');

        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'metafield' => [
                        'id' => $storeMetafield->getId(),
                        'key' => $storeMetafield->getKey(),
                        'value' => $storeMetafield->getValue(),
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafield = $service->getMetafieldById($credentials, $storeMetafield->getId());
        $this->assertEquals($storeMetafield->getId(), $metafield->getId());
        $this->assertEquals($storeMetafield->getKey(), $metafield->getKey());
        $this->assertEquals($storeMetafield->getValue(), $metafield->getValue());
    }

    public function testCanUpdateAStoreMetafield()
    {
        // Create mock data
        $storeMetafield = new Metafield();
        $storeMetafield
            ->setId(3)
            ->setKey('foo')
            ->setValue('bar');

        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'metafield' => [
                        'id' => $storeMetafield->getId(),
                        'key' => $storeMetafield->getKey(),
                        'value' => $storeMetafield->getValue(),
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Get and test results
        $service = Factory::make(MetafieldService::class);
        $metafield = $service->updateMetafield($credentials, $storeMetafield);
        $this->assertEquals($storeMetafield->getId(), $metafield->getId());
        $this->assertEquals($storeMetafield->getKey(), $metafield->getKey());
        $this->assertEquals($storeMetafield->getValue(), $metafield->getValue());
    }

    public function testCanDeleteMetafieldById()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeEmptyJsonResponse(200),
            ]
        );
        Factory::inject(Client::class, $client);


        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test service method
        $service = Factory::make(MetafieldService::class);
        $result = $service->deleteMetafieldById($credentials, 3);

        // Test results
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
