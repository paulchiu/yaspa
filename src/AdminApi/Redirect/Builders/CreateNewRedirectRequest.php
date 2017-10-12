<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\AdminApi\Redirect\Models\Redirect as RedirectModel;
use Yaspa\AdminApi\Redirect\Transformers\Redirect as RedirectTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewRedirectRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/redirect#create
 */
class CreateNewRedirectRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects.json';

    /**
     * Dependencies
     */
    /** @var RedirectTransformer $redirectTransformer */
    protected $redirectTransformer;

    /**
     * Builder properties
     */
    /** @var RedirectModel $redirectModel */
    protected $redirectModel;

    /**
     * CreateNewRedirectRequest constructor.
     *
     * @param RedirectTransformer $redirectTransformer
     */
    public function __construct(RedirectTransformer $redirectTransformer)
    {
        $this->redirectTransformer = $redirectTransformer;
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
        return ['redirect' => $this->redirectTransformer->toArray($this->redirectModel)];
    }

    /**
     * @param RedirectModel $redirectModel
     * @return CreateNewRedirectRequest
     */
    public function withRedirect(RedirectModel $redirectModel): CreateNewRedirectRequest
    {
        $new = clone $this;
        $new->redirectModel = $redirectModel;

        return $new;
    }
}

