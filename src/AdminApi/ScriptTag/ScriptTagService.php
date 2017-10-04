<?php

namespace Yaspa\AdminApi\ScriptTag;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\ScriptTag\Transformers;
use Yaspa\AdminApi\ScriptTag\Builders\CountScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\CreateNewScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\DeleteScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagRequest;
use Yaspa\AdminApi\ScriptTag\Builders\GetScriptTagsRequest;
use Yaspa\AdminApi\ScriptTag\Builders\ModifyExistingScriptTagRequest;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class ScriptTagService
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
    /** @var Transformers\ScriptTag $scriptTagTransformer */
    protected $scriptTagTransformer;
    /** @var CountScriptTagsRequest $countScriptTagsRequestBuilder */
    protected $countScriptTagsRequestBuilder;
    /** @var CreateNewScriptTagRequest $createNewScriptTagRequestBuilder */
    protected $createNewScriptTagRequestBuilder;
    /** @var DeleteScriptTagRequest $deleteScriptTagRequestBuilder */
    protected $deleteScriptTagRequestBuilder;
    /** @var GetScriptTagRequest $getScriptTagRequestBuilder */
    protected $getScriptTagRequestBuilder;
    /** @var GetScriptTagsRequest $getScriptTagsRequestBuilder */
    protected $getScriptTagsRequestBuilder;
    /** @var ModifyExistingScriptTagRequest $modifyScriptTagRequestBuilder */
    protected $modifyExistingScriptTagRequestBuilder;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param Transformers\ScriptTag $scriptTagTransformer
     * @param CountScriptTagsRequest $countScriptTagsRequestBuilder
     * @param CreateNewScriptTagRequest $createNewScriptTagRequestBuilder
     * @param DeleteScriptTagRequest $deleteScriptTagRequestBuilder
     * @param GetScriptTagRequest $getScriptTagRequestBuilder,
     * @param GetScriptTagsRequest $getScriptTagsRequestBuilder,
     * @param ModifyExistingScriptTagRequest $modifyExistingScriptTagRequestBuilder
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\ScriptTag $scriptTagTransformer,
        CountScriptTagsRequest $countScriptTagsRequestBuilder,
        CreateNewScriptTagRequest $createNewScriptTagRequestBuilder,
        DeleteScriptTagRequest $deleteScriptTagRequestBuilder,
        GetScriptTagRequest $getScriptTagRequestBuilder,
        GetScriptTagsRequest $getScriptTagsRequestBuilder,
        ModifyExistingScriptTagRequest $modifyExistingScriptTagRequestBuilder,
        PagedResultsIterator $pagedResultsIteratorBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->scriptTagTransformer = $scriptTagTransformer;
        $this->countScriptTagsRequestBuilder = $countScriptTagsRequestBuilder;
        $this->createNewScriptTagRequestBuilder = $createNewScriptTagRequestBuilder;
        $this->deleteScriptTagRequestBuilder = $deleteScriptTagRequestBuilder;
        $this->getScriptTagRequestBuilder = $getScriptTagRequestBuilder;
        $this->getScriptTagsRequestBuilder = $getScriptTagsRequestBuilder;
        $this->modifyExistingScriptTagRequestBuilder = $modifyExistingScriptTagRequestBuilder;
        $this->pagedResultsIteratorBuilder = $pagedResultsIteratorBuilder;
    }

    /**
     * Get a list of all script tags based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/scripttag#index
     * @param GetScriptTagsRequest $request
     * @return PagedResultsIterator|ScriptTag[]
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
     * @see https://help.shopify.com/api/reference/scripttag#index
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
     * Count script tags for a search criteria.
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
     * Get an individual script tag.
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @param null|ScriptTagFields $scriptTagFields
     * @return ScriptTag
     */
    public function getScriptTagById(
        RequestCredentialsInterface $credentials,
        int $scriptTagId,
        ?ScriptTagFields $scriptTagFields = null
    ): ScriptTag {
        $response = $this->asyncGetScriptTagById($credentials, $scriptTagId, $scriptTagFields)->wait();

        return $this->scriptTagTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getScriptTagById
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @param null|ScriptTagFields $scriptTagFields
     * @return PromiseInterface
     */
    public function asyncGetScriptTagById(
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

    /**
     * Create a new script tag.
     *
     * @see https://help.shopify.com/api/reference/scripttag#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\ScriptTag $scriptTag
     * @return Models\ScriptTag
     */
    public function createNewScriptTag(
        RequestCredentialsInterface $credentials,
        Models\ScriptTag $scriptTag
    ): Models\ScriptTag {
        $response = $this->asyncCreateNewScriptTag($credentials, $scriptTag)->wait();

        return $this->scriptTagTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createNewScriptTag
     *
     * @see https://help.shopify.com/api/reference/scripttag#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\ScriptTag $scriptTag
     * @return PromiseInterface
     */
    public function asyncCreateNewScriptTag(
        RequestCredentialsInterface $credentials,
        Models\ScriptTag $scriptTag
    ): PromiseInterface {
        $request = $this->createNewScriptTagRequestBuilder
            ->withCredentials($credentials)
            ->withScriptTag($scriptTag);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Delete script tag.
     *
     * Returns an empty object with no properties if successful.
     *
     * @see https://help.shopify.com/api/reference/scripttag#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @return object
     */
    public function deleteScriptTagById(
        RequestCredentialsInterface $credentials,
        int $scriptTagId
    ) {
        $response = $this->asyncDeleteScriptTagById($credentials, $scriptTagId)->wait();

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Async version of self::deleteScriptTagById
     *
     * @see https://help.shopify.com/api/reference/scripttag#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $scriptTagId
     * @return PromiseInterface
     */
    public function asyncDeleteScriptTagById(
        RequestCredentialsInterface $credentials,
        int $scriptTagId
    ): PromiseInterface {
        $scriptTag = (new Models\ScriptTag())->setId($scriptTagId);
        $request = $this->deleteScriptTagRequestBuilder
            ->withCredentials($credentials)
            ->withScriptTag($scriptTag);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Modify an existing script tag.
     *
     * @see https://help.shopify.com/api/reference/scripttag#update
     * @param ModifyExistingScriptTagRequest $request
     * @return Models\ScriptTag
     */
    public function modifyExistingScriptTag(ModifyExistingScriptTagRequest $request): Models\ScriptTag
    {
        $response = $this->asyncModifyExistingScriptTag($request)->wait();

        return $this->scriptTagTransformer->fromResponse($response);
    }

    /**
     * Async version of self::modifyExistingScriptTag
     *
     * @see https://help.shopify.com/api/reference/scripttag#update
     * @param ModifyExistingScriptTagRequest $request
     * @return PromiseInterface
     */
    public function asyncModifyExistingScriptTag(ModifyExistingScriptTagRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }
}
