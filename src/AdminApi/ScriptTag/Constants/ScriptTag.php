<?php

namespace Yaspa\AdminApi\ScriptTag\Constants;

/**
 * Class ScriptTag
 *
 * @package Yaspa\AdminApi\ScriptTag\Constants
 * @see https://help.shopify.com/api/reference/scripttag
 */
class ScriptTag
{
    const DISPLAY_SCOPE_ALL = 'all';
    const DISPLAY_SCOPE_ONLINE_STORE = 'online_store';
    const DISPLAY_SCOPE_ORDER_STATUS = 'order_status';
    const DISPLAY_SCOPES = [
        self::DISPLAY_SCOPE_ALL,
        self::DISPLAY_SCOPE_ONLINE_STORE,
        self::DISPLAY_SCOPE_ORDER_STATUS,
    ];
    const EVENT_ONLOAD = 'onload';
}
