<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CountResourceMetafieldsRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/metafield#count
 * @todo Follow objective of "Work with native models where possible", add model methods as resource integrations are done
 */
class CountResourceMetafieldsRequest
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com';

    /**
     * CountResourceMetafieldsRequest constructor.
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
     * @return CountResourceMetafieldsRequest
     */
    public function forArticleId(int $blogId, int $articleId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLE_METAFIELDS_COUNT, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return CountResourceMetafieldsRequest
     */
    public function forBlogId(int $blogId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOG_METAFIELDS_COUNT, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return CountResourceMetafieldsRequest
     */
    public function forCollectionId(int $collectionId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTION_METAFIELDS_COUNT, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return CountResourceMetafieldsRequest
     */
    public function forCustomerId(int $customerId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMER_METAFIELDS_COUNT, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return CountResourceMetafieldsRequest
     */
    public function forDraftOrderId(int $draftOrderId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDER_METAFIELDS_COUNT, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return CountResourceMetafieldsRequest
     */
    public function forOrderId(int $orderId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDER_METAFIELDS_COUNT, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return CountResourceMetafieldsRequest
     */
    public function forPageId(int $pageId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGE_METAFIELDS_COUNT, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return CountResourceMetafieldsRequest
     */
    public function forProductId(int $productId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELDS_COUNT, $productId);

        return $new;
    }

    /**
     * This is a convenience wrapper for self::forProductId
     *
     * @param Product $product
     * @return CountResourceMetafieldsRequest
     */
    public function forProduct(Product $product): CountResourceMetafieldsRequest
    {
        return $this->forProductId($product->getId());
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return CountResourceMetafieldsRequest
     */
    public function forProductVariantId(int $productId, int $variantId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANT_METAFIELDS_COUNT, $productId, $variantId);

        return $new;
    }

    /**
     * @return CountResourceMetafieldsRequest
     */
    public function forShop(): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return CountResourceMetafieldsRequest
     */
    public function forSmartCollectionId(int $collectionId): CountResourceMetafieldsRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTION_METAFIELDS_COUNT, $collectionId);

        return $new;
    }
}
