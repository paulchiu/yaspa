<?php

namespace Yaspa\AdminApi\Product\Builders;

use DateTime;
use Yaspa\AdminApi\Product\Constants\Product;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\PagingRequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetProductsRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/product#index
 * @todo Add support for models for fields like collectionId
 */
class GetProductsRequest implements PagingRequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/products.json';

    /** @var array|int[] $ids */
    protected $ids;
    /** @var int $limit */
    protected $limit;
    /** @var int $page */
    protected $page;
    /** @var int $sinceId */
    protected $sinceId;
    /** @var string $title */
    protected $title;
    /** @var string $vendor */
    protected $vendor;
    /** @var string $handle */
    protected $handle;
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
    /** @var ProductFields $productFields */
    protected $productFields;

    /**
     * GetProductsRequest constructor.
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

        if (!is_null($this->limit)) {
            $array['limit'] = $this->limit;
        }

        if (!is_null($this->page)) {
            $array['page'] = $this->page;
        }

        if (!is_null($this->sinceId)) {
            $array['since_id'] = $this->sinceId;
        }

        if (!is_null($this->title)) {
            $array['title'] = $this->title;
        }

        if (!is_null($this->vendor)) {
            $array['vendor'] = $this->vendor;
        }

        if (!is_null($this->handle)) {
            $array['handle'] = $this->handle;
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

        if (!is_null($this->productFields)) {
            $array['fields'] = implode(',', $this->productFields->getFields());
        }

        return $array;
    }

    /**
     * @return int
     */
    public function getPage():? int
    {
        return $this->page;
    }

    /**
     * @param array|int[] $ids
     * @return GetProductsRequest
     */
    public function withIds(array $ids): GetProductsRequest
    {
        $new = clone $this;
        $new->ids = $ids;

        return $new;
    }

    /**
     * @param int $limit
     * @return GetProductsRequest
     */
    public function withLimit(int $limit): GetProductsRequest
    {
        $new = clone $this;
        $new->limit = $limit;

        return $new;
    }

    /**
     * @param int $page
     * @return GetProductsRequest
     */
    public function withPage(int $page): GetProductsRequest
    {
        $new = clone $this;
        $new->page = $page;

        return $new;
    }

    /**
     * @param int $sinceId
     * @return GetProductsRequest
     */
    public function withSinceId(int $sinceId): GetProductsRequest
    {
        $new = clone $this;
        $new->sinceId = $sinceId;

        return $new;
    }

    /**
     * @param string $title
     * @return GetProductsRequest
     */
    public function withTitle(string $title): GetProductsRequest
    {
        $new = clone $this;
        $new->title = $title;

        return $new;
    }

    /**
     * @param string $vendor
     * @return GetProductsRequest
     */
    public function withVendor(string $vendor): GetProductsRequest
    {
        $new = clone $this;
        $new->vendor = $vendor;

        return $new;
    }

    /**
     * @param string $handle
     * @return GetProductsRequest
     */
    public function withHandle(string $handle): GetProductsRequest
    {
        $new = clone $this;
        $new->handle = $handle;

        return $new;
    }

    /**
     * @param string $productType
     * @return GetProductsRequest
     */
    public function withProductType(string $productType): GetProductsRequest
    {
        $new = clone $this;
        $new->productType = $productType;

        return $new;
    }

    /**
     * @param int $collectionId
     * @return GetProductsRequest
     */
    public function withCollectionId(int $collectionId): GetProductsRequest
    {
        $new = clone $this;
        $new->collectionId = $collectionId;

        return $new;
    }

    /**
     * @param DateTime $createdAtMin
     * @return GetProductsRequest
     */
    public function withCreatedAtMin(DateTime $createdAtMin): GetProductsRequest
    {
        $new = clone $this;
        $new->createdAtMin = $createdAtMin;

        return $new;
    }

    /**
     * @param DateTime $createdAtMax
     * @return GetProductsRequest
     */
    public function withCreatedAtMax(DateTime $createdAtMax): GetProductsRequest
    {
        $new = clone $this;
        $new->createdAtMax = $createdAtMax;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMin
     * @return GetProductsRequest
     */
    public function withUpdatedAtMin(DateTime $updatedAtMin): GetProductsRequest
    {
        $new = clone $this;
        $new->updatedAtMin = $updatedAtMin;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMax
     * @return GetProductsRequest
     */
    public function withUpdatedAtMax(DateTime $updatedAtMax): GetProductsRequest
    {
        $new = clone $this;
        $new->updatedAtMax = $updatedAtMax;

        return $new;
    }

    /**
     * @param DateTime $publishedAtMin
     * @return GetProductsRequest
     */
    public function withPublishedAtMin(DateTime $publishedAtMin): GetProductsRequest
    {
        $new = clone $this;
        $new->publishedAtMin = $publishedAtMin;

        return $new;
    }

    /**
     * @param DateTime $publishedAtMax
     * @return GetProductsRequest
     */
    public function withPublishedAtMax(DateTime $publishedAtMax): GetProductsRequest
    {
        $new = clone $this;
        $new->publishedAtMax = $publishedAtMax;

        return $new;
    }

    /**
     * @return GetProductsRequest
     */
    public function withPublished(): GetProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_PUBLISHED;

        return $new;
    }

    /**
     * @return GetProductsRequest
     */
    public function withUnPublished(): GetProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_UNPUBLISHED;

        return $new;
    }

    /**
     * @return GetProductsRequest
     */
    public function withAnyPublishedStatus(): GetProductsRequest
    {
        $new = clone $this;
        $new->publishedStatus = Product::PUBLISHED_STATUS_ANY;

        return $new;
    }

    /**
     * @param ProductFields $productFields
     * @return GetProductsRequest
     */
    public function withProductFields(ProductFields $productFields): GetProductsRequest
    {
        $new = clone $this;
        $new->productFields = $productFields;

        return $new;
    }
}
