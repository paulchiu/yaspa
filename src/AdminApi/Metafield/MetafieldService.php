<?php

namespace Yaspa\AdminApi\Metafield;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Metafield\Builders\GetMetafieldsRequest;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\AdminApi\Metafield\Transformers;

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

    /**
     * MetafieldService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Metafield $metafieldTransformer
     */
    public function __construct(Client $httpClient, Transformers\Metafield $metafieldTransformer)
    {
        $this->httpClient = $httpClient;
        $this->metafieldTransformer = $metafieldTransformer;
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
}
