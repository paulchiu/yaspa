<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use Yaspa\AdminApi\ScriptTag\Models\ScriptTag as ScriptTagModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class DeleteScriptTagRequest
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#destroy
 */
class DeleteScriptTagRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags/%s.json';

    /**
     * Builder properties
     */
    /** @var ScriptTagModel $scriptTagModel */
    protected $scriptTagModel;

    /**
     * DeleteScriptTagRequest constructor.
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
        return $this->scriptTagModel->getId();
    }

    /**
     * @param ScriptTagModel $scriptTag
     * @return DeleteScriptTagRequest
     */
    public function withScriptTag(ScriptTagModel $scriptTag): DeleteScriptTagRequest
    {
        $new = clone $this;
        $new->scriptTagModel = $scriptTag;

        return $new;
    }
}
