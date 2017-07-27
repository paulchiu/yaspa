<?php

namespace Yaspa\Tests\Integration\AdminApi\Customer;

use DateTime;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Customer\Builders\CreateNewCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\CustomerFields;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\SearchCustomersRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\AdminApi\Customer\Models\Address;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class CustomerServiceTest extends TestCase
{
    /**
     * @group integration
     */
    public function testCanCreateNewCustomer()
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

        // Test method
        $address = (new Address())
            ->setAddress1('123 Oak St')
            ->setCity('Ottawa')
            ->setProvince('ON')
            ->setPhone('555-1212')
            ->setZip('123 ABC')
            ->setLastName('Lastnameson')
            ->setFirstName('Mother')
            ->setCountry('CA');
        $customer = (new Customer())
            ->setFirstName('Steve')
            ->setLastName('Lastnameson')
            ->setEmail(uniqid('steve-').'@example.com')
            ->setVerifiedEmail(true)
            ->setAcceptsMarketing(true)
            ->setAddresses([$address]);
        $request = Factory::make(CreateNewCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer);

        $service = Factory::make(CustomerService::class);
        $newCustomer = $service->createNewCustomer($request);
        $this->assertInstanceOf(Customer::class, $newCustomer);
        $this->assertNotEmpty($newCustomer->getId());
    }

    /**
     * @group integration
     */
    public function testCanGetCustomers()
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

        // Test method
        $fields = Factory::make(CustomerFields::class)
            ->withId()
            ->withEmail()
            ->withFirstName()
            ->withLastName()
            ->withVerifiedEmail()
            ->withCreatedAt()
            ->withUpdatedAt();
        $request = Factory::make(GetCustomersRequest::class)
            ->withCredentials($credentials)
            ->withCustomerFields($fields)
            ->withLimit(2)
            ->withCreatedAtMin(new DateTime('-1 year'));

        $service = Factory::make(CustomerService::class);
        $customers = $service->getCustomers($request);

        // Confirm we can move through pages seamlessly
        $targetIterations = 5;
        $timesIterated = 0;
        foreach ($customers as $index => $customer) {
            if ($timesIterated >= $targetIterations) {
                break;
            }

            $this->assertInstanceOf(Customer::class, $customer);
            $timesIterated++;
        }
        $this->assertGreaterThanOrEqual($targetIterations, $timesIterated);
    }

    /**
     * @group integration
     */
    public function testCanSearchCustomers()
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

        // Test method
        $fields = Factory::make(CustomerFields::class)
            ->withId()
            ->withEmail()
            ->withFirstName();
        $request = Factory::make(SearchCustomersRequest::class)
            ->withCredentials($credentials)
            ->withCustomerFields($fields)
            ->withQuery('Edward');

        $service = Factory::make(CustomerService::class);
        $customers = $service->searchCustomers($request);

        // Confirm we can move through pages seamlessly
        $this->assertEquals(1, iterator_count($customers));
        foreach ($customers as $customer) {
            $this->assertInstanceOf(Customer::class, $customer);
        }
    }
}
