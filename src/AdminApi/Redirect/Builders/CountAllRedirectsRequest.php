<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CountAllRedirectsRequest
 *
 * @package Yaspa\AdminApi\Redirect\Builders
 * @see https://help.shopify.com/api/reference/redirect#count
 */
class CountAllRedirectsRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects/count.json';

    /**
     * Builder properties
     */
    /** @var string $path */
    protected $path;
    /** @var string $target */
    protected $target;

    /**
     * CountAllRedirectsRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::QUERY_BODY_TYPE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->path)) {
            $array['path'] = $this->path;
        }

        if (!is_null($this->target)) {
            $array['target'] = $this->target;
        }

        return $array;
    }

    /**
     * @param string $path
     * @return CountAllRedirectsRequest
     */
    public function withPath(string $path): CountAllRedirectsRequest
    {
        $new = clone $this;
        $new->path = $path;

        return $new;
    }

    /**
     * @param string $target
     * @return CountAllRedirectsRequest
     */
    public function withTarget(string $target): CountAllRedirectsRequest
    {
        $new = clone $this;
        $new->target = $target;

        return $new;
    }
}
