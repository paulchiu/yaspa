<?php

namespace Yaspa\AdminApi\ScriptTag\Builders;

use Yaspa\AdminApi\ScriptTag\Models\ScriptTag as ScriptTagModel;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag;
use Yaspa\AdminApi\ScriptTag\Transformers\ScriptTag as ScriptTagTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class ModifyExistingScriptTagRequest
 *
 * @package Yaspa\AdminApi\ScriptTag\Builders
 * @see https://help.shopify.com/api/reference/scripttag#update
 */
class ModifyExistingScriptTagRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/script_tags/%s.json';

    /**
     * Dependencies
     */
    /** @var ScriptTagTransformer $scriptTagTransformer */
    protected $scriptTagTransformer;
    /** @var ArrayFilters $arrayFilters */
    protected $arrayFilters;

    /**
     * Builder properties
     */
    /** @var  ScriptTagModel $scriptTagModel */
    protected $scriptTagModel;

    /**
     * ModifyExistingScriptTagRequest constructor.
     *
     * @param ScriptTagTransformer $scriptTagTransformer
     * @param ArrayFilters $arrayFilters
     */
    public function __construct(
        ScriptTagTransformer $scriptTagTransformer,
        ArrayFilters $arrayFilters
    ) {
        $this->scriptTagTransformer = $scriptTagTransformer;
        $this->arrayFilters = $arrayFilters;
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
        return $this->scriptTagModel->getId();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        // Transform model
        if (!is_null($this->scriptTagModel)) {
            $array = $this->scriptTagTransformer->toArray($this->scriptTagModel);
        }

        // Retain only not null values
        $array = $this->arrayFilters->arrayFilterRecursive($array, [$this->arrayFilters, 'notNull']);

        return ['script_tag' => $array];
    }

    /**
     * @param ScriptTag $scriptTag
     * @return ModifyExistingScriptTagRequest
     */
    public function withScriptTag(ScriptTagModel $scriptTag): ModifyExistingScriptTagRequest
    {
        $new = clone $this;
        $new->scriptTagModel = $scriptTag;

        return $new;
    }
}
