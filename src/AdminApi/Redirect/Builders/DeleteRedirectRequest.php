<?php

namespace Yaspa\AdminApi\Redirect\Builders;

use Yaspa\AdminApi\Redirect\Models\Redirect as RedirectModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class DeleteRedirectRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/redirect#destroy
 */
class DeleteRedirectRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/redirects/%s.json';

    /**
     * Builder properties
     */
    /** @var RedirectModel $redirectModel */
    protected $redirectModel;

    /**
     * DeleteRedirectRequest constructor.
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
        return $this->redirectModel->getId();
    }

    /**
     * @param RedirectModel $redirect
     * @return DeleteRedirectRequest
     */
    public function withRedirect(RedirectModel $redirect): DeleteRedirectRequest
    {
        $new = clone $this;
        $new->redirectModel = $redirect;

        return $new;
    }
}
