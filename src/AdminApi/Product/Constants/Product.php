<?php

namespace Yaspa\AdminApi\Product\Constants;

/**
 * Class Product
 *
 * @package Yaspa\AdminApi\Product\Constants
 * @see https://help.shopify.com/api/reference/product
 */
class Product
{
    const PUBLISHED_SCOPE_GLOBAL = 'global';
    const PUBLISHED_SCOPE_WEB = 'web';
    const PUBLISHED_SCOPES = [
        self::PUBLISHED_SCOPE_GLOBAL,
        self::PUBLISHED_SCOPE_WEB,
    ];
    const PUBLISHED_STATUS_PUBLISHED = 'published';
    const PUBLISHED_STATUS_UNPUBLISHED = 'unpublished';
    const PUBLISHED_STATUS_ANY = 'any';
}
