<?php

namespace Yaspa\Tests\Unit\AdminApi\Customer;

use DateTime;
use GuzzleHttp\Client;
use Iterator;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Customer\Builders\CreateNewCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\ModifyExistingCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\SearchCustomersRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\AdminApi\Customer\Models\Address;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\AdminApi\Customer\Models\CustomerInvite;
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

    public function testCanSearchCustomers()
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
        $request = Factory::make(SearchCustomersRequest::class)
            ->withCredentials($credentials)
            ->withLimit(2)
            ->withQuery('foo');

        // Test method
        $service = Factory::make(CustomerService::class);
        $customers = $service
            ->searchCustomers($request)
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

    public function testCanCreateNewCustomer()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customer' => [
                        'id' => 3,
                        'email' => 'foo@example.com',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $customer = (new Customer())
            ->setEmail('foo@example.com')
            ->setAddresses([new Address()]);
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(CreateNewCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer);

        // Test method
        $service = Factory::make(CustomerService::class);
        $customer = $service->createNewCustomer($request);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCanModifyExistingCustomer()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customer' => [
                        'id' => 3,
                        'first_name' => 'foo',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $customer = (new Customer())
            ->setId(3)
            ->setFirstName('foo');
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $request = Factory::make(ModifyExistingCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer);

        // Test method
        $service = Factory::make(CustomerService::class);
        $customer = $service->modifyExistingCustomer($request);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCanGetCustomer()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customer' => [
                        'id' => 3,
                        'email' => 'foo@example.com',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test service method
        $service = Factory::make(CustomerService::class);
        $retrievedCustomer = $service->getCustomer($credentials, 3);

        // Test results
        $this->assertNotEmpty($retrievedCustomer->getId());
        $this->assertNotEmpty($retrievedCustomer->getEmail());
    }

    public function testCanCreateAccountActivationUrl()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'account_activation_url' => 'http://foo.example.com/activate',
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');

        // Test service method
        $service = Factory::make(CustomerService::class);
        $url = $service->createAccountActivationUrl($credentials, 3);

        // Test results
        $this->assertNotEmpty($url->getHost());
        $this->assertNotEmpty($url->getPath());
    }

    public function testCanSendAccountInvite()
    {
        // Create mock client
        $mockClientUtil = new MockGuzzleClient();
        $client = $mockClientUtil->makeWithResponses(
            [
                $mockClientUtil->makeJsonResponse(200, [
                    'customer_invite' => [
                        'from' => 'foo@example.com',
                        'to' => 'bar@example.com',
                        'subject' => 'welcome to my new shop',
                    ],
                ]),
            ]
        );
        Factory::inject(Client::class, $client);

        // Create parameters
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $invite = (new CustomerInvite())
            ->setSubject('Welcome to my new shop')
            ->setCustomMessage('My awesome new store');

        // Test service method
        $service = Factory::make(CustomerService::class);
        $invite = $service->sendAccountInvite($credentials, 3, $invite);

        // Test results
        $this->assertNotEmpty($invite->getFrom());
        $this->assertNotEmpty($invite->getTo());
        $this->assertNotEmpty($invite->getSubject());
    }

    public function testCanDeleteCustomer()
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
        $service = Factory::make(CustomerService::class);
        $result = $service->deleteCustomer($credentials, 3);

        // Test results
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }
}
