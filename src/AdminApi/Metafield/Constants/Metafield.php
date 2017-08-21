<?php

namespace Yaspa\AdminApi\Metafield\Constants;

/**
 * Class Metafield
 *
 * @package Yaspa\AdminApi\Metafield\Constants
 * @see https://help.shopify.com/api/reference/metafield
 */
class Metafield
{
    const VALUE_TYPE_INTEGER = 'integer';
    const VALUE_TYPE_STRING = 'string';
    const VALUE_TYPES = [
        self::VALUE_TYPE_INTEGER,
        self::VALUE_TYPE_STRING,
    ];
}
