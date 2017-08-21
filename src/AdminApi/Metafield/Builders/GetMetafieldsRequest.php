<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use DateTime;
use Yaspa\AdminApi\Metafield\Constants\Metafield;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetMetafieldsRequest
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/metafield#index
 */
class GetMetafieldsRequest
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/metafields.json';

    /** @var int $limit */
    protected $limit;
    /** @var int $sinceId */
    protected $sinceId;
    /** @var DateTime $createdAtMin */
    protected $createdAtMin;
    /** @var DateTime $createdAtMax */
    protected $createdAtMax;
    /** @var DateTime $updatedAtMin */
    protected $updatedAtMin;
    /** @var DateTime $updatedAtMax */
    protected $updatedAtMax;
    /** @var string $key */
    protected $key;
    /** @var string $namespace */
    protected $namespace;
    /** @var string $valueType Should be one of \Yaspa\AdminApi\Metafield\Constants\Metafield::VALUE_TYPES */
    protected $valueType;
    /** @var MetafieldFields $metafieldFields */
    protected $metafieldFields;

    /**
     * GetMetafieldsRequest constructor.
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

        if (!is_null($this->limit)) {
            $array['limit'] = $this->limit;
        }

        if (!is_null($this->sinceId)) {
            $array['since_id'] = $this->sinceId;
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

        if (!is_null($this->namespace)) {
            $array['namespace'] = $this->namespace;
        }

        if (!is_null($this->key)) {
            $array['key'] = $this->key;
        }

        if (!is_null($this->valueType)) {
            $array['value_type'] = $this->valueType;
        }

        if (!is_null($this->metafieldFields)) {
            $array['fields'] = implode(',', $this->metafieldFields->getFields());
        }

        return $array;
    }

    /**
     * @param int $limit
     * @return GetMetafieldsRequest
     */
    public function withLimit(int $limit): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->limit = $limit;

        return $new;
    }

    /**
     * @param int $sinceId
     * @return GetMetafieldsRequest
     */
    public function withSinceId(int $sinceId): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->sinceId = $sinceId;

        return $new;
    }

    /**
     * @param DateTime $createdAtMin
     * @return GetMetafieldsRequest
     */
    public function withCreatedAtMin(DateTime $createdAtMin): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->createdAtMin = $createdAtMin;

        return $new;
    }

    /**
     * @param DateTime $createdAtMax
     * @return GetMetafieldsRequest
     */
    public function withCreatedAtMax(DateTime $createdAtMax): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->createdAtMax = $createdAtMax;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMin
     * @return GetMetafieldsRequest
     */
    public function withUpdatedAtMin(DateTime $updatedAtMin): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->updatedAtMin = $updatedAtMin;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMax
     * @return GetMetafieldsRequest
     */
    public function withUpdatedAtMax(DateTime $updatedAtMax): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->updatedAtMax = $updatedAtMax;

        return $new;
    }

    /**
     * @param string $namespace
     * @return GetMetafieldsRequest
     */
    public function withNamespace(string $namespace): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->namespace = $namespace;

        return $new;
    }

    /**
     * @param string $key
     * @return GetMetafieldsRequest
     */
    public function withKey(string $key): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->key = $key;

        return $new;
    }

    /**
     * @param string $valueType
     * @return GetMetafieldsRequest
     */
    public function withValueType(string $valueType): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->valueType = $valueType;

        return $new;
    }

    /**
     * @return GetMetafieldsRequest
     */
    public function withValueTypeInteger(): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->valueType = Metafield::VALUE_TYPE_INTEGER;

        return $new;
    }

    /**
     * @return GetMetafieldsRequest
     */
    public function withValueTypeString(): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->valueType = Metafield::VALUE_TYPE_STRING;

        return $new;
    }

    /**
     * @param MetafieldFields $metafieldFields
     * @return GetMetafieldsRequest
     */
    public function withMetafieldFields(MetafieldFields $metafieldFields): GetMetafieldsRequest
    {
        $new = clone $this;
        $new->metafieldFields = $metafieldFields;

        return $new;
    }
}
