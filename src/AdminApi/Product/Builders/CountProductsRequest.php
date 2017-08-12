<?php

namespace Yaspa\AdminApi\Product\Builders;

use DateTime;
use Yaspa\AdminApi\Product\Constants\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CountProductsRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/product#count
 */
class CountProductsRequest
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/products/count.json';

    /** @var string $vendor */
    protected $vendor;
    /** @var string $productType */
    protected $productType;
    /** @var int $collectionId */
    protected $collectionId;
    /** @var DateTime $createdAtMin */
    protected $createdAtMin;
    /** @var DateTime $createdAtMax */
    protected $createdAtMax;
    /** @var DateTime $updatedAtMin */
    protected $updatedAtMin;
    /** @var DateTime $updatedAtMax */
    protected $updatedAtMax;
    /** @var DateTime $publishedAtMin */
    protected $publishedAtMin;
    /** @var DateTime $publishedAtMax */
    protected $publishedAtMax;
    /** @var string $publishedStatus */
    protected $publishedStatus;

    /**
     * CountProductsRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::QUERY_BODY_TYPE;
        $this->page = RequestBuilder::STARTING_PAGE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!empty($this->ids)) {
            $array['ids'] = implode(',', $this->ids);
        }

        if (!is_null($this->vendor)) {
            $array['vendor'] = $this->vendor;
        }

        if (!is_null($this->productType)) {
            $array['product_type'] = $this->productType;
        }

        if (!is_null($this->collectionId)) {
            $array['collection_id'] = $this->collectionId;
        }

        if (!is_null($this->createdAtMin)) {
            $array['created_at_min'] = $this->createdAtMin->format(DateTime::ISO8601);
        }

        if (!is_null($this->createdAtMax)) {
            $array['created_at_max'] = $this->createdAtMax->format(DateTime::ISO8601);
        }

        if (!is_null($this->updatedAtMin)) {
            $array['updated_at_min'] = $this->updatedAtMin->format(DateTime::ISO8601);
        }

        if (!is_null($this->updatedAtMax)) {
            $array['updated_at_max'] = $this->updatedAtMax->format(DateTime::ISO8601);
        }

        if (!is_null($this->publishedAtMin)) {
            $array['published_at_min'] = $this->publishedAtMin->format(DateTime::ISO8601);
        }

        if (!is_null($this->publishedAtMax)) {
            $array['published_at_max'] = $this->publishedAtMax->format(DateTime::ISO8601);
        }

        if (!is_null($this->publishedStatus)) {
            $array['published_status'] = $this->publishedStatus;
        }

        return $array;
    }

    /**
     * @param string $vendor
     * @return CountProductsRequest
     */
    public function withVendor(string $vendor): CountProductsRequest
    {
        $new = clone $this;
        $new->vendor = $vendor;

        return $new;
    }

    /**
     * @param string $productType
     * @return CountProductsRequest
     */
    public function withProductType(string $productType): CountProductsRequest
    {
        $new = clone $this;
        $new->productType = $productType;

        return $new;
    }

    /**
     * @param int $collectionId
     * @return CountProductsRequest
     */
    public function withCollectionId(int $collectionId): CountProductsRequest
    {
        $new = clone $this;
        $new->collectionId = $collectionId;

        return $new;
    }

    /**
     * @param DateTime $createdAtMin
     * @return CountProductsRequest
     */
    public function withCreatedAtMin(DateTime $createdAtMin): CountProductsRequest
    {
        $new = clone $this;
        $new->createdAtMin = $createdAtMin;

        return $new;
    }

    /**
     * @param DateTime $createdAtMax
     * @return CountProductsRequest
     */
    public function withCreatedAtMax(DateTime $createdAtMax): CountProductsRequest
    {
        $new = clone $this;
        $new->createdAtMax = $createdAtMax;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMin
     * @return CountProductsRequest
     */
    public function withUpdatedAtMin(DateTime $updatedAtMin): CountProductsRequest
    {
        $new = clone $this;
        $new->updatedAtMin = $updatedAtMin;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMax
     * @return CountProductsRequest
     */
    public function withUpdatedAtMax(DateTime $updatedAtMax): CountProductsRequest
    {
        $new = clone $this;
        $new->updatedAtMax = $updatedAtMax;

        return $new;
    }

    /**
     * @param DateTime $publishedAtMin
     * @return CountProductsRequest
     */
    public function withPublishedAtMin(DateTime $publishedAtMin): CountProductsRequest
    {
        $new = clone $this;
        $new->publishedAtMin = $publishedAtMin;

        return $new;
    }

    /**
     * @param DateTime $publishedAtMax
     * @return CountProductsRequest
     */
    public function withPublishedAtMax(DateTime $publishedAtMax): CountProductsRequest
    {
        $new = clone $this;
        $new->publishedAtMax = $publishedAtMax;

        return $new;
    }

    /**
     * @return CountProductsRequest
     */
    public function withPublished(): CountProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_PUBLISHED;

        return $new;
    }

    /**
     * @return CountProductsRequest
     */
    public function withUnPublished(): CountProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_UNPUBLISHED;

        return $new;
    }

    /**
     * @return CountProductsRequest
     */
    public function withAnyPublishedStatus(): CountProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_ANY;

        return $new;
    }
}
