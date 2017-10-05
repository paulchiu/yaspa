<?php

namespace Yaspa\AdminApi\Product;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Metafield\Builders\CreateNewResourceMetafieldRequest;
use Yaspa\AdminApi\Metafield\Builders\DeleteResourceMetafieldRequest;
use Yaspa\AdminApi\Metafield\Builders\GetResourceMetafieldsRequest;
use Yaspa\AdminApi\Metafield\Builders\UpdateResourceMetafieldRequest;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\AdminApi\Metafield\Models\Metafield;
use Yaspa\AdminApi\Product\Builders\CountProductsRequest;
use Yaspa\AdminApi\Product\Builders\CreateNewProductRequest;
use Yaspa\AdminApi\Product\Builders\DeleteProductRequest;
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
    /** @var MetafieldTransformer $metafieldTransformer */
    protected $metafieldTransformer;
    /** @var CreateNewProductRequest $createNewProductRequestBuilder */
    protected $createNewProductRequestBuilder;
    /** @var GetProductRequest $getProductRequestBuilder */
    protected $getProductRequestBuilder;
    /** @var DeleteProductRequest $deleteProductRequestBuilder */
    protected $deleteProductRequestBuilder;
    /** @var CreateNewResourceMetafieldRequest $createNewResourceMetafieldRequestBuilder */
    protected $createNewResourceMetafieldRequestBuilder;
    /** @var GetResourceMetafieldsRequest $getResourceMetafieldsBuilder */
    protected $getResourceMetafieldsBuilder;
    /** @var UpdateResourceMetafieldRequest $updateResourceMetafieldRequestBuilder */
    protected $updateResourceMetafieldRequestBuilder;
    /** @var DeleteResourceMetafieldRequest $deleteResourceMetafieldRequestBuilder */
    protected $deleteResourceMetafieldRequestBuilder;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * ProductService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Product $productTransformer
     * @param MetafieldTransformer $metafieldTransformer
     * @param CreateNewProductRequest $createNewProductRequestBuilder
     * @param GetProductRequest $getProductRequestBuilder
     * @param DeleteProductRequest $deleteProductRequestBuilder
     * @param CreateNewResourceMetafieldRequest $createNewResourceMetafieldRequestBuilder
     * @param GetResourceMetafieldsRequest $getResourceMetafieldsBuilder
     * @param UpdateResourceMetafieldRequest $updateResourceMetafieldRequestBuilder
     * @param DeleteResourceMetafieldRequest $deleteResourceMetafieldRequestBuilder
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Product $productTransformer,
        MetafieldTransformer $metafieldTransformer,
        CreateNewProductRequest $createNewProductRequestBuilder,
        GetProductRequest $getProductRequestBuilder,
        DeleteProductRequest $deleteProductRequestBuilder,
        CreateNewResourceMetafieldRequest $createNewResourceMetafieldRequestBuilder,
        GetResourceMetafieldsRequest $getResourceMetafieldsBuilder,
        UpdateResourceMetafieldRequest $updateResourceMetafieldRequestBuilder,
        DeleteResourceMetafieldRequest $deleteResourceMetafieldRequestBuilder,
        PagedResultsIterator $pagedResultsIteratorBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->productTransformer = $productTransformer;
        $this->metafieldTransformer = $metafieldTransformer;
        $this->createNewProductRequestBuilder = $createNewProductRequestBuilder;
        $this->getProductRequestBuilder = $getProductRequestBuilder;
        $this->deleteProductRequestBuilder = $deleteProductRequestBuilder;
        $this->createNewResourceMetafieldRequestBuilder = $createNewResourceMetafieldRequestBuilder;
        $this->getResourceMetafieldsBuilder = $getResourceMetafieldsBuilder;
        $this->updateResourceMetafieldRequestBuilder = $updateResourceMetafieldRequestBuilder;
        $this->deleteResourceMetafieldRequestBuilder = $deleteResourceMetafieldRequestBuilder;
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
     * Delete product.
     *
     * Returns an empty object with no properties if successful.
     *
     * @see https://help.shopify.com/api/reference/product#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @return object
     */
    public function deleteProduct(
        RequestCredentialsInterface $credentials,
        int $productId
    ) {
        $response = $this->asyncDeleteProduct($credentials, $productId)->wait();

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Async version of self::deleteProduct
     *
     * @see https://help.shopify.com/api/reference/product#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @return PromiseInterface
     */
    public function asyncDeleteProduct(
        RequestCredentialsInterface $credentials,
        int $productId
    ): PromiseInterface {
        $product = (new Models\Product())->setId($productId);
        $request = $this->deleteProductRequestBuilder
            ->withCredentials($credentials)
            ->withProduct($product);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience version of self::asyncGetProductMetafields
     *
     * @see https://help.shopify.com/api/reference/metafield#index
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @return array|Metafield[]
     */
    public function getProductMetafields(RequestCredentialsInterface $credentials, int $productId): array
    {
        $response = $this->asyncGetProductMetafields($credentials, $productId)->wait();

        return $this->metafieldTransformer->fromArrayResponse($response);
    }

    /**
     * Get metafields that belong to a product
     *
     * @see https://help.shopify.com/api/reference/metafield#index
     * @param RequestCredentialsInterface $credentials
     * @param int $productId
     * @return PromiseInterface
     */
    public function asyncGetProductMetafields(RequestCredentialsInterface $credentials, int $productId): PromiseInterface
    {
        $request = $this->getResourceMetafieldsBuilder
            ->withCredentials($credentials)
            ->forProductId($productId);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::asyncCreateNewProductMetafield
     *
     * @see https://help.shopify.com/api/reference/metafield#create
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return Metafield
     */
    public function createNewProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ): Metafield {
        $response = $this->asyncCreateNewProductMetafield($credentials, $product, $metafield)->wait();

        return $this->metafieldTransformer->fromResponse($response);
    }

    /**
     * Create a new metafield for a product
     *
     * @see https://help.shopify.com/api/reference/metafield#create
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return PromiseInterface
     */
    public function asyncCreateNewProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ): PromiseInterface {
        $request = $this->createNewResourceMetafieldRequestBuilder
            ->forProduct($product)
            ->withCredentials($credentials)
            ->withMetafield($metafield);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::asyncUpdateProductMetafield
     *
     * @see https://help.shopify.com/api/reference/metafield#update
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return Metafield
     */
    public function updateProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ): Metafield {
        $response = $this->asyncUpdateProductMetafield($credentials, $product, $metafield)->wait();

        return $this->metafieldTransformer->fromResponse($response);
    }

    /**
     * Update a product metafield
     *
     * @see https://help.shopify.com/api/reference/metafield#updateProduct
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return PromiseInterface
     */
    public function asyncUpdateProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ): PromiseInterface {
        $request = $this->updateResourceMetafieldRequestBuilder
            ->forProduct($product)
            ->withCredentials($credentials)
            ->withMetafield($metafield);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::asyncDeleteProductMe
     *
     * @see https://help.shopify.com/api/reference/metafield#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return object
     */
    public function deleteProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ) {
        $response = $this->asyncDeleteProductMetafield($credentials, $product, $metafield)->wait();

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Delete a product metafield
     *
     * Returns an empty object with no properties if successful.
     *
     * @see https://help.shopify.com/api/reference/metafield#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Product $product
     * @param Metafield $metafield
     * @return PromiseInterface
     */
    public function asyncDeleteProductMetafield(
        RequestCredentialsInterface $credentials,
        Product $product,
        Metafield $metafield
    ): PromiseInterface {
        $request = $this->deleteResourceMetafieldRequestBuilder
            ->forProduct($product)
            ->withCredentials($credentials)
            ->withMetafield($metafield);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }
}
