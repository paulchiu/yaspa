<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use DateTime;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\PagingRequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetScriptTagsRequest
 *
 * @package Yaspa\AdminApi\ScriptTags\Builders
 * @see https://help.shopify.com/api/reference/scripttag#index
 */
class GetScriptTagsRequest implements PagingRequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags.json';

    /** @var int $limit */
    protected $limit;
    /** @var int $page */
    protected $page;
    /** @var int $sinceId */
    protected $sinceId;
    /** @var string $src */
    protected $src;
    /** @var DateTime $createdAtMin */
    protected $createdAtMin;
    /** @var DateTime $createdAtMax */
    protected $createdAtMax;
    /** @var DateTime $updatedAtMin */
    protected $updatedAtMin;
    /** @var DateTime $updatedAtMax */
    protected $updatedAtMax;
    /** @var ScriptTagFields $scriptTagFields */
    protected $scriptTagFields;

    /**
     * GetScriptTagsRequest constructor.
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

        if (!is_null($this->page)) {
            $array['page'] = $this->page;
        }

        if (!is_null($this->sinceId)) {
            $array['since_id'] = $this->sinceId;
        }

        if (!is_null($this->src)) {
            $array['src'] = $this->src;
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

        if (!is_null($this->scriptTagFields)) {
            $array['fields'] = implode(',', $this->scriptTagFields->getFields());
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
     * @param int $limit
     * @return GetScriptTagsRequest
     */
    public function withLimit(int $limit): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->limit = $limit;

        return $new;
    }

    /**
     * @param int $page
     * @return GetScriptTagsRequest
     */
    public function withPage(int $page): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->page = $page;

        return $new;
    }

    /**
     * @param int $sinceId
     * @return GetScriptTagsRequest
     */
    public function withSinceId(int $sinceId): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->sinceId = $sinceId;

        return $new;
    }

    /**
     * @param string $src
     * @return GetScriptTagsRequest
     */
    public function withSrc(string $src): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->src = $src;

        return $new;
    }

    /**
     * @param DateTime $createdAtMin
     * @return GetScriptTagsRequest
     */
    public function withCreatedAtMin(DateTime $createdAtMin): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->createdAtMin = $createdAtMin;

        return $new;
    }

    /**
     * @param DateTime $createdAtMax
     * @return GetScriptTagsRequest
     */
    public function withCreatedAtMax(DateTime $createdAtMax): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->createdAtMax = $createdAtMax;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMin
     * @return GetScriptTagsRequest
     */
    public function withUpdatedAtMin(DateTime $updatedAtMin): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->updatedAtMin = $updatedAtMin;

        return $new;
    }

    /**
     * @param DateTime $updatedAtMax
     * @return GetScriptTagsRequest
     */
    public function withUpdatedAtMax(DateTime $updatedAtMax): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->updatedAtMax = $updatedAtMax;

        return $new;
    }

    /**
     * @param ScriptTagFields $scriptTagFields
     * @return GetScriptTagsRequest
     */
    public function withScriptTagFields(ScriptTagFields $scriptTagFields): GetScriptTagsRequest
    {
        $new = clone $this;
        $new->scriptTagFields = $scriptTagFields;

        return $new;
    }
}
