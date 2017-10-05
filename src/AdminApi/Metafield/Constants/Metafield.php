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

    /**
     * Note: The *_METAFIELD constants use '%%s' for the id field because the constant is expected to be used by
     * two sprintf statements before being complete
     */
    const RESOURCE_LOCATION_URI_TEMPLATE_ARTICLES = '/admin/blogs/%s/articles/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_ARTICLE_METAFIELD = '/admin/blogs/%s/articles/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_BLOGS = '/admin/blogs/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_BLOG_METAFIELD = '/admin/blogs/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_COLLECTIONS = '/admin/collections/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_COLLECTION_METAFIELD = '/admin/collections/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMERS = '/admin/customers/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_CUSTOMER_METAFIELD = '/admin/customers/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDERS = '/admin/draft_orders/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_DRAFT_ORDER_METAFIELD = '/admin/draft_orders/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_ORDERS = '/admin/orders/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_ORDER_METAFIELD = '/admin/orders/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PAGES = '/admin/pages/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PAGE_METAFIELD = '/admin/pages/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCTS = '/admin/products/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_METAFIELD = '/admin/products/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANTS = '/admin/products/%s/variants/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_PRODUCT_VARIANT_METAFIELD = '/admin/products/%s/variants/%s/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SHOP = '/admin/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SHOP_METAFIELD = '/admin/metafields/%%s.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTIONS = '/admin/collections/%s/metafields.json';
    const RESOURCE_LOCATION_URI_TEMPLATE_SMART_COLLECTION_METAFIELD = '/admin/collections/%s/metafields/%%s.json';
}
