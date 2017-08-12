<?php

namespace Yaspa\AdminApi\Product\Builders;

use Yaspa\AdminApi\Product\Models\Product as ProductModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class GetProductRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/product#show
 */
class GetProductRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/products/%s.json';

    /**
     * Builder properties
     */
    /** @var ProductModel $productModel */
    protected $productModel;
    /** @var ProductFields $productFields */
    protected $productFields;

    /**
     * GetProductRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
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
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->productFields)) {
            $array['fields'] = implode(',', $this->productFields->getFields());
        }

        return $array;
    }

    /**
     * @param ProductModel $productModel
     * @return GetProductRequest
     */
    public function withProduct(ProductModel $productModel): GetProductRequest
    {
        $new = clone $this;
        $new->productModel = $productModel;

        return $new;
    }

    /**
     * @param ProductFields $productFields
     * @return GetProductRequest
     */
    public function withProductFields(ProductFields $productFields): GetProductRequest
    {
        $new = clone $this;
        $new->productFields = $productFields;

        return $new;
    }
}
