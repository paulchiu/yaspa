<?php

namespace Yaspa\Tests\Unit\AdminApi\Shop;

use DateTime;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Shop\Models\Shop;
use Yaspa\AdminApi\Shop\Service;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class ServiceTest extends TestCase
{
    public function testCanGetShop()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithJsonResponse(
            00,
            [
                'shop' => [
                    'created_at' => '2017-07-16T10:29:53+10:00',
                ],
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test method
        $service = Factory::make(Service::class);
        $shop = $service->getShop($credentials);
        $this->assertInstanceOf(Shop::class, $shop);
        $this->assertInstanceOf(DateTime::class, $shop->getCreatedAt());
    }
}
