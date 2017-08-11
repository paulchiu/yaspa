<?php

namespace Yaspa\AdminApi\Product\Builders;

/**
 * Class ProductFields
 *
 * @package Yaspa\AdminApi\Product\Builders
 * @see https://help.shopify.com/api/reference/product#index
 *
 * Possible fields to be included with return data resulting from a get products call.
 */
class ProductFields
{
    const ID = 'id';
    const TITLE = 'title';
    const BODY_HTML = 'body_html';
    const VENDOR = 'vendor';
    const PRODUCT_TYPE = 'product_type';
    const CREATED_AT = 'created_at';
    const HANDLE = 'handle';
    const UPDATED_AT = 'updated_at';
    const PUBLISHED_AT = 'published_at';
    const METAFIELDS_GLOBAL_TITLE_TAG = 'metafields_global_title_tag';
    const METAFIELDS_GLOBAL_DESCRIPTION_TAG = 'metafields_global_description_tag';
    const TEMPLATE_SUFFIX = 'template_suffix';
    const PUBLISHED_SCOPE = 'published_scope';
    const TAGS = 'tags';
    const VARIANTS = 'variants';
    const OPTIONS = 'options';
    const IMAGES = 'images';
    const IMAGE = 'image';

    /** @var string $fields */
    protected $fields;

    /**
     * ProductFields constructor.
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
     * @return ProductFields
     */
    public function withId(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::ID;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withTitle(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::TITLE;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withBodyHtml(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::BODY_HTML;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withVendor(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::VENDOR;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withProductType(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::PRODUCT_TYPE;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withCreatedAt(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::CREATED_AT;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withHandle(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::HANDLE;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withUpdatedAt(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::UPDATED_AT;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withPublishedAt(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::PUBLISHED_AT;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withMetafieldsGlobalTitleTag(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::METAFIELDS_GLOBAL_TITLE_TAG;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withMetafieldsGlobalDescriptionTag(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::METAFIELDS_GLOBAL_DESCRIPTION_TAG;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withTemplateSuffix(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::TEMPLATE_SUFFIX;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withPublishedScope(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::PUBLISHED_SCOPE;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withTags(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::TAGS;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withVariants(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::VARIANTS;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withOptions(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::OPTIONS;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withImages(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::IMAGES;

        return $new;
    }

    /**
     * @return ProductFields
     */
    public function withImage(): ProductFields
    {
        $new = clone $this;
        $new->fields[] = self::IMAGE;

        return $new;
    }

}
