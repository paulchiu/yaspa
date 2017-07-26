<?php

namespace Yaspa\Builders;

use GuzzleHttp\Client;
use Iterator;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use Yaspa\Interfaces\PagingRequestBuilderInterface;

/**
 * Class PagedResultsIterator
 *
 * @package Yaspa\Iterators
 *
 * Iterator builder. This builder will create an iterable that will traverse Shopify paged results.
 *
 * Please note that the following properties *must* be set for the iterator to work:
 *
 * - $arrayTransformer
 * - $pagingRequestBuilder
 *
 * This class is tested through \Yaspa\AdminApi\Customer\CustomerService::getCustomers
 */
class PagedResultsIterator implements Iterator
{
    // Dumb rate-limiting
    const SECONDS_TO_MICROSECONDS_MULTIPLIER = 1000000;
    const DEFAULT_IDENTIFIER_GETTER = 'getId';
    const DEFAULT_POST_CALL_DELAY_SECONDS = 0.5;

    /**
     * Dependencies
     */
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var ArrayResponseTransformerInterface $arrayTransformer */
    protected $arrayTransformer;

    /**
     * Build-able properties
     */
    /** @var float $postCallDelayMicroseconds */
    protected $postCallDelayMicroseconds;
    /** @var PagingRequestBuilderInterface $pagingRequestBuilder */
    protected $pagingRequestBuilder;
    /** @var string $identifierGetter */
    protected $identifierGetter;

    /**
     * Internal properties
     */
    /** @var int $index */
    protected $index;
    /** @var int $page */
    protected $page;
    /** @var int $pageIndex */
    protected $pageIndex;
    /** @var array */
    protected $pageResults;

    /**
     * PagedResultsIterator constructor.
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->postCallDelayMicroseconds = self::DEFAULT_POST_CALL_DELAY_SECONDS * self::SECONDS_TO_MICROSECONDS_MULTIPLIER;
        $this->identifierGetter = self::DEFAULT_IDENTIFIER_GETTER;
    }

    /**
     * @param PagingRequestBuilderInterface $pagingRequestBuilder
     * @return PagedResultsIterator
     */
    public function withRequestBuilder(PagingRequestBuilderInterface $pagingRequestBuilder): PagedResultsIterator
    {
        $new = clone $this;
        $new->pagingRequestBuilder = $pagingRequestBuilder;

        return $new;
    }

    /**
     * @param ArrayResponseTransformerInterface $arrayTransformer
     * @return PagedResultsIterator
     */
    public function withTransformer(ArrayResponseTransformerInterface $arrayTransformer): PagedResultsIterator
    {
        $new = clone $this;
        $new->arrayTransformer = $arrayTransformer;

        return $new;
    }

    /**
     * @param float $postCallDelaySeconds
     * @return PagedResultsIterator
     */
    public function withPostCallDelaySeconds(float $postCallDelaySeconds): PagedResultsIterator
    {
        $new = clone $this;
        $this->postCallDelayMicroseconds = $postCallDelaySeconds * self::SECONDS_TO_MICROSECONDS_MULTIPLIER;

        return $new;
    }

    /**
     * @param string $identifierGetter
     * @return PagedResultsIterator
     */
    public function withIdentifierGetter(string $identifierGetter): PagedResultsIterator
    {
        $new = clone $this;
        $new->identifierGetter = $identifierGetter;

        return $new;
    }

    /**
     * Return the current value
     *
     * @return mixed
     */
    public function current()
    {
        return $this->pageResults[$this->pageIndex];
    }

    /**
     * Load the next value
     */
    public function next()
    {
        // If we have results to provide, use it
        if (isset($this->pageResults[$this->pageIndex + 1])) {
            $this->pageIndex += 1;
            return;
        }

        // Otherwise, get next page
        $nextPage = $this->page + 1;
        /** @var PagingRequestBuilderInterface $nextPageRequest */
        $nextPageRequest = $this->pagingRequestBuilder->withPage($nextPage);
        $response = $this->httpClient
            ->sendAsync($nextPageRequest->toRequest(), $nextPageRequest->toRequestOptions())
            ->wait();
        usleep($this->postCallDelayMicroseconds);
        $results = $this->arrayTransformer->fromArrayResponse($response);

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
        return $this->current()->{$this->identifierGetter}();
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
        $this->page = $this->pagingRequestBuilder->getPage() ?: 0;
        $this->pageIndex;
        $this->pageResults = [];
        $this->next();
    }
}
