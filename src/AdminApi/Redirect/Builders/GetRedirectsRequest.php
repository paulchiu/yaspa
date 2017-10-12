<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\PagingRequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetRedirectsRequest
 *
 * @package Yaspa\AdminApi\Redirect\Builders
 * @see https://help.shopify.com/api/reference/redirect#index
 */
class GetRedirectsRequest implements PagingRequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects.json';

    /** @var array|int[] $ids */
    protected $ids;
    /** @var int $sinceId */
    protected $sinceId;
    /** @var string $path */
    protected $path;
    /** @var string $target */
    protected $target;
    /** @var int $limit */
    protected $limit;
    /** @var int $page */
    protected $page;
    /** @var RedirectFields $redirectFields */
    protected $redirectFields;

    /**
     * GetRedirectsRequest constructor.
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

        if (!is_null($this->sinceId)) {
            $array['since_id'] = $this->sinceId;
        }

        if (!is_null($this->path)) {
            $array['path'] = $this->path;
        }

        if (!is_null($this->target)) {
            $array['target'] = $this->target;
        }

        if (!is_null($this->limit)) {
            $array['limit'] = $this->limit;
        }

        if (!is_null($this->page)) {
            $array['page'] = $this->page;
        }

        if (!is_null($this->redirectFields)) {
            $array['fields'] = implode(',', $this->redirectFields->getFields());
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
     * @param int $sinceId
     * @return GetRedirectsRequest
     */
    public function withSinceId(int $sinceId): GetRedirectsRequest
    {
        $new = clone $this;
        $new->sinceId = $sinceId;

        return $new;
    }

    /**
     * @param string $path
     * @return GetRedirectsRequest
     */
    public function withPath(string $path): GetRedirectsRequest
    {
        $new = clone $this;
        $new->path = $path;

        return $new;
    }

    /**
     * @param string $target
     * @return GetRedirectsRequest
     */
    public function withTarget(string $target): GetRedirectsRequest
    {
        $new = clone $this;
        $new->target = $target;

        return $new;
    }

    /**
     * @param int $limit
     * @return GetRedirectsRequest
     */
    public function withLimit(int $limit): GetRedirectsRequest
    {
        $new = clone $this;
        $new->limit = $limit;

        return $new;
    }

    /**
     * @param int $page
     * @return GetRedirectsRequest
     */
    public function withPage(int $page): GetRedirectsRequest
    {
        $new = clone $this;
        $new->page = $page;

        return $new;
    }

    /**
     * @param RedirectFields $redirectFields
     * @return GetRedirectsRequest
     */
    public function withRedirectFields(RedirectFields $redirectFields): GetRedirectsRequest
    {
        $new = clone $this;
        $new->redirectFields = $redirectFields;

        return $new;
    }
}
