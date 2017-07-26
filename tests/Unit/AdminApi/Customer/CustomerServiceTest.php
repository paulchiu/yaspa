<?php

namespace Yaspa\Tests\Unit\AdminApi\Customer;

use DateTime;
use GuzzleHttp\Client;
use Iterator;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\MockGuzzleClient;

class CustomerServiceTest extends TestCase
{
    public function testCanGetCustomers()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customers' => [
                        [
                            'id' => 3,
                        ],
                        [
                            'id' => 5,
                        ],
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'customers' => [],
                ]),
            ]
        );
        Factory::inject(Client::class, $client, 2);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetCustomersRequest::class)
            ->withCredentials($credentials)
            ->withLimit(2)
            ->withCreatedAtMin(new DateTime('-1 year'));

        // Test method
        $service = Factory::make(CustomerService::class);
        $customers = $service
            ->getCustomers($request)
            ->withPostCallDelaySeconds(0);
        $this->assertInstanceOf(Iterator::class, $customers);
        $timesIterated = 0;
        foreach ($customers as $customer) {
            $this->assertInstanceOf(Customer::class, $customer);
            $timesIterated++;
        }
        $this->assertEquals(2, $timesIterated);

        // Return customers for dependent tests
        return $customers;
    }

    /**
     * @depends testCanGetCustomers
     * @param Iterator $customers
     */
    public function testCanGetCustomersAndCount(Iterator $customers)
    {
        $this->assertEquals(2, iterator_count($customers));
    }

    public function testCanGetCustomersSpanningMultiplePages()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customers' => [
                        [
                            'id' => 3,
                        ],
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'customers' => [
                        [
                            'id' => 5,
                        ],
                    ],
                ]),
                $mockClientUtil->makeJsonResponse(200, [
                    'customers' => [],
                ]),
            ]
        );
        Factory::inject(Client::class, $client, 2);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(GetCustomersRequest::class)
            ->withCredentials($credentials)
            ->withLimit(1)
            ->withCreatedAtMin(new DateTime('-1 year'));

        // Test method
        $service = Factory::make(CustomerService::class);
        $customers = $service
            ->getCustomers($request)
            ->withPostCallDelaySeconds(0);
        $this->assertInstanceOf(Iterator::class, $customers);
        $timesIterated = 0;
        foreach ($customers as $customer) {
            $this->assertInstanceOf(Customer::class, $customer);
            $timesIterated++;
        }
        $this->assertEquals(2, $timesIterated);
    }
}
