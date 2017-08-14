<?php

namespace Yaspa\AdminApi\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Product\Builders\CountProductsRequest;
use Yaspa\AdminApi\Product\Builders\CreateNewProductRequest;
use Yaspa\AdminApi\Product\Builders\GetProductRequest;
use Yaspa\AdminApi\Product\Builders\GetProductsRequest;
use Yaspa\AdminApi\Product\Builders\ModifyExistingProductRequest;
use Yaspa\AdminApi\Product\Builders\ProductFields;
use Yaspa\AdminApi\Product\Models;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\AdminApi\Product\Transformers;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Exceptions\MissingExpectedAttributeException;
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
    /** @var GetProductRequest $getProductRequestBuilder */
    protected $getProductRequestBuilder;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * ProductService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Product $productTransformer
     * @param CreateNewProductRequest $createNewProductRequestBuilder
     * @param GetProductRequest $getProductRequestBuilder
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Product $productTransformer,
        CreateNewProductRequest $createNewProductRequestBuilder,
        GetProductRequest $getProductRequestBuilder,
        PagedResultsIterator $pagedResultsIteratorBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->productTransformer = $productTransformer;
        $this->createNewProductRequestBuilder = $createNewProductRequestBuilder;
        $this->getProductRequestBuilder = $getProductRequestBuilder;
        $this->pagedResultsIteratorBuilder = $pagedResultsIteratorBuilder;
    }

    /**
     * Get products based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/product#index
     * @param GetProductsRequest $request
     * @return PagedResultsIterator|Product[]
     */
    public function getProducts(GetProductsRequest $request): PagedResultsIterator
    {
        return $this->pagedResultsIteratorBuilder
            ->withRequestBuilder($request)
            ->withTransformer($this->productTransformer);
    }

    /**
     * Async version of self::getProducts
     *
     * Please note that results will have to be manually transformed.
     *
     * @see https://help.shopify.com/api/reference/product#index
     * @param GetProductsRequest $request
     * @return PromiseInterface
     */
    public function asyncGetProducts(GetProductsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Count products for a collection or search criteria.
     *
     * @see https://help.shopify.com/api/reference/product#count
     * @param CountProductsRequest $request
     * @return int
     * @throws MissingExpectedAttributeException
     */
    public function countProducts(CountProductsRequest $request): int
    {
        $response = $this->asyncCountProducts($request)->wait();

        $count = json_decode($response->getBody()->getContents());

        if (!property_exists($count, 'count')) {
            throw new MissingExpectedAttributeException('count');
        }

        return intval($count->count);
    }

    /**
     * Async version of self::countProducts
     *
     * @see https://help.shopify.com/api/reference/product#count
     * @param CountProductsRequest $request
     * @return PromiseInterface
     */
    public function asyncCountProducts(CountProductsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Get an individual product.
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @param null|ProductFields $productFields
     * @return Product
     */
    public function getProduct(
        RequestCredentialsInterface $credentials,
        int $productId,
        ?ProductFields $productFields = null
    ): Product {
        $response = $this->asyncGetProduct($credentials, $productId, $productFields)->wait();

        return $this->productTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getProduct
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @param null|ProductFields $productFields
     * @return PromiseInterface
     */
    public function asyncGetProduct(
        RequestCredentialsInterface $credentials,
        int $productId,
        ?ProductFields $productFields = null
    ): PromiseInterface {
        $product = (new Product())->setId($productId);
        $request = $this->getProductRequestBuilder
            ->withCredentials($credentials)
            ->withProduct($product);

        if ($productFields) {
            $request = $request->withProductFields($productFields);
        }

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
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

    /**
     * Modify an existing customer.
     *
     * @see https://help.shopify.com/api/reference/product#update
     * @param ModifyExistingProductRequest $request
     * @return Models\Product
     */
    public function modifyExistingProduct(ModifyExistingProductRequest $request): Models\Product
    {
        $response = $this->asyncModifyExistingProduct($request)->wait();

        return $this->productTransformer->fromResponse($response);
    }

    /**
     * Async version of self::updateExistingProduct
     *
     * @see https://help.shopify.com/api/reference/product#update
     * @param ModifyExistingProductRequest $request
     * @return PromiseInterface
     */
    public function asyncModifyExistingProduct(ModifyExistingProductRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * @todo Write tests for modify existing products
     */
}
