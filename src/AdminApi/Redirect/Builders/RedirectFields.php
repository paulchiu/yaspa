<?php

namespace Yaspa\AdminApi\Redirect\Builders;

/**
 * Class RedirectFields
 *
 * @package Yaspa\AdminApi\Redirect\Builders
 * @see https://help.shopify.com/api/reference/redirect#show
 *
 * Field builder for use with requests such as get redirects.
 */
class RedirectFields
{
    const ID = 'id';
    const PATH = 'path';
    const TARGET = 'target';

    /** @var string $fields */
    protected $fields;

    /**
     * RedirectFields constructor.
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
     * @return RedirectFields
     */
    public function withId(): RedirectFields
    {
        $new = clone $this;
        $new->fields[] = self::ID;

        return $new;
    }
    /**
     * @return RedirectFields
     */
    public function withPath(): RedirectFields
    {
        $new = clone $this;
        $new->fields[] = self::PATH;

        return $new;
    }
    /**
     * @return RedirectFields
     */
    public function withTarget(): RedirectFields
    {
        $new = clone $this;
        $new->fields[] = self::TARGET;

        return $new;
    }
}
