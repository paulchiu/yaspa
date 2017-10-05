<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class UpdateResourceMetafieldRequest
 *
 * @package Yaspa\AdminApi\Metafield\Builders
 * @see https://help.shopify.com/api/reference/metafield#update
 */
class UpdateResourceMetafieldRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com';

    /**
     * Dependencies
     */
    /** @var MetafieldTransformer */
    protected $metafieldTransformer;

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;
    /** @var array|MetafieldModel[] $metafields */
    protected $metafields;

    /**
     * UpdateResourceMetafieldRequest constructor.
     *
     * @param MetafieldTransformer $metafieldTransformer
     */
    public function __construct(MetafieldTransformer $metafieldTransformer)
    {
        // Set dependencies
        $this->metafieldTransformer = $metafieldTransformer;

        // Set properties with defaults
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::PUT_HTTP_METHOD;
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
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->metafieldModel)) {
            $array = $this->metafieldTransformer->toArray($this->metafieldModel);
        }

        return ['metafield' => $array];
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return UpdateResourceMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }

    /**
     * @param int $blogId
     * @param int $articleId
     * @return UpdateResourceMetafieldRequest
     */
    public function forArticleId(int $blogId, int $articleId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLE_METAFIELD, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return UpdateResourceMetafieldRequest
     */
    public function forBlogId(int $blogId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOG_METAFIELD, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return UpdateResourceMetafieldRequest
     */
    public function forCollectionId(int $collectionId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return UpdateResourceMetafieldRequest
     */
    public function forCustomerId(int $customerId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMER_METAFIELD, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return UpdateResourceMetafieldRequest
     */
    public function forDraftOrderId(int $draftOrderId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDER_METAFIELD, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return UpdateResourceMetafieldRequest
     */
    public function forOrderId(int $orderId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDER_METAFIELD, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return UpdateResourceMetafieldRequest
     */
    public function forPageId(int $pageId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGE_METAFIELD, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return UpdateResourceMetafieldRequest
     */
    public function forProductId(int $productId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELD, $productId);

        return $new;
    }

    /**
     * This is a convenience wrapper for self::forProductId
     *
     * @param Product $product
     * @return UpdateResourceMetafieldRequest
     */
    public function forProduct(Product $product): UpdateResourceMetafieldRequest
    {
        return $this->forProductId($product->getId());
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return UpdateResourceMetafieldRequest
     */
    public function forProductVariantId(int $productId, int $variantId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANT_METAFIELD, $productId, $variantId);

        return $new;
    }

    /**
     * @return UpdateResourceMetafieldRequest
     */
    public function forShop(): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP_METAFIELD);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return UpdateResourceMetafieldRequest
     */
    public function forSmartCollectionId(int $collectionId): UpdateResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTION_METAFIELD, $collectionId);

        return $new;
    }
}
