<?php

namespace Yaspa\AdminApi\Customer;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Transformers;

/**
 * Class CustomerService
 *
 * @package Yaspa\AdminApi\Customer
 *
 * @todo Figure out how to to iterable for get customers
 */
class CustomerService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Customer $customerTransformer */
    protected $customerTransformer;

    /**
     * CustomerService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Customer $customerTransformer
     */
    public function __construct(Client $httpClient, Transformers\Customer $customerTransformer)
    {
        $this->httpClient = $httpClient;
        $this->customerTransformer = $customerTransformer;
    }

    /**
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return mixed
     */
    public function getCustomers(GetCustomersRequest $request)
    {
        $response = $this->asyncGetCustomers($request)->wait();

        return $this->customerTransformer->fromResponse($response);
    }

    /**
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return PromiseInterface
     */
    public function asyncGetCustomers(
        GetCustomersRequest $request
    ): PromiseInterface {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }
}
