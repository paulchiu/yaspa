<?php

namespace Yaspa\OAuth;

use GuzzleHttp\Psr7\Uri;

/**
 * Class AuthorizePrompt
 * @package Yaspa\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission
 *
 * OAuth authorization prompt immutable URI builder.
 *
 * Example - Get URI string to request read content scope
 *
 * ```
 * $authPromptUriString = (new AuthorizePrompt('http://foo.example.com'))
 *     ->withShop('bar')
 *     ->withApiKey('baz')
 *     ->withReadContentScope()
 *     ->toUri()
 *     ->__toString();
 * ```
 */
class AuthorizePrompt
{
    /**
     * Scopes are defined in https://help.shopify.com/api/getting-started/authentication/oauth#scopes
     */
    const SCOPE_READ_CONTENT = 'read_content';
    const SCOPE_WRITE_CONTENT = 'write_content';
    const SCOPE_READ_THEMES = 'read_themes';
    const SCOPE_WRITE_THEMES = 'write_themes';
    const SCOPE_READ_PRODUCTS = 'read_products';
    const SCOPE_WRITE_PRODUCTS = 'write_products';
    const SCOPE_READ_CUSTOMERS = 'read_customers';
    const SCOPE_WRITE_CUSTOMERS = 'write_customers';
    const SCOPE_READ_ORDERS = 'read_orders';
    const SCOPE_WRITE_ORDERS = 'write_orders';
    const SCOPE_READ_DRAFT_ORDERS = 'read_draft_orders';
    const SCOPE_WRITE_DRAFT_ORDERS = 'write_draft_orders';
    const SCOPE_READ_SCRIPT_TAGS = 'read_script_tags';
    const SCOPE_WRITE_SCRIPT_TAGS = 'write_script_tags';
    const SCOPE_READ_FULFILLMENTS = 'read_fulfillments';
    const SCOPE_WRITE_FULFILLMENTS = 'write_fulfillments';
    const SCOPE_READ_SHIPPING = 'read_shipping';
    const SCOPE_WRITE_SHIPPING = 'write_shipping';
    const SCOPE_READ_ANALYTICS = 'read_analytics';
    const SCOPE_READ_USERS = 'read_users';
    const SCOPE_WRITE_USERS = 'write_users';
    const SCOPE_READ_CHECKOUTS = 'read_checkouts';
    const SCOPE_WRITE_CHECKOUTS = 'write_checkouts';
    const SCOPE_READ_REPORTS = 'read_reports';
    const SCOPE_WRITE_REPORTS = 'write_reports';
    const SCOPE_READ_PRICE_RULES = 'read_price_rules';
    const SCOPE_WRITE_PRICE_RULES = 'write_price_rules';

    /**
     * Access modes are defined in the `{option}` definition in https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission
     *
     * For more information see https://help.shopify.com/api/getting-started/authentication/oauth#api-access-modes
     */
    const GRANT_OPTION_ONLINE_ACCESS = 'per-user';
    const GRANT_OPTION_OFFLINE_ACCESS = null;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/oauth/authorize';

    /** @var string $shop The name of the user’s shop */
    protected $shop;
    /** @var string $apiKey The app’s API Key */
    protected $apiKey;
    /** @var string[] $scopes List of scopes */
    protected $scopes;
    /** @var string $redirectUri The URL where you want to redirect the users after they authorize the client */
    protected $redirectUri;
    /** @var string $nonce A randomly selected value provided by your application, which is unique for each authorization request */
    protected $nonce;
    /** @var string $option Contains value "per-user" if the access mode is online, defaults to blank for offline */
    protected $option;

    /**
     * AuthorizePrompt constructor.
     * @param string $redirectUri Included in constructor as it is a required parameter.
     */
    public function __construct(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
        $this->scopes = [];
    }

    /**
     * @return Uri
     */
    public function toUri(): Uri
    {
        // Compute URI values
        $baseUri = sprintf(self::URI_TEMPLATE, $this->shop);
        $scope = ($this->scopes) ? implode(',', array_unique($this->scopes)) : null;

        // Create URI query
        $query = http_build_query([
            'client_id' => $this->apiKey,
            'scope' => $scope,
            'redirect_uri' => $this->redirectUri,
            'state' => $this->nonce,
            'grant_options[]' => $this->option,
        ]);

        // Create URI
        $uri = (new Uri($baseUri))->withQuery($query);

        return $uri;
    }

    /**
     * @param string $shop
     * @return AuthorizePrompt
     */
    public function withShop(string $shop): AuthorizePrompt
    {
        $new = clone $this;
        $new->shop = $shop;

        return $new;
    }

    /**
     * @param string $apiKey
     * @return AuthorizePrompt
     */
    public function withApiKey(string $apiKey): AuthorizePrompt
    {
        $new = clone $this;
        $new->apiKey = $apiKey;

        return $new;
    }


    /**
     * @param string $nonce
     * @return AuthorizePrompt
     */
    public function withNonce(string $nonce): AuthorizePrompt
    {
        $new = clone $this;
        $new->nonce = $nonce;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadContentScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_CONTENT;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteContentScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_CONTENT;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadThemesScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_THEMES;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteThemesScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_THEMES;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadProductsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_PRODUCTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteProductsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_PRODUCTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadCustomersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_CUSTOMERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteCustomersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_CUSTOMERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadOrdersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_ORDERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteOrdersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_ORDERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadDraftOrdersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_DRAFT_ORDERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteDraftOrdersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_DRAFT_ORDERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadScriptTagsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_SCRIPT_TAGS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteScriptTagsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_SCRIPT_TAGS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadFulfillmentsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_FULFILLMENTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteFulfillmentsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_FULFILLMENTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadShippingScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_SHIPPING;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteShippingScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_SHIPPING;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadAnalyticsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_ANALYTICS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadUsersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_USERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteUsersScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_USERS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadCheckoutsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_CHECKOUTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteCheckoutsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_CHECKOUTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadReportsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_REPORTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWriteReportsScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_REPORTS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withReadPriceRulesScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_READ_PRICE_RULES;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withWritePriceRulesScope(): AuthorizePrompt
    {
        $new = clone $this;
        $new->scopes[] = self::SCOPE_WRITE_PRICE_RULES;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withOnlineAccess(): AuthorizePrompt
    {
        $new = clone $this;
        $new->option = self::GRANT_OPTION_ONLINE_ACCESS;

        return $new;
    }

    /**
     * @return AuthorizePrompt
     */
    public function withOfflineAccess(): AuthorizePrompt
    {
        $new = clone $this;
        $new->option = self::GRANT_OPTION_OFFLINE_ACCESS;

        return $new;
    }
}
