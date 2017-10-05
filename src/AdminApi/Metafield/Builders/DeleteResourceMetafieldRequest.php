<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class DeleteResourceMetafieldRequest
 *
 * @package Yaspa\AdminApi\Metafield\Builders
 * @see https://help.shopify.com/api/reference/metafield#destroy
 */
class DeleteResourceMetafieldRequest implements RequestBuilderInterface
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
     * DeleteResourceMetafieldRequest constructor.
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
        return $this->metafieldModel->getId();
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return DeleteResourceMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }

    /**
     * @param int $blogId
     * @param int $articleId
     * @return DeleteResourceMetafieldRequest
     */
    public function forArticleId(int $blogId, int $articleId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLE_METAFIELD, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return DeleteResourceMetafieldRequest
     */
    public function forBlogId(int $blogId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOG_METAFIELD, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return DeleteResourceMetafieldRequest
     */
    public function forCollectionId(int $collectionId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return DeleteResourceMetafieldRequest
     */
    public function forCustomerId(int $customerId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMER_METAFIELD, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return DeleteResourceMetafieldRequest
     */
    public function forDraftOrderId(int $draftOrderId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDER_METAFIELD, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return DeleteResourceMetafieldRequest
     */
    public function forOrderId(int $orderId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDER_METAFIELD, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return DeleteResourceMetafieldRequest
     */
    public function forPageId(int $pageId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGE_METAFIELD, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return DeleteResourceMetafieldRequest
     */
    public function forProductId(int $productId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELD, $productId);

        return $new;
    }

    /**
     * This is a convenience wrapper for self::forProductId
     *
     * @param Product $product
     * @return DeleteResourceMetafieldRequest
     */
    public function forProduct(Product $product): DeleteResourceMetafieldRequest
    {
        return $this->forProductId($product->getId());
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return DeleteResourceMetafieldRequest
     */
    public function forProductVariantId(int $productId, int $variantId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANT_METAFIELD, $productId, $variantId);

        return $new;
    }

    /**
     * @return DeleteResourceMetafieldRequest
     */
    public function forShop(): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP_METAFIELD);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return DeleteResourceMetafieldRequest
     */
    public function forSmartCollectionId(int $collectionId): DeleteResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }
}
