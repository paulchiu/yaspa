<?php

namespace Yaspa\AdminApi\Metafield\Builders;

/**
 * Class MetafieldFields
 *
 * @package Yaspa\AdminApi\Metafield\Builders
 * @see https://help.shopify.com/api/reference/metafield#index
 *
 * Possible fields to be included in a get metafields call.
 */
class MetafieldFields
{
    const ID = 'id';
    const NAMESPACE = 'namespace';
    const KEY = 'key';
    const VALUE = 'value';
    const VALUE_TYPE = 'value_type';
    const DESCRIPTION = 'description';
    const OWNER_ID = 'owner_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const OWNER_RESOURCE = 'owner_resource';

    /** @var string $fields */
    protected $fields;

    /**
     * MetafieldFields constructor.
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
     * @return MetafieldFields
     */
    public function withId(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::ID;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withNamespace(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::NAMESPACE;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withKey(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::KEY;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withValue(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::VALUE;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withValueType(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::VALUE_TYPE;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withDescription(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::DESCRIPTION;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withOwnerId(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::OWNER_ID;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withCreatedAt(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::CREATED_AT;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withUpdatedAt(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::UPDATED_AT;

        return $new;
    }

    /**
     * @return MetafieldFields
     */
    public function withOwnerResource(): MetafieldFields
    {
        $new = clone $this;
        $new->fields[] = self::OWNER_RESOURCE;

        return $new;
    }
}
