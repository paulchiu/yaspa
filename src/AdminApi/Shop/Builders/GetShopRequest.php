<?php

namespace Yaspa\AdminApi\Shop\Builders;

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

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'GET';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/shop.json';

    /**
     * GetShopRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->httpMethod = self::HTTP_METHOD;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->headers = self::HEADERS;
    }
}
