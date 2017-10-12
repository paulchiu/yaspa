<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\AdminApi\Redirect\Models\Redirect as RedirectModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class GetRedirectRequest
 *
 * @package Yaspa\AdminApi\Redirect\Builders
 * @see https://help.shopify.com/api/reference/redirect#show
 */
class GetRedirectRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects/%s.json';

    /**
     * Builder properties
     */
    /** @var RedirectModel $redirectModel */
    protected $redirectModel;
    /** @var RedirectFields $redirectFields */
    protected $redirectFields;

    /**
     * GetRedirectRequest constructor.
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
        return $this->redirectModel->getId();
    }

    /**
     * @param RedirectModel $redirectModel
     * @return GetRedirectRequest
     */
    public function withRedirect(RedirectModel $redirectModel): GetRedirectRequest
    {
        $new = clone $this;
        $new->redirectModel = $redirectModel;

        return $new;
    }

    /**
     * @param RedirectFields $redirectFields
     * @return GetRedirectRequest
     */
    public function withRedirectFields(RedirectFields $redirectFields): GetRedirectRequest
    {
        $new = clone $this;
        $new->redirectFields = $redirectFields;

        return $new;
    }
}
