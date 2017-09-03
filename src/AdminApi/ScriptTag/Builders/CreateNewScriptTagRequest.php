<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use Yaspa\AdminApi\ScriptTag\Models\ScriptTag as ScriptTagModel;
use Yaspa\AdminApi\ScriptTag\Transformers\ScriptTag as ScriptTagTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewScriptTagRequest
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#create
 */
class CreateNewScriptTagRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags.json';

    /**
     * Dependencies
     */
    /** @var ScriptTagTransformer $scriptTagTransformer */
    protected $scriptTagTransformer;

    /**
     * Builder properties
     */
    /** @var ScriptTagModel $scriptTagModel */
    protected $scriptTagModel;

    /**
     * CreateNewScriptTagRequest constructor.
     *
     * @param ScriptTagTransformer $scriptTagTransformer
     */
    public function __construct(ScriptTagTransformer $scriptTagTransformer)
    {
        $this->scriptTagTransformer = $scriptTagTransformer;
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
        return ['script_tag' => $this->scriptTagTransformer->toArray($this->scriptTagModel)];
    }

    /**
     * @param ScriptTagModel $scriptTagModel
     * @return CreateNewScriptTagRequest
     */
    public function withScriptTag(ScriptTagModel $scriptTagModel): CreateNewScriptTagRequest
    {
        $new = clone $this;
        $new->scriptTagModel = $scriptTagModel;

        return $new;
    }
}
