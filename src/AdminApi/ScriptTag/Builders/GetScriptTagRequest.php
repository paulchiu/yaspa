<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use Yaspa\AdminApi\ScriptTag\Models\ScriptTag as ScriptTagModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class GetScriptTagRequest
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#show
 */
class GetScriptTagRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags/%s.json';

    /**
     * Builder properties
     */
    /** @var ScriptTagModel $scriptTagModel */
    protected $scriptTagModel;
    /** @var ScriptTagsFields $scriptTagFields */
    protected $scriptTagFields;

    /**
     * GetScriptTagRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
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
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->scriptTagFields)) {
            $array['fields'] = implode(',', $this->scriptTagFields->getFields());
        }

        return $array;
    }

    /**
     * @param ScriptTagModel $scriptTagModel
     * @return GetScriptTagRequest
     */
    public function withScriptTag(ScriptTagModel $scriptTagModel): GetScriptTagRequest
    {
        $new = clone $this;
        $new->scriptTagModel = $scriptTagModel;

        return $new;
    }

    /**
     * @param ScriptTagFields $scriptTagFields
     * @return GetScriptTagRequest
     */
    public function withScriptTagFields(ScriptTagFields $scriptTagFields): GetScriptTagRequest
    {
        $new = clone $this;
        $new->scriptTagFields = $scriptTagFields;

        return $new;
    }
}
