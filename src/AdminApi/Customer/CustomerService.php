<?php

namespace Yaspa\AdminApi\Customer;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Builders\SearchCustomersRequest;
use Yaspa\AdminApi\Customer\Models;
use Yaspa\AdminApi\Customer\Transformers;
use Yaspa\Builders\PagedResultsIterator;

/**
 * Class CustomerService
 *
 * @package Yaspa\AdminApi\Customer
 */
class CustomerService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Customer $customerTransformer */
    protected $customerTransformer;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * CustomerService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Customer $customerTransformer
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Customer $customerTransformer,
        PagedResultsIterator $pagedResultsIteratorBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->customerTransformer = $customerTransformer;
        $this->pagedResultsIteratorBuilder = $pagedResultsIteratorBuilder;
    }

    /**
     * Get customers based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/customer#index
     * @param GetCustomersRequest $request
     * @return Models\Customer[]|PagedResultsIterator
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
     * @todo Fix broken tests
     * @todo Write unit tests
     * @todo Do create customer; may need to re-factor/break-apart AuthorizedRequestBuilderTrait
     * @see https://help.shopify.com/api/reference/customer#search
     * @param SearchCustomersRequest $request
     * @return Models\Customer[]|PagedResultsIterator
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
}
