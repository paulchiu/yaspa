<?php

namespace Yaspa\AdminApi\Shop;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Shop\Builders\GetShopRequest;
use Yaspa\AdminApi\Shop\Models\Shop;
use Yaspa\AdminApi\Shop\Transformers\Shop as ShopTransformer;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class Service
 *
 * @package Yaspa\AdminApi\Shop
 * @see https://help.shopify.com/api/reference/shop
 *
 * Shopify shop details service.
 */
class Service
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var GetShopRequest $getShopRequestBuilder */
    protected $getShopRequestBuilder;
    /** @var ShopTransformer $shopTransformer */
    protected $shopTransformer;

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param GetShopRequest $getShopRequestBuilder
     * @param ShopTransformer $shopTransformer
     */
    public function __construct(
        Client $httpClient,
        GetShopRequest $getShopRequestBuilder,
        ShopTransformer $shopTransformer
    ) {
        $this->httpClient = $httpClient;
        $this->getShopRequestBuilder = $getShopRequestBuilder;
        $this->shopTransformer = $shopTransformer;
    }

    /**
     * Get shop details for the shop the credentials belong to.
     *
     * @see https://help.shopify.com/api/reference/shop#show
     * @param RequestCredentialsInterface $credentials
     * @return mixed
     */
    public function getShop(RequestCredentialsInterface $credentials): Shop
    {
        $response = $this->asyncGetShop($credentials)->wait();

        return $this->shopTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getShop.
     *
     * @see https://help.shopify.com/api/reference/shop#show
     * @param RequestCredentialsInterface $credentials
     * @return PromiseInterface
     */
    public function asyncGetShop(
        RequestCredentialsInterface $credentials
    ): PromiseInterface {
        $getShopRequest = $this->getShopRequestBuilder
            ->withCredentials($credentials);

        return $this->httpClient->sendAsync(
            $getShopRequest->toRequest(),
            $getShopRequest->toRequestOptions()
        );
    }
}
