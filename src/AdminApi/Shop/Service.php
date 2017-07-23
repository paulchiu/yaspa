<?php

namespace Yaspa\AdminApi\Shop;

use GuzzleHttp\Client;
use Yaspa\Authentication\Builders\ApiCredentials;

/**
 * Class Service
 *
 * @package Yaspa\AdminApi\Shop
 * @see https://help.shopify.com/api/reference/shop
 *
 * Shopify shop details service.
 */
class Service
{
    /** @var Client $httpClient */
    protected $httpClient;

    public function asyncGetShop(
        ApiCredentials $credentials
    ) {
        /**
         * @todo
         */
    }
}
