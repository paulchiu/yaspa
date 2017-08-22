<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetResourceMetafieldsRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/metafield#index
 */
class GetResourceMetafieldsRequest
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com';

    /**
     * GetResourceMetafieldsRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::QUERY_BODY_TYPE;
        $this->page = RequestBuilder::STARTING_PAGE;
    }

    /**
     * @param int $blogId
     * @param int $articleId
     * @return GetResourceMetafieldsRequest
     */
    public function forArticle(int $blogId, int $articleId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLES, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return GetResourceMetafieldsRequest
     */
    public function forBlog(int $blogId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOGS, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return GetResourceMetafieldsRequest
     */
    public function forCollection(int $collectionId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTIONS, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return GetResourceMetafieldsRequest
     */
    public function forCustomer(int $customerId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMERS, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return GetResourceMetafieldsRequest
     */
    public function forDraftOrder(int $draftOrderId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDERS, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return GetResourceMetafieldsRequest
     */
    public function forOrder(int $orderId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDERS, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return GetResourceMetafieldsRequest
     */
    public function forPage(int $pageId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGES, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return GetResourceMetafieldsRequest
     */
    public function forProduct(int $productId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCTS, $productId);

        return $new;
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return GetResourceMetafieldsRequest
     */
    public function forProductVariant(int $productId, int $variantId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANTS, $productId, $variantId);

        return $new;
    }

    /**
     * @return GetResourceMetafieldsRequest
     */
    public function forShop(): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return GetResourceMetafieldsRequest
     */
    public function forSmartCollection(int $collectionId): GetResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTIONS, $collectionId);

        return $new;
    }
}
