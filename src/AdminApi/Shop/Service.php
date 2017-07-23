<?php

namespace Yaspa\AdminApi\Shop;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Shop\Builders\GetShopRequest;
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

    /**
     * Service constructor.
     *
     * @param Client $httpClient
     * @param GetShopRequest $getShopRequestBuilder
     */
    public function __construct(Client $httpClient, GetShopRequest $getShopRequestBuilder)
    {
        $this->httpClient = $httpClient;
        $this->getShopRequestBuilder = $getShopRequestBuilder;
    }

    /**
     * @todo Write model and transformer
     * @todo Write unit tests
     * @todo Update integration tests
     * @param RequestCredentialsInterface $credentials
     * @return mixed
     */
    public function getShop(RequestCredentialsInterface $credentials)
    {
        $response = $this->asyncGetShop($credentials)->wait();

        return $response->getBody()->getContents();
    }

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
