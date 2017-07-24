<?php

namespace Yaspa\AdminApi\Customer\Builders;

/**
 * Class CustomerFields
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#show
 *
 * Field builder for use with requests such as get customers.
 */
class CustomerFields
{
    const ID = 'id';
    const EMAIL = 'email';
    const ACCEPTS_MARKETING = 'accepts_marketing';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const ORDERS_COUNT = 'orders_count';
    const STATE = 'state';
    const TOTAL_SPENT = 'total_spent';
    const LAST_ORDER_ID = 'last_order_id';
    const NOTE = 'note';
    const VERIFIED_EMAIL = 'verified_email';
    const MULTIPASS_IDENTIFIER = 'multipass_identifier';
    const TAX_EXEMPT = 'tax_exempt';
    const PHONE = 'phone';
    const TAGS = 'tags';
    const LAST_ORDER_NAME = 'last_order_name';
    const ADDRESSES = 'addresses';
    const DEFAULT_ADDRESS = 'default_address';

    /** @var string $fields */
    protected $fields;

    /**
     * CustomerFields constructor.
     */
    public function __construct()
    {
        $this->fields = [];
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return array_unique($this->fields);
    }

    /**
     * @return CustomerFields
     */
    public function withId(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::ID;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withEmail(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::EMAIL;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withAcceptsMarketing(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::ACCEPTS_MARKETING;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withCreatedAt(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::CREATED_AT;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withUpdatedAt(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::UPDATED_AT;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withFirstName(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::FIRST_NAME;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withLastName(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::LAST_NAME;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withOrdersCount(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::ORDERS_COUNT;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withState(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::STATE;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withTotalSpent(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::TOTAL_SPENT;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withLastOrderId(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::LAST_ORDER_ID;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withNote(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::NOTE;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withVerifiedEmail(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::VERIFIED_EMAIL;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withMultipassIdentifier(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::MULTIPASS_IDENTIFIER;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withTaxExempt(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::TAX_EXEMPT;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withPhone(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::PHONE;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withTags(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::TAGS;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withLastOrderName(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::LAST_ORDER_NAME;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withAddresses(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::ADDRESSES;

        return $new;
    }

    /**
     * @return CustomerFields
     */
    public function withDefaultAddress(): CustomerFields
    {
        $new = clone $this;
        $new->fields[] = self::DEFAULT_ADDRESS;

        return $new;
    }
}
