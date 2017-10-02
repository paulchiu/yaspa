<?php

namespace Yaspa\AdminApi\Metafield\Builders;

use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class DeleteMetafieldRequest
 *
 * @package Yaspa\AdminApi\Metafield\Builders
 * @see https://help.shopify.com/api/reference/metafield#destroy
 */
class DeleteMetafieldRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/metafields/%s.json';

    /**
     * Builder properties
     */
    /** @var MetafieldModel $metafieldModel */
    protected $metafieldModel;

    /**
     * DeleteMetafieldRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::DELETE_HTTP_METHOD;
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
     * @param MetafieldModel $metafieldModel
     * @return DeleteMetafieldRequest
     */
    public function withMetafield(MetafieldModel $metafieldModel): DeleteMetafieldRequest
    {
        $new = clone $this;
        $new->metafieldModel = $metafieldModel;

        return $new;
    }
}
