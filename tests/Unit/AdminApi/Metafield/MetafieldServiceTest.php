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
}
