<?php

namespace Yaspa\AdminApi\ScriptTag;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\Transformers\ScriptTag as ScriptTagTransformer;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class Service
 *
 * @package Yaspa\AdminApi\Shop
 * @see https://help.shopify.com/api/reference/scripttag
 *
 * Shopify scripttag details service.
 */
class ScriptTagService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var GetScriptTagRequest $getScriptTagRequestBuilder */
    protected $getScriptTagRequestBuilder;
    /** @var ScriptTagTransformer $scriptTagTransformer */
    protected $scriptTagTransformer;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param GetScriptTagRequest $getScriptTagRequestBuilder
     * @param ScriptTagTransformer $scriptTagTransformer
     */
    public function __construct(
        Client $httpClient,
        GetScriptTagRequest $getScriptTagRequestBuilder,
        ScriptTagTransformer $scriptTagTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->getScriptTagRequestBuilder = $getScriptTagRequestBuilder;
        $this->scriptTagTransformer = $scriptTagTransformer;
    }

    /**
     * Get a list of all script tags based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/scripttag#index
     * @param GetScriptTagsRequest $request
     * @return PagedResultsIterator|Product[]
     */
    public function getScriptTags(GetScriptTagsRequest $request): PagedResultsIterator
    {
        return $this->pagedResultsIteratorBuilder
            ->withRequestBuilder($request)
            ->withTransformer($this->scriptTagTransformer);
    }

    /**
     * Async version of self::getScriptTags
     *
     * Please note that results will have to be manually transformed.
     *
     * @see hhttps://help.shopify.com/api/reference/scripttag#index
     * @param GetScriptTagsRequest $request
     * @return PromiseInterface
     */
    public function asyncGetScriptTags(GetScriptTagsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Count scripttags for a search criteria.
     *
     * @see https://help.shopify.com/api/reference/scripttag#count
     * @param CountScriptTagsRequest $request
     * @return int
     * @throws MissingExpectedAttributeException
     */
    public function countScriptTags(CountScriptTagsRequest $request): int
    {
        $response = $this->asyncCountScriptTags($request)->wait();

        $count = json_decode($response->getBody()->getContents());

        if (!property_exists($count, 'count')) {
            throw new MissingExpectedAttributeException('count');
        }

        return intval($count->count);
    }

    /**
     * Async version of self::countScriptTags
     *
     * @see https://help.shopify.com/api/reference/scripttag#count
     * @param CountScriptTagsRequest $request
     * @return PromiseInterface
     */
    public function asyncCountScriptTags(CountScriptTagsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Get an individual scripttag.
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @param null|ScriptTagFields $scriptTagFields
     * @return ScriptTag
     */
    public function getScriptTag(
        RequestCredentialsInterface $credentials,
        int $scriptTagId,
        ?ScriptTagFields $scriptTagFields = null
    ): Product {
        $response = $this->asyncGetScriptTag($credentials, $scriptTagId, $scriptTagFields)->wait();

        return $this->scriptTagTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getScriptTag
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @param null|ScriptTagFields $scriptTagFields
     * @return PromiseInterface
     */
    public function asyncGetScriptTag(
        RequestCredentialsInterface $credentials,
        int $scriptTagId,
        ?ScriptTagFields $scriptTagFields = null
    ): PromiseInterface {
        $scriptTag = (new ScriptTag())->setId($scriptTagId);
        $request = $this->getScriptTagRequestBuilder
            ->withCredentials($credentials)
            ->withScriptTag($scriptTag);

        if ($scriptTagFields) {
            $request = $request->withScriptTagFields($scriptTagFields);
        }

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }
}
