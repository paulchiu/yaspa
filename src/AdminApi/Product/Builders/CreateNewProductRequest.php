<?php

namespace Yaspa\AdminApi\Product\Builders;

use Yaspa\AdminApi\Product\Models\Product as ProductModel;
use Yaspa\AdminApi\Product\Transformers\Product as ProductTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewProductRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/product#create
 */
class CreateNewProductRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/products.json';

    /**
     * Dependencies
     */
    /** @var ProductTransformer $productTransformer */
    protected $productTransformer;

    /**
     * Builder properties
     */
    /** @var ProductModel $productModel */
    protected $productModel;

    /**
     * CreateNewProductRequest constructor.
     *
     * @param ProductTransformer $productTransformer
     */
    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::POST_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return ['product' => $this->productTransformer->toArray($this->productModel)];
    }

    /**
     * @param ProductModel $productModel
     * @return CreateNewProductRequest
     */
    public function withProduct(ProductModel $productModel): CreateNewProductRequest
    {
        $new = clone $this;
        $new->productModel = $productModel;

        return $new;
    }
}
