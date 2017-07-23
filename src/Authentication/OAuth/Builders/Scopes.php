<?php

namespace Yaspa\Authentication\OAuth\Builders;

/**
 * Class Scopes
 *
 * @package Yaspa\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#scopes
 *
 * Available scopes that can be requested.
 *
 * This is an immutable builder class.
 *
 * Example - Create scopes for write customers orders.
 *
 * ```
 * $scopes = Factory::make(Scopes::class)
 *     ->withWriteCustomers()
 *     ->withWriteOrders()
 *
 * $requestedScopesArray = $scopes->getRequested();
 * ```
 */
class Scopes
{
    /**
     * Scopes are defined in https://help.shopify.com/api/getting-started/authentication/oauth#scopes
     */
    const READ_CONTENT = 'read_content';
    const WRITE_CONTENT = 'write_content';
    const READ_THEMES = 'read_themes';
    const WRITE_THEMES = 'write_themes';
    const READ_PRODUCTS = 'read_products';
    const WRITE_PRODUCTS = 'write_products';
    const READ_CUSTOMERS = 'read_customers';
    const WRITE_CUSTOMERS = 'write_customers';
    const READ_ORDERS = 'read_orders';
    const WRITE_ORDERS = 'write_orders';
    const READ_DRAFT_ORDERS = 'read_draft_orders';
    const WRITE_DRAFT_ORDERS = 'write_draft_orders';
    const READ_SCRIPT_TAGS = 'read_script_tags';
    const WRITE_SCRIPT_TAGS = 'write_script_tags';
    const READ_FULFILLMENTS = 'read_fulfillments';
    const WRITE_FULFILLMENTS = 'write_fulfillments';
    const READ_SHIPPING = 'read_shipping';
    const WRITE_SHIPPING = 'write_shipping';
    const READ_ANALYTICS = 'read_analytics';
    const READ_USERS = 'read_users';
    const WRITE_USERS = 'write_users';
    const READ_CHECKOUTS = 'read_checkouts';
    const WRITE_CHECKOUTS = 'write_checkouts';
    const READ_REPORTS = 'read_reports';
    const WRITE_REPORTS = 'write_reports';
    const READ_PRICE_RULES = 'read_price_rules';
    const WRITE_PRICE_RULES = 'write_price_rules';

    /** @var string[] $requested Scopes requested */
    protected $requested;

    /**
     * Scopes constructor.
     */
    public function __construct()
    {
        $this->requested = [];
    }

    /**
     * @return string[]
     */
    public function getRequested(): array
    {
        return array_unique($this->requested);
    }

    /**
     * This is a convenience method to set requested scopes as an array.
     *
     * @param array $requestedScopes
     * @return Scopes
     */
    public function withRequested(array $requestedScopes): Scopes
    {
        $new = clone $this;
        $new->requested = $requestedScopes;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadContent(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_CONTENT;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteContent(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_CONTENT;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadThemes(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_THEMES;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteThemes(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_THEMES;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadProducts(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_PRODUCTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteProducts(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_PRODUCTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadCustomers(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_CUSTOMERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteCustomers(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_CUSTOMERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadOrders(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_ORDERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteOrders(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_ORDERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadDraftOrders(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_DRAFT_ORDERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteDraftOrders(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_DRAFT_ORDERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadScriptTags(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_SCRIPT_TAGS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteScriptTags(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_SCRIPT_TAGS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadFulfillments(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_FULFILLMENTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteFulfillments(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_FULFILLMENTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadShipping(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_SHIPPING;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteShipping(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_SHIPPING;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadAnalytics(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_ANALYTICS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadUsers(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_USERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteUsers(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_USERS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadCheckouts(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_CHECKOUTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteCheckouts(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_CHECKOUTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadReports(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_REPORTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWriteReports(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_REPORTS;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withReadPriceRules(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::READ_PRICE_RULES;

        return $new;
    }

    /**
     * @return Scopes
     */
    public function withWritePriceRules(): Scopes
    {
        $new = clone $this;
        $new->requested[] = self::WRITE_PRICE_RULES;

        return $new;
    }
}
