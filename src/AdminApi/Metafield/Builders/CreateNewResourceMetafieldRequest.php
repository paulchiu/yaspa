<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\AdminApi\Product\Models\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewResourceMetafieldRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/metafield#create
 */
class CreateNewResourceMetafieldRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com';

    /**
     * Dependencies
     */
    /** @var MetafieldTransformer $metafieldTransformer */
    protected $metafieldTransformer;

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;

    /**
     * CreateNewResourceMetafieldRequest constructor.
     *
     * @param MetafieldTransformer $metafieldTransformer
     */
    public function __construct(MetafieldTransformer $metafieldTransformer)
    {
        $this->metafieldTransformer = $metafieldTransformer;
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
        return ['metafield' => $this->metafieldTransformer->toArray($this->metafieldModel)];
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return CreateNewResourceMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }

    /**
     * @param int $blogId
     * @param int $articleId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forArticleId(int $blogId, int $articleId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ARTICLES, $blogId, $articleId);

        return $new;
    }

    /**
     * @param int $blogId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forBlogId(int $blogId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_BLOGS, $blogId);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forCollectionId(int $collectionId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_COLLECTIONS, $collectionId);

        return $new;
    }

    /**
     * @param int $customerId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forCustomerId(int $customerId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMERS, $customerId);

        return $new;
    }

    /**
     * @param int $draftOrderId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forDraftOrderId(int $draftOrderId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDERS, $draftOrderId);

        return $new;
    }

    /**
     * @param int $orderId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forOrderId(int $orderId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_ORDERS, $orderId);

        return $new;
    }

    /**
     * @param int $pageId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forPageId(int $pageId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PAGES, $pageId);

        return $new;
    }

    /**
     * @param int $productId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forProductId(int $productId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCTS, $productId);

        return $new;
    }

    /**
     * This is a convenience wrapper for self::forProductId
     *
     * @param Product $product
     * @return CreateNewResourceMetafieldRequest
     */
    public function forProduct(Product $product): CreateNewResourceMetafieldRequest
    {
        return $this->forProductId($product->getId());
    }

    /**
     * @param int $productId
     * @param int $variantId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forProductVariantId(int $productId, int $variantId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANTS, $productId, $variantId);

        return $new;
    }

    /**
     * @return CreateNewResourceMetafieldRequest
     */
    public function forShop(): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SHOP);

        return $new;
    }

    /**
     * @param int $collectionId
     * @return CreateNewResourceMetafieldRequest
     */
    public function forSmartCollectionId(int $collectionId): CreateNewResourceMetafieldRequest
    {
        $new = clone $this;
        $new->uriTemplate = self::URI_TEMPLATE . sprintf(Metafield::RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTIONS, $collectionId);

        return $new;
    }
}
