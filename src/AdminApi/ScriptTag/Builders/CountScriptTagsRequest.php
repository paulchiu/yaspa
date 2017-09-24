<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use DateTime;
use Yaspa\AdminApi\ScriptTag\Constants\ScriptTag;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CountScriptTagsRequest
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#count
 */
class CountScriptTagsRequest
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags/count.json';

    /** @var string $src */
    protected $src;

    /**
     * CountScriptTagsRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
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

        if (!empty($this->ids)) {
            $array['ids'] = implode(',', $this->ids);
        }

        if (!is_null($this->src)) {
            $array['src'] = $this->src;
        }

        return $array;
    }

    /**
     * @param string $src
     * @return CountScriptTagsRequest
     */
    public function withSrc(string $src): CountScriptTagsRequest
    {
        $new = clone $this;
        $new->src = $src;

        return $new;
    }
}
