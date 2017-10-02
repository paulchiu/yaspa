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
    const RESOURCE_LOCATION_URI_TEMPLATE_ARTICLES = '/admin/blogs/%s/articles/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_BLOGS = '/admin/blogs/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_COLLECTIONS = '/admin/collections/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMERS = '/admin/customers/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDERS = '/admin/draft_orders/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_ORDERS = '/admin/orders/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PAGES = '/admin/pages/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCTS = '/admin/products/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELD = '/admin/products/%s/metafields/%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANTS = '/admin/products/%s/variants/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SHOP = '/admin/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTIONS = '/admin/collections/%s/metafields.json';
}
