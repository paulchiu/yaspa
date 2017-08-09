<?php

namespace Yaspa\AdminApi\Product\Constants;

/**
 * Class Variant
 *
 * @package Yaspa\AdminApi\Product\Constants
 * @see https://help.shopify.com/api/reference/product
 *
 * Constants described in the "variants" row of the "Product properties" table in
 * the Shopify product resource documentation.
 */
class Variant
{
    const WEIGHT_UNIT_GRAMS = 'g';
    const WEIGHT_UNIT_KILOGRAMS = 'kg';
    const WEIGHT_UNIT_OUNCES = 'oz';
    const WEIGHT_UNIT_POUNDS = 'lb';
    const WEIGHT_UNITS = [
        self::WEIGHT_UNIT_GRAMS,
        self::WEIGHT_UNIT_KILOGRAMS,
        self::WEIGHT_UNIT_OUNCES,
        self::WEIGHT_UNIT_POUNDS,
    ];
}
