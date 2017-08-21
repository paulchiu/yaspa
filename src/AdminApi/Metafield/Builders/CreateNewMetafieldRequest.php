<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewMetafieldRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/metafield#create
 */
class CreateNewMetafieldRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/metafields.json';

    /**
     * Dependencies
     */
    /** @var MetafieldTransformer $metafieldTransformer */
    protected $metafieldTransformer;

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;

    /**
     * CreateNewMetafieldRequest constructor.
     *
     * @param MetafieldTransformer $metafieldTransformer
     */
    public function __construct(MetafieldTransformer $metafieldTransformer)
    {
        $this->metafieldTransformer = $metafieldTransformer;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::POST_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return ['metafield' => $this->metafieldTransformer->toArray($this->metafieldModel)];
    }

    /**
     * @param MetafieldModel $metafieldModel
     * @return CreateNewMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): CreateNewMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }
}
