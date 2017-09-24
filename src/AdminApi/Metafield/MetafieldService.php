<?php

namespace Yaspa\AdminApi\Metafield;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldRequest;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldsRequest;
use Yaspa\AdminApi\Metafield\Builders\CreateNewMetafieldRequest;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\AdminApi\Metafield\Transformers;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class MetafieldService
 *
 * @package Yaspa\AdminApi\Metafield
 * @see https://help.shopify.com/api/reference/metafield
 */
class MetafieldService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Metafield $metafieldTransformer */
    protected $metafieldTransformer;
    /** @var CreateNewMetafieldRequest $createNewMetafieldRequestBuilder */
    protected $createNewMetafieldRequestBuilder;
    /** @var GetMetafieldRequest $getMetafieldRequestBuilder */
    protected $getMetafieldRequestBuilder;

    /**
     * MetafieldService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Metafield $metafieldTransformer
     * @param CreateNewMetafieldRequest $createNewMetafieldRequestBuilder
     * @param GetMetafieldRequest $getMetafieldRequestBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Metafield $metafieldTransformer,
        CreateNewMetafieldRequest $createNewMetafieldRequestBuilder,
        GetMetafieldRequest $getMetafieldRequestBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->metafieldTransformer = $metafieldTransformer;
        $this->createNewMetafieldRequestBuilder = $createNewMetafieldRequestBuilder;
        $this->getMetafieldRequestBuilder = $getMetafieldRequestBuilder;
    }

    /**
     * Get metafields based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/metafield#index
     * @param GetMetafieldsRequest $request
     * @return Metafield[]
     */
    public function getMetafields(GetMetafieldsRequest $request): array
    {
        $response = $this->asyncGetMetafields($request)->wait();

        return $this->metafieldTransformer->fromArrayResponse($response);
    }

    /**
     * Async version of self::getMetafields
     *
     * Please note that results will have to be manually transformed.
     *
     * @see https://help.shopify.com/api/reference/metafield#index
     * @param GetMetafieldsRequest $request
     * @return PromiseInterface
     */
    public function asyncGetMetafields(GetMetafieldsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Get a metafield belonging to the store
     *
     * @param RequestCredentialsInterface $credentials
     * @param Metafield $metafield
     * @return Metafield
     */
    public function getMetafield(
        RequestCredentialsInterface $credentials,
        Models\Metafield $metafield
    ): Models\Metafield {
        $response = $this->asyncGetMetafield($credentials, $metafield)->wait();

        return $this->metafieldTransformer->fromResponse($response);
    }

    /**
     * @param RequestCredentialsInterface $credentials
     * @param Metafield $metafield
     * @return PromiseInterface
     */
    public function asyncGetMetafield(
        RequestCredentialsInterface $credentials,
        Models\Metafield $metafield
    ): PromiseInterface {
        $request = $this->getMetafieldRequestBuilder
            ->withCredentials($credentials)
            ->withMetafield($metafield);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::getMetafield
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $metafieldId
     * @return Metafield
     */
    public function getMetafieldById(
        RequestCredentialsInterface $credentials,
        int $metafieldId
    ): Models\Metafield {
        $metafield = (new Models\Metafield())->setId($metafieldId);

        return $this->getMetafield($credentials, $metafield);
    }

    /**
     * Convenience method for self::asyncGetMetafield
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $metafieldId
     * @return PromiseInterface
     */
    public function asyncGetMetafieldById(
        RequestCredentialsInterface $credentials,
        int $metafieldId
    ): PromiseInterface {
        $metafield = (new Models\Metafield())->setId($metafieldId);

        return $this->asyncGetMetafield($credentials, $metafield);
    }

    /**
     * Create a new metafield
     *
     * @see https://help.shopify.com/api/reference/metafield#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Metafield $metafield
     * @return Models\Metafield
     */
    public function createNewMetafield(
        RequestCredentialsInterface $credentials,
        Models\Metafield $metafield
    ): Models\Metafield {
        $response = $this->asyncCreateNewMetafield($credentials, $metafield)->wait();

        return $this->metafieldTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createNewMetafield
     *
     * @see https://help.shopify.com/api/reference/metafield#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Metafield $metafield
     * @return PromiseInterface
     */
    public function asyncCreateNewMetafield(
        RequestCredentialsInterface $credentials,
        Models\Metafield $metafield
    ): PromiseInterface {
        $request = $this->createNewMetafieldRequestBuilder
            ->withCredentials($credentials)
            ->withMetafield($metafield);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * @todo "Get all metafields that belong to the images of a product"; blocked by ProductImage endpoint
     * @see https://help.shopify.com/api/reference/metafield
     */
}
