<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class GetResourceMetafieldRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/metafield#index
 * @todo Follow objective of "Work with native models where possible", add model methods as resource integrations are done
 */
class GetResourceMetafieldRequest
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com';

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;

    /**
     * GetResourceMetafieldRequest constructor.
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
     * @return int|null
     */
    public function toResourceId()
    {
        return $this->metafieldModel->getId();
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return GetResourceMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }

    /**
     * @param int $blogId
     * @param int $articleId
     * @return GetResourceMetafieldRequest
     */
    public function forArticleId(int $blogId, int $articleId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLE_METAFIELD, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return GetResourceMetafieldRequest
     */
    public function forBlogId(int $blogId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOG_METAFIELD, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return GetResourceMetafieldRequest
     */
    public function forCollectionId(int $collectionId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return GetResourceMetafieldRequest
     */
    public function forCustomerId(int $customerId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMER_METAFIELD, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return GetResourceMetafieldRequest
     */
    public function forDraftOrderId(int $draftOrderId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDER_METAFIELD, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return GetResourceMetafieldRequest
     */
    public function forOrderId(int $orderId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDER_METAFIELD, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return GetResourceMetafieldRequest
     */
    public function forPageId(int $pageId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGE_METAFIELD, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return GetResourceMetafieldRequest
     */
    public function forProductId(int $productId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELD, $productId);

        return $new;
    }

    /**
     * This is a convenience wrapper for self::forProductId
     *
     * @param Product $product
     * @return GetResourceMetafieldRequest
     */
    public function forProduct(Product $product): GetResourceMetafieldRequest
    {
        return $this->forProductId($product->getId());
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return GetResourceMetafieldRequest
     */
    public function forProductVariantId(int $productId, int $variantId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANT_METAFIELD, $productId, $variantId);

        return $new;
    }

    /**
     * @return GetResourceMetafieldRequest
     */
    public function forShop(): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return GetResourceMetafieldRequest
     */
    public function forSmartCollectionId(int $collectionId): GetResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }
}
