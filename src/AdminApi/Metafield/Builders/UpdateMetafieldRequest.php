<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class UpdateMetafieldRequest
 *
 * @package Yaspa\AdminApi\Metafield\Builders
 * @see https://help.shopify.com/api/reference/metafield#update
 */
class UpdateMetafieldRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/metafields/%s.json';

    /**
     * Dependencies
     */
    /** @var MetafieldTransformer */
    protected $metafieldTransformer;

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;
    /** @var array|MetafieldModel[] $metafields */
    protected $metafields;

    /**
     * UpdateMetafieldRequest constructor.
     *
     * @param MetafieldTransformer $metafieldTransformer
     */
    public function __construct(MetafieldTransformer $metafieldTransformer)
    {
        // Set dependencies
        $this->metafieldTransformer = $metafieldTransformer;

        // Set properties with defaults
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::PUT_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }

    /**
     * @return int|null
     */
    public function toResourceId()
    {
        return $this->metafieldModel->getId();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->metafieldModel)) {
            $array = $this->metafieldTransformer->toArray($this->metafieldModel);
        }

        return ['metafield' => $array];
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return UpdateMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): UpdateMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }
}
