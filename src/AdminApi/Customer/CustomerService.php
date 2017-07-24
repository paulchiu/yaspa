<?php

namespace Yaspa\AdminApi\Customer;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;

/**
 * Class CustomerService
 *
 * @package Yaspa\AdminApi\Customer
 *
 * @todo Create model
 * @todo Create transformer
 * @todo Figure out how to to iterable for get customers
 */
class CustomerService
{
    /** @var Client $httpClient */
    protected $httpClient;

    /**
     * CustomerService constructor.
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return mixed
     */
    public function getCustomers(GetCustomersRequest $request)
    {
        $response = $this->asyncGetCustomers($request)->wait();

        return $response;
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
