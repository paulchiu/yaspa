<?php

namespace Yaspa\AdminApi\Customer\Builders;

use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class CreateAccountActivationUrlRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#account_activation_url
 */
class CreateAccountActivationUrlRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/%s/account_activation_url.json';

    /**
     * Builder properties
     */
    /** @var CustomerModel $customerModel */
    protected $customerModel;

    /**
     * CreateAccountActivationUrlRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::POST_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }

    /**
     * @return int|null
     */
    public function toResourceId()
    {
        return $this->customerModel->getId();
    }

    /**
     * @param CustomerModel $customerModel
     * @return CreateAccountActivationUrlRequest
     */
    public function withCustomer(CustomerModel $customerModel): CreateAccountActivationUrlRequest
    {
        $new = clone $this;
        $new->customerModel = $customerModel;

        return $new;
    }
}
