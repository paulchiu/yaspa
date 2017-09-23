# Yet Another Shopify PHP API (yaspa)

[![CircleCI](https://circleci.com/gh/paulchiu/yaspa/tree/master.svg?style=svg)](https://circleci.com/gh/paulchiu/yaspa/tree/master)

## Installation

*Do not install this library. It is currently under active development
and is in no way stable.*

## Purpose

Most Shopify APIs appear to be thin wrappers around Guzzle that makes things
slightly more convenient but still makes it feel like you are interacting with a
REST API.

The goal of this project is to go one step beyond and provide something closer
to a SDK whereby the library offers everything through PHP without the developer
needing to think too much about the REST API.

## Examples

The following examples show how CRUD works with the API. For full documentation,
see the [Yaspa Gitbook][docs].

Please note that all examples utilise private authentication.

### Create private authentication credentials

Credentials are stored in a POPO (Plain Old PHP Object) model.

All other examples assume the presence of the following code.

```php
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;

$credentials = Factory::make(ApiCredentials::class)
    ->makePrivate(
        'my-shop',
        '4ac0000000000000000000000000035f',
        '59c0000000000000000000000000007f'
    );
```

### Create a customer

```php
use Yaspa\AdminApi\Customer\Builders\CreateNewCustomerRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\Factory;

// Prepare creation request
$customer = (new Customer())
    ->setFirstName('Steve')
    ->setLastName('Lastnameson')
    ->setEmail(uniqid('steve-').'@example.com')
    ->setTags(['foo', 'bar'])
    ->setVerifiedEmail(true)
    ->setAcceptsMarketing(true);
$request = Factory::make(CreateNewCustomerRequest::class)
    ->withCredentials($credentials)
    ->withCustomer($customer);

// Create new customer, $newCustomer is a Customer model
$service = Factory::make(CustomerService::class);
$newCustomer = $service->createNewCustomer($request);
var_dump($newCustomer);
```

### Get all customers created in the past 7 days

```php
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\Factory;

// Create request
$request = Factory::make(GetCustomersRequest::class)
    ->withCredentials($credentials)
    ->withCreatedAtMin(new DateTime('-7 days'));

// Get customers, $customers is an iterator
$service = Factory::make(CustomerService::class);
$customers = $service->getCustomers($request);

// Loop through customers, each $customer is a Customer model
// paging is automated
foreach ($customers as $index => $customer) {
    var_dump($customer);
}
```

### Update a customer

```php
use Yaspa\AdminApi\Customer\Builders\ModifyExistingCustomerRequest;
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\Factory;

// Create request
$customerUpdates = (new Customer())
    ->setId(6820000675)
    ->setFirstName('Alice')
$request = Factory::make(ModifyExistingCustomerRequest::class)
    ->withCredentials($credentials)
    ->withCustomer($customerUpdates);

// Modify an existing customer, $modifiedCustomer is a Customer model
$service = Factory::make(CustomerService::class);
$modifiedCustomer = $service->modifyExistingCustomer($request);
var_dump($modifiedCustomer);
```

### Delete a customer

```php
use Yaspa\AdminApi\Customer\CustomerService;
use Yaspa\Factory;

// Delete an existing customer
$service = Factory::make(CustomerService::class);
$service->deleteCustomer($credentials, 6820000675);
```

## Documentation

For full documentation, please see https://paulchiu.gitbooks.io/yaspa/content/

[docs]: https://paulchiu.gitbooks.io/yaspa/content/

## Roadmap

|Version|Status|Endpoints|Description|
|-------|------|---------|-----------|
|0.1.0|In progress|OAuth, Customer, Product, Order, Metafields|Can manage customers and orders|
|0.2.0|To do|TBD|TBD|

## To do

- [ ] Refactor *breaking* change of use models by default, this means methods such as
      `Yaspa\AdminApi\Customer\CustomerService::getCustomer` will be broken to accept
      a customer model with new method `Yaspa\AdminApi\Customer\CustomerService::getCustomerById`
      working like the older version.
- [ ] Begin working with the admin api
    - [ ] Abandoned checkouts
    - [ ] ApplicationCharge
    - [ ] ApplicationCredit
    - [ ] Article
    - [ ] Asset
    - [ ] Blog
    - [ ] CarrierService
    - [ ] Checkout
    - [ ] Collect
    - [ ] CollectionListing
    - [ ] Comment
    - [ ] Country
    - [ ] CustomCollection
    - [x] Customer (90% complete)
    - [ ] CustomerAddress
    - [ ] CustomerSavedSearch
    - [ ] Discount SHOPIFY PLUS
    - [ ] DraftOrder
    - [ ] Event
    - [ ] Fulfillment
    - [ ] FulfillmentEvent
    - [ ] FulfillmentService
    - [ ] Gift Card SHOPIFY PLUS
    - [ ] Location
    - [ ] Marketing Event
    - [ ] Metafield (in progress)
    - [ ] Multipass SHOPIFY PLUS
    - [ ] Order
    - [ ] Order Risks
    - [ ] Page
    - [ ] Policy
    - [ ] PriceRule
    - [x] Product (90% complete)
    - [ ] Product Image
    - [ ] Product Variant
    - [ ] ProductListing
    - [ ] Province
    - [ ] RecurringApplicationCharge
    - [ ] Redirect
    - [ ] Refund
    - [ ] Report
    - [ ] ResourceFeedback BETA
    - [ ] ScriptTag
    - [ ] Shipping Zone
    - [x] Shop
    - [ ] SmartCollection
    - [ ] Storefront Access Token
    - [ ] Theme
    - [ ] Transaction
    - [ ] UsageCharge
    - [ ] User SHOPIFY PLUS
    - [ ] Webhook
    - [ ] ShopifyQL
- [ ] Document endpoints (in progress)
    - [x] Customer
    - [ ] Product
    - [x] Shop
- [ ] Implement [api call limit throtling][acl] through custom pool [pool][gpool]
- [ ] Implement [webhooks][whs]

[acl]: https://help.shopify.com/api/getting-started/api-call-limit
[gpool]: http://docs.guzzlephp.org/en/stable/quickstart.html#concurrent-requests
[whs]: https://help.shopify.com/api/getting-started/webhooks
