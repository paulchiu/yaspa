<?php

namespace Yaspa\AdminApi\Customer\Iterators;

use GuzzleHttp\Client;
use Iterator;
use Yaspa\AdminApi\Customer\Builders\GetCustomersRequest;
use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\AdminApi\Customer\Transformers\Customer as CustomerTransformer;

/**
 * Class Customers
 *
 * @package Yaspa\AdminApi\Customer\Iterators
 * @todo Refactor out utilised interfaces
 * @todo Refactor into generic iterator
 */
class Customers implements Iterator
{
    // Dumb rate-limiting
    const POST_CALL_DELAY_SECONDS = 0.5;
    const SECONDS_TO_MICROSECONDS_MULTIPLIER = 1000000;

    /**
     * Dependencies
     */
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var CustomerTransformer $customerTransformer */
    protected $customerTransformer;
    /** @var GetCustomersRequest $request */
    protected $request;

    /**
     * Properties
     */
    /** @var int $index */
    protected $index;
    /** @var int $page */
    protected $page;
    /** @var int $pageIndex */
    protected $pageIndex;
    /** @var array|CustomerModel[] */
    protected $pageResults;
    /** @var float $postCallDelayMicroseconds */
    protected $postCallDelayMicroseconds;

    /**
     * Customers constructor.
     *
     * @param Client $httpClient
     * @param CustomerTransformer $customerTransformer
     * @param GetCustomersRequest $request
     * @param float $postCallDelaySeconds
     */
    public function __construct(
        Client $httpClient,
        CustomerTransformer $customerTransformer,
        GetCustomersRequest $request,
        float $postCallDelaySeconds = self::POST_CALL_DELAY_SECONDS
    ) {
        $this->httpClient = $httpClient;
        $this->customerTransformer = $customerTransformer;
        $this->request = $request;
        $this->postCallDelayMicroseconds = $postCallDelaySeconds * self::SECONDS_TO_MICROSECONDS_MULTIPLIER;
    }

    /**
     * Return current value
     *
     * @return CustomerModel
     */
    public function current()
    {
        return $this->pageResults[$this->pageIndex];
    }

    public function next()
    {
        // If we have results to provide, use it
        if (isset($this->pageResults[$this->pageIndex + 1])) {
            $this->pageIndex += 1;
            return;
        }

        // Otherwise, get next page
        $nextPage = $this->page + 1;
        $nextPageRequest = $this->request->withPage($nextPage);
        $response = $this->httpClient
            ->sendAsync($nextPageRequest->toRequest(), $nextPageRequest->toRequestOptions())
            ->wait();
        usleep($this->postCallDelayMicroseconds);
        $results = $this->customerTransformer->fromArrayResponse($response);

        // Reset page relative positional values
        $this->index += 1;
        $this->page = $nextPage;
        $this->pageIndex = 0;
        $this->pageResults = $results;
    }

    /**
     * Current absolute index relative to result set
     *
     * @return int
     */
    public function key()
    {
        return $this->current()->getId();
    }

    /**
     * Whether we still have results
     *
     * @return bool
     */
    public function valid()
    {
        return !empty($this->pageResults);
    }

    /**
     * Reset all positional variables, pre-fetch result so self::valid passes
     */
    public function rewind()
    {
        $this->index = -1;
        $this->page = 0;
        $this->pageIndex;
        $this->pageResults = [];
        $this->next();
    }
}
