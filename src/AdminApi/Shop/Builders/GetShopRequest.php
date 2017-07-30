<?php

namespace Yaspa\AdminApi\Shop\Builders;

use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class GetShopRequest
 *
 * @package Yaspa\AdminApi\Shop\Builders
 * @mixin AuthorizedRequestBuilderTrait
 * @see https://help.shopify.com/api/reference/shop#show
 *
 * Show the shop details of the credentials used.
 */
class GetShopRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/shop.json';

    /**
     * GetShopRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::QUERY_BODY_TYPE;
    }
}
