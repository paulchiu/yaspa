<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

/**
 * Class ScriptTagFields
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#index
 *
 * Possible fields to be included with return data resulting from a get scripttags call.
 */
class ScriptTagFields
{
    const ID = 'id';
    const SRC = 'src';
    const EVENT = 'event';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DISPLAY_SCOPE = 'display_scope';

    /** @var string $fields */
    protected $fields;

    /**
     * ScriptTagFields constructor.
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
     * @return ScriptTagFields
     */
    public function withId(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::ID;

        return $new;
    }

    /**
     * @return ScriptTagFields
     */
    public function withSrc(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::SRC;

        return $new;
    }

    /**
     * @return ScriptTagFields
     */
    public function withEvent(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::EVENT;

        return $new;
    }

    /**
     * @return ScriptTagFields
     */
    public function withCreatedAt(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::CREATED_AT;

        return $new;
    }

    /**
     * @return ScriptTagFields
     */
    public function withUpdatedAt(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::UPDATED_AT;

        return $new;
    }

    /**
     * @return ScriptTagFields
     */
    public function withDisplayScope(): ScriptTagFields
    {
        $new = clone $this;
        $new->fields[] = self::DISPLAY_SCOPE;

        return $new;
    }
}
