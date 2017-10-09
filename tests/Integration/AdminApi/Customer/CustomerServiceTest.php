<?php

namespace Yaspa\Tests\Integration\AdminApi\Customer;

use DateTime;
use PHPUnit\Framework\TestCase;
use Yaspa\AdminApi\Customer\Builders\CreateNewCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\CustomerFields;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\ModifyExistingCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\SearchCustomersRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\AdminApi\Customer\Models\Address;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\AdminApi\Customer\Models\CustomerInvite;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Tests\Utils\Config as TestConfig;

class CustomerServiceTest extends TestCase
{
    /**
     * @group integration
     * @return Customer
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
            ->setTags(['foo', 'bar'])
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
        $this->assertEquals('disabled', $newCustomer->getState());
        $this->assertCount(2, $newCustomer->getTags());

        return $newCustomer;
    }

    /**
     * @group integration
     */
    public function testCanCreateNewCustomerWithSendEmailInvite()
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
            ->withCustomer($customer)
            ->withSendEmailInvite(true);

        $service = Factory::make(CustomerService::class);
        $newCustomer = $service->createNewCustomer($request);
        $this->assertInstanceOf(Customer::class, $newCustomer);
        $this->assertNotEmpty($newCustomer->getId());
        $this->assertEquals('invited', $newCustomer->getState());
    }

    /**
     * @group integration
     */
    public function testCanCreateNewCustomerWithMetafield()
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
        $metafield = (new Metafield())
            ->setKey('cst:ccnc')
            ->setValue(uniqid('v:'))
            ->setValueType('string')
            ->setNamespace('global');
        $request = Factory::make(CreateNewCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer)
            ->withMetafields([$metafield]);

        $service = Factory::make(CustomerService::class);
        $newCustomer = $service->createNewCustomer($request);
        $this->assertInstanceOf(Customer::class, $newCustomer);
        $this->assertNotEmpty($newCustomer->getId());
        $this->assertEquals('disabled', $newCustomer->getState());
    }

    /**
     * @group integration
     */
    public function testCanCreateNewCustomerWithPassword()
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
            ->withCustomer($customer)
            ->withPassword('foo-bar')
            ->withPasswordConfirmation('foo-bar')
            ->withSendEmailInvite(false);

        $service = Factory::make(CustomerService::class);
        $newCustomer = $service->createNewCustomer($request);
        $this->assertInstanceOf(Customer::class, $newCustomer);
        $this->assertNotEmpty($newCustomer->getId());
        $this->assertEquals('enabled', $newCustomer->getState());
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
        $targetIterations = 4;
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
            ->withQuery('steve');

        $service = Factory::make(CustomerService::class);
        $customers = $service->searchCustomers($request);

        // Confirm we can move through pages seamlessly
        $this->assertGreaterThanOrEqual(1, iterator_count($customers));
        foreach ($customers as $customer) {
            $this->assertInstanceOf(Customer::class, $customer);
        }
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     */
    public function testCanModifyExistingCustomerTags(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());
        $this->assertFalse(in_array('baz', $customer->getTags()));
        $this->assertFalse(in_array('qux', $customer->getTags()));

        // Update customer
        $newFirstName = uniqid('firstName:');
        $customerUpdates = (new Customer())
            ->setId($customer->getId())
            ->setFirstName($newFirstName)
            ->setTags(['baz', 'qux']);

        // Modify customer
        $request = Factory::make(ModifyExistingCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customerUpdates);
        $service = Factory::make(CustomerService::class);
        $modifiedCustomer = $service->modifyExistingCustomer($request);

        // Test results
        $this->assertEquals($customer->getId(), $modifiedCustomer->getId());
        $this->assertEquals(['baz', 'qux'], $modifiedCustomer->getTags());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     */
    public function testCanModifyExistingCustomerWithNewDetails(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());
        $this->assertNotEmpty($customer->getFirstName());

        // Update customer
        $newFirstName = uniqid('firstName:');
        $customerUpdates = (new Customer())
            ->setId($customer->getId())
            ->setFirstName($newFirstName)
            ->setNote('Customer is a great guy');

        // Modify customer
        $request = Factory::make(ModifyExistingCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customerUpdates);
        $service = Factory::make(CustomerService::class);
        $modifiedCustomer = $service->modifyExistingCustomer($request);

        // Test results
        $this->assertEquals($customer->getId(), $modifiedCustomer->getId());
        $this->assertNotEquals($customer->getFirstName(), $modifiedCustomer->getFirstName());
        $this->assertEquals($newFirstName, $modifiedCustomer->getFirstName());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     * @todo Once implemented get metafields for customer, test metafields are actually added
     */
    public function testCanModifyExistingCustomerWithMetaField(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());
        $this->assertNotEmpty($customer->getFirstName());

        // Update customer
        $newFirstName = uniqid('firstName:');
        $metafield = (new Metafield())
            ->setKey('cst:ccnc')
            ->setValue(uniqid('v:'))
            ->setValueType('string')
            ->setNamespace('global');
        $customerUpdates = (new Customer())
            ->setId($customer->getId())
            ->setFirstName($newFirstName)
            ->setNote('Customer is a great guy');

        // Modify customer
        $request = Factory::make(ModifyExistingCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customerUpdates)
            ->withMetafields([$metafield]);
        $service = Factory::make(CustomerService::class);
        $modifiedCustomer = $service->modifyExistingCustomer($request);

        // Test results
        $this->assertEquals($customer->getId(), $modifiedCustomer->getId());
        $this->assertNotEquals($customer->getFirstName(), $modifiedCustomer->getFirstName());
        $this->assertEquals($newFirstName, $modifiedCustomer->getFirstName());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     */
    public function testCanGetCustomerById(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());

        // Test service method
        $service = Factory::make(CustomerService::class);
        $retrievedCustomer = $service->getCustomerById($credentials, $customer->getId());

        // Test results
        $this->assertEquals($customer->getId(), $retrievedCustomer->getId());
        $this->assertEquals($customer->getEmail(), $retrievedCustomer->getEmail());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     */
    public function testCanCreateAccountActivationUrlForCustomerId(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());

        // Test service method
        $service = Factory::make(CustomerService::class);
        $url = $service->createAccountActivationUrlForCustomerId($credentials, $customer->getId());

        // Test results
        $this->assertNotEmpty($url->getHost());
        $this->assertNotEmpty($url->getPath());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     */
    public function testCanSendDefaultAccountInviteForCustomerId()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create service
        $service = Factory::make(CustomerService::class);

        // Create fixtures
        $customer = (new Customer())
            ->setFirstName('Steve')
            ->setLastName('Lastnameson')
            ->setEmail(uniqid().'@mailinator.com')
            ->setVerifiedEmail(false);
        $createCustomerRequest = Factory::make(CreateNewCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer);
        $customer = $service->createNewCustomer($createCustomerRequest);

        // Create parameters
        $service = Factory::make(CustomerService::class);

        // Test pre-state
        $this->assertNotEmpty($customer->getId());

        // Test service method
        $invite = $service->sendAccountInviteForCustomerId($credentials, $customer->getId());

        // Test results
        $this->assertNotEmpty($invite->getFrom());
        $this->assertNotEmpty($invite->getTo());
        $this->assertNotEmpty($invite->getSubject());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     */
    public function testCanSendCustomAccountInviteForCustomerId()
    {
        // Get config
        $config = new TestConfig();
        $shop = $config->get('shopifyShop');
        $privateApp = $config->get('shopifyShopApp');
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate(
                $shop->myShopifySubdomainName,
                $privateApp->apiKey,
                $privateApp->password
            );

        // Create service
        $service = Factory::make(CustomerService::class);

        // Create fixtures
        $customer = (new Customer())
            ->setFirstName('Steve')
            ->setLastName('Lastnameson')
            ->setEmail(uniqid().'@mailinator.com')
            ->setVerifiedEmail(true);
        $createCustomerRequest = Factory::make(CreateNewCustomerRequest::class)
            ->withCredentials($credentials)
            ->withCustomer($customer);
        $customer = $service->createNewCustomer($createCustomerRequest);

        // Create parameters
        $service = Factory::make(CustomerService::class);
        $invite = (new CustomerInvite())
            ->setSubject('Welcome to my new shop')
            ->setCustomMessage('My awesome new store');

        // Test pre-state
        $this->assertNotEmpty($customer->getId());

        // Test service method
        $invite = $service->sendAccountInviteForCustomerId($credentials, $customer->getId(), $invite);

        // Test results
        $this->assertNotEmpty($invite->getFrom());
        $this->assertNotEmpty($invite->getTo());
        $this->assertNotEmpty($invite->getSubject());
    }

    /**
     * @group integration
     * @depends testCanCreateNewCustomer
     * @param Customer $customer
     */
    public function testCanDeleteCustomerById(Customer $customer)
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
        $this->assertNotEmpty($customer->getId());

        // Test service method
        $service = Factory::make(CustomerService::class);
        $result = $service->deleteCustomerById($credentials, $customer->getId());
        $this->assertTrue(is_object($result));
        $this->assertEmpty(get_object_vars($result));
    }

    /**
     * @group integration
     */
    public function testCanCountAllCustomers()
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

        // Test service method
        $service = Factory::make(CustomerService::class);
        $result = $service->countAllCustomers($credentials);
        $this->assertGreaterThan(0, $result);
    }
}
