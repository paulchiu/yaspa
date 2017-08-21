<?php

namespace Yaspa\AdminApi\Metafield;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
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

    /**
     * MetafieldService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Metafield $metafieldTransformer
     * @param CreateNewMetafieldRequest $createNewMetafieldRequestBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Metafield $metafieldTransformer,
        CreateNewMetafieldRequest $createNewMetafieldRequestBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->metafieldTransformer = $metafieldTransformer;
        $this->createNewMetafieldRequestBuilder = $createNewMetafieldRequestBuilder;
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
}
