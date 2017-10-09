<?php

namespace Yaspa\AdminApi\Customer;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Uri;
use Yaspa\AdminApi\Customer\Builders\CountAllCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\CreateAccountActivationUrlRequest;
use Yaspa\AdminApi\Customer\Builders\CreateNewCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\DeleteCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\GetCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\ModifyExistingCustomerRequest;
use Yaspa\AdminApi\Customer\Builders\SearchCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\SendAccountInviteRequest;
use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\AdminApi\Customer\Models\CustomerInvite;
use Yaspa\AdminApi\Customer\Transformers;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class CustomerService
 *
 * @package Yaspa\AdminApi\Customer
 * @see https://help.shopify.com/api/reference/customer
 */
class CustomerService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Customer $customerTransformer */
    protected $customerTransformer;
    /** @var Transformers\AccountActivationUrl $accountActivationUrlTransformer */
    protected $accountActivationUrlTransformer;
    /** @var Transformers\CustomerInvite $customerInviteTransformer */
    protected $customerInviteTransformer;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;
    /** @var GetCustomerRequest $getCustomerRequestBuilder */
    protected $getCustomerRequestBuilder;
    /** @var CreateAccountActivationUrlRequest $createAccountActivationUrlRequestBuilder */
    protected $createAccountActivationUrlRequestBuilder;
    /** @var SendAccountInviteRequest $sendAccountInviteRequestBuilder */
    protected $sendAccountInviteRequestBuilder;
    /** @var DeleteCustomerRequest $deleteCustomerRequestBuilder */
    protected $deleteCustomerRequestBuilder;
    /** @var CountAllCustomersRequest $countAllCustomersRequestBuilder */
    protected $countAllCustomersRequestBuilder;

    /**
     * CustomerService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Customer $customerTransformer
     * @param Transformers\AccountActivationUrl $accountActivationUrlTransformer
     * @param Transformers\CustomerInvite $customerInviteTransformer
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     * @param GetCustomerRequest $getCustomerRequestBuilder
     * @param CreateAccountActivationUrlRequest $createAccountActivationUrlRequestBuilder
     * @param SendAccountInviteRequest $sendAccountInviteRequestBuilder
     * @param DeleteCustomerRequest $deleteCustomerRequestBuilder
     * @param CountAllCustomersRequest $countAllCustomersRequestBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Customer $customerTransformer,
        Transformers\AccountActivationUrl $accountActivationUrlTransformer,
        Transformers\CustomerInvite $customerInviteTransformer,
        PagedResultsIterator $pagedResultsIteratorBuilder,
        GetCustomerRequest $getCustomerRequestBuilder,
        CreateAccountActivationUrlRequest $createAccountActivationUrlRequestBuilder,
        SendAccountInviteRequest $sendAccountInviteRequestBuilder,
        DeleteCustomerRequest $deleteCustomerRequestBuilder,
        CountAllCustomersRequest $countAllCustomersRequestBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->customerTransformer = $customerTransformer;
        $this->accountActivationUrlTransformer = $accountActivationUrlTransformer;
        $this->customerInviteTransformer = $customerInviteTransformer;
        $this->pagedResultsIteratorBuilder = $pagedResultsIteratorBuilder;
        $this->getCustomerRequestBuilder = $getCustomerRequestBuilder;
        $this->createAccountActivationUrlRequestBuilder = $createAccountActivationUrlRequestBuilder;
        $this->sendAccountInviteRequestBuilder = $sendAccountInviteRequestBuilder;
        $this->deleteCustomerRequestBuilder = $deleteCustomerRequestBuilder;
        $this->countAllCustomersRequestBuilder = $countAllCustomersRequestBuilder;
    }

    /**
     * Get customers based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return Customer[]|PagedResultsIterator
     */
    public function getCustomers(GetCustomersRequest $request): PagedResultsIterator
    {
        return $this->pagedResultsIteratorBuilder
            ->withRequestBuilder($request)
            ->withTransformer($this->customerTransformer);
    }

    /**
     * Async version of self::getCustomers
     *
     * Please note that results will have to be manually transformed.
     *
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return PromiseInterface
     */
    public function asyncGetCustomers(GetCustomersRequest $request): PromiseInterface {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Search customers.
     *
     * @progress Just managed to get integration test working, there are issues with iterator
     * @see https://help.shopify.com/api/reference/customer#search
     * @param SearchCustomersRequest $request
     * @return Customer[]|PagedResultsIterator
     */
    public function searchCustomers(SearchCustomersRequest $request): PagedResultsIterator
    {
        return $this->pagedResultsIteratorBuilder
            ->withRequestBuilder($request)
            ->withTransformer($this->customerTransformer);
    }

    /**
     * Async version of self::searchCustomers
     *
     * @see https://help.shopify.com/api/reference/customer#search
     * @param SearchCustomersRequest $request
     * @return PromiseInterface
     */
    public function asyncSearchCustomers(SearchCustomersRequest $request): PromiseInterface {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Create a new customer.
     *
     * @see https://help.shopify.com/api/reference/customer#create
     * @param CreateNewCustomerRequest $request
     * @return Customer
     */
    public function createNewCustomer(CreateNewCustomerRequest $request): Customer
    {
        $response = $this->asyncCreateNewCustomer($request)->wait();

        return $this->customerTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createNewCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#create
     * @param CreateNewCustomerRequest $request
     * @return PromiseInterface
     */
    public function asyncCreateNewCustomer(CreateNewCustomerRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Modify an existing customer.
     *
     * @see https://help.shopify.com/api/reference/customer#update
     * @param ModifyExistingCustomerRequest $request
     * @return Customer
     */
    public function modifyExistingCustomer(ModifyExistingCustomerRequest $request): Customer
    {
        $response = $this->asyncModifyExistingCustomer($request)->wait();

        return $this->customerTransformer->fromResponse($response);
    }

    /**
     * Async version of self::updateExistingCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#update
     * @param ModifyExistingCustomerRequest $request
     * @return PromiseInterface
     */
    public function asyncModifyExistingCustomer(ModifyExistingCustomerRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Get an individual customer.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return Customer
     */
    public function getCustomer(RequestCredentialsInterface $credentials, Customer $customer): Customer
    {
        $response = $this->asyncGetCustomer($credentials, $customer)->wait();

        return $this->customerTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return PromiseInterface
     */
    public function asyncGetCustomer(RequestCredentialsInterface $credentials, Customer $customer): PromiseInterface
    {
        $request = $this->getCustomerRequestBuilder
            ->withCredentials($credentials)
            ->withCustomer($customer);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::getCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return Customer
     */
    public function getCustomerById(RequestCredentialsInterface $credentials, int $customerId): Customer
    {
        $customer = (new Customer())->setId($customerId);

        return $this->getCustomer($credentials, $customer);
    }

    /**
     * Convenience method for self::asyncGetCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return PromiseInterface
     */
    public function asyncGetCustomerById(RequestCredentialsInterface $credentials, int $customerId): PromiseInterface
    {
        $customer = (new Customer())->setId($customerId);

        return $this->asyncGetCustomer($credentials, $customer);
    }

    /**
     * Create an account activation URL for an inactive customer.
     *
     * Please note that according to Shopify documentation the following constraints exist:
     *
     * - If a customer is enabled, an error will be returned.
     * - The generated URL is only valid for 7 days.
     *
     * @see https://help.shopify.com/api/reference/customer#account_activation_url
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return Uri
     * @throws MissingExpectedAttributeException
     */
    public function createAccountActivationUrl(
        RequestCredentialsInterface $credentials,
        Customer $customer
    ): Uri {
        $response = $this->asyncCreateAccountActivationUrl($credentials, $customer)->wait();

        return $this->accountActivationUrlTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createAccountActivationUrl
     *
     * @see https://help.shopify.com/api/reference/customer#account_activation_url
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return PromiseInterface
     */
    public function asyncCreateAccountActivationUrl(
        RequestCredentialsInterface $credentials,
        Customer $customer
    ): PromiseInterface {
        $request = $this->createAccountActivationUrlRequestBuilder
            ->withCredentials($credentials)
            ->withCustomer($customer);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::createAccountActivationUrl
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return Uri
     */
    public function createAccountActivationUrlForCustomerId(
        RequestCredentialsInterface $credentials,
        int $customerId
    ): Uri {
        $customer = (new Customer())->setId($customerId);

        return $this->createAccountActivationUrl($credentials, $customer);
    }

    /**
     * Convenience method for self::asyncCreateAccountActivationUrl
     *
     * @see https://help.shopify.com/api/reference/customer#account_activation_url
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return PromiseInterface
     */
    public function asyncCreateAccountActivationUrlForCustomerId(
        RequestCredentialsInterface $credentials,
        int $customerId
    ): PromiseInterface {
        $customer = (new Customer())->setId($customerId);

        return $this->asyncCreateAccountActivationUrl($credentials, $customer);
    }

    /**
     * Send an invite email to a customer.
     *
     * @see https://help.shopify.com/api/reference/customer#send_invite
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @param null|CustomerInvite $customerInvite
     * @return CustomerInvite
     */
    public function sendAccountInvite(
        RequestCredentialsInterface $credentials,
        Customer $customer,
        ?CustomerInvite $customerInvite = null
    ): CustomerInvite {
        $response = $this->asyncSendAccountInvite($credentials, $customer, $customerInvite)->wait();

        return $this->customerInviteTransformer->fromResponse($response);
    }

    /**
     * Async version of self::sendAccountInvite
     *
     * @see https://help.shopify.com/api/reference/customer#send_invite
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @param null|CustomerInvite $customerInvite
     * @return PromiseInterface
     */
    public function asyncSendAccountInvite(
        RequestCredentialsInterface $credentials,
        Customer $customer,
        ?CustomerInvite $customerInvite = null
    ): PromiseInterface {
        $request = $this->sendAccountInviteRequestBuilder
            ->withCredentials($credentials)
            ->withCustomer($customer)
            ->withCustomerInvite($customerInvite);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::sendAccountInvite
     *
     * @see https://help.shopify.com/api/reference/customer#send_invite
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @param null|CustomerInvite $customerInvite
     * @return CustomerInvite
     */
    public function sendAccountInviteForCustomerId(
        RequestCredentialsInterface $credentials,
        int $customerId,
        ?CustomerInvite $customerInvite = null
    ): CustomerInvite {
        $customer = (new Customer())->setId($customerId);

        return $this->sendAccountInvite($credentials, $customer, $customerInvite);
    }

    /**
     * Convenience method for self::asyncSendAccountInvite
     *
     * @see https://help.shopify.com/api/reference/customer#send_invite
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @param null|CustomerInvite $customerInvite
     * @return PromiseInterface
     */
    public function asyncSendAccountInviteForCustomerId(
        RequestCredentialsInterface $credentials,
        int $customerId,
        ?CustomerInvite $customerInvite = null
    ): PromiseInterface {
        $customer = (new Customer())->setId($customerId);

        return $this->asyncSendAccountInvite($credentials, $customer, $customerInvite);
    }

    /**
     * Delete customer.
     *
     * Returns an empty object with no properties if successful.
     *
     * @see https://help.shopify.com/api/reference/customer#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return object
     */
    public function deleteCustomer(
        RequestCredentialsInterface $credentials,
        Customer $customer
    ) {
        $response = $this->asyncDeleteCustomer($credentials, $customer)->wait();

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Async version of self::deleteCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Customer $customer
     * @return PromiseInterface
     */
    public function asyncDeleteCustomer(
        RequestCredentialsInterface $credentials,
        Customer $customer
    ): PromiseInterface {
        $request = $this->deleteCustomerRequestBuilder
            ->withCredentials($credentials)
            ->withCustomer($customer);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::deleteCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return object
     */
    public function deleteCustomerById(
        RequestCredentialsInterface $credentials,
        int $customerId
    ) {
        $customer = (new Customer())->setId($customerId);

        return $this->deleteCustomer($credentials, $customer);
    }

    /**
     * Convenience method for self::asyncDeleteCustomer
     *
     * @see https://help.shopify.com/api/reference/customer#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $customerId
     * @return PromiseInterface
     */
    public function asyncDeleteCustomerById(
        RequestCredentialsInterface $credentials,
        int $customerId
    ): PromiseInterface {
        $customer = (new Customer())->setId($customerId);

        return $this->asyncDeleteCustomer($credentials, $customer);
    }

    /**
     * Count all customers in a store.
     *
     * @param RequestCredentialsInterface $credentials
     * @return int
     * @throws MissingExpectedAttributeException
     */
    public function countAllCustomers(RequestCredentialsInterface $credentials): int
    {
        $response = $this->asyncCountAllCustomers($credentials)->wait();

        $count = json_decode($response->getBody()->getContents());

        if (!property_exists($count, 'count')) {
            throw new MissingExpectedAttributeException('count');
        }

        return intval($count->count);
    }

    /**
     * Async version of self::countAllCustomers
     *
     * @param RequestCredentialsInterface $credentials
     * @return PromiseInterface
     */
    public function asyncCountAllCustomers(RequestCredentialsInterface $credentials): PromiseInterface
    {
        $request = $this->countAllCustomersRequestBuilder->withCredentials($credentials);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * @todo "Get all orders belonging to this customer", blocked by Orders resource support
     * @see https://help.shopify.com/api/reference/customer#orders
     */

    /**
     * @todo Add metafields support to Customer resource
     */
}
