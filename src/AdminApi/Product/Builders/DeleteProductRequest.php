<?php

namespace Yaspa\AdminApi\Product\Builders;

use Yaspa\AdminApi\Product\Models\Product as ProductModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class DeleteProductRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/product#destroy
 */
class DeleteProductRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/products/%s.json';

    /**
     * Builder properties
     */
    /** @var ProductModel $productModel */
    protected $productModel;

    /**
     * DeleteProductRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::DELETE_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }

    /**
     * @return int|null
     */
    public function toResourceId()
    {
        return $this->productModel->getId();
    }

    /**
     * @param ProductModel $product
     * @return DeleteProductRequest
     */
    public function withProduct(ProductModel $product): DeleteProductRequest
    {
        $new = clone $this;
        $new->productModel = $product;

        return $new;
    }
}
