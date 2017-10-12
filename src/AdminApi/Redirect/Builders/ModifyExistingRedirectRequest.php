<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\AdminApi\Redirect\Models\Redirect as RedirectModel;
use Yaspa\AdminApi\Redirect\Models\Redirect;
use Yaspa\AdminApi\Redirect\Transformers\Redirect as RedirectTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class ModifyExistingRedirectRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/redirect#update
 */
class ModifyExistingRedirectRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects/%s.json';

    /**
     * Dependencies
     */
    /** @var RedirectTransformer $redirectTransformer */
    protected $redirectTransformer;
    /** @var ArrayFilters $arrayFilters */
    protected $arrayFilters;

    /**
     * Builder properties
     */
    /** @var  RedirectModel $redirectModel */
    protected $redirectModel;

    /**
     * ModifyExistingRedirectRequest constructor.
     *
     * @param RedirectTransformer $redirectTransformer
     * @param ArrayFilters $arrayFilters
     */
    public function __construct(
        RedirectTransformer $redirectTransformer,
        ArrayFilters $arrayFilters
    ) {
        $this->redirectTransformer = $redirectTransformer;
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
        return $this->redirectModel->getId();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        // Transform model
        if (!is_null($this->redirectModel)) {
            $array = $this->redirectTransformer->toArray($this->redirectModel);
        }

        // Retain only not null values
        $array = $this->arrayFilters->arrayFilterRecursive($array, [$this->arrayFilters, 'notNull']);

        return ['redirect' => $array];
    }

    /**
     * @param Redirect $redirect
     * @return ModifyExistingRedirectRequest
     */
    public function withRedirect(RedirectModel $redirect): ModifyExistingRedirectRequest
    {
        $new = clone $this;
        $new->redirectModel = $redirect;

        return $new;
    }
}
