<?php

namespace Yaspa\AdminApi\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Product\Builders\CreateNewProductRequest;
use Yaspa\AdminApi\Product\Models;
use Yaspa\AdminApi\Product\Transformers;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class ProductService
 *
 * @package Yaspa\AdminApi\Product
 * @see https://help.shopify.com/api/reference/product
 */
class ProductService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Product $productTransformer */
    protected $productTransformer;
    /** @var CreateNewProductRequest $createNewProductRequestBuilder */
    protected $createNewProductRequestBuilder;

    /**
     * ProductService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Product $productTransformer
     * @param CreateNewProductRequest $createNewProductRequestBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Product $productTransformer,
        CreateNewProductRequest $createNewProductRequestBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->productTransformer = $productTransformer;
        $this->createNewProductRequestBuilder = $createNewProductRequestBuilder;
    }

    /**
     * Create a new product
     *
     * @see https://help.shopify.com/api/reference/product#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Product $product
     * @return Models\Product
     */
    public function createNewProduct(
        RequestCredentialsInterface $credentials,
        Models\Product $product
    ): Models\Product {
        $response = $this->asyncCreateNewProduct($credentials, $product)->wait();

        return $this->productTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createNewProduct
     *
     * @see https://help.shopify.com/api/reference/product#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Product $product
     * @return PromiseInterface
     */
    public function asyncCreateNewProduct(
        RequestCredentialsInterface $credentials,
        Models\Product $product
    ): PromiseInterface {
        $request = $this->createNewProductRequestBuilder
            ->withCredentials($credentials)
            ->withProduct($product);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }
}
