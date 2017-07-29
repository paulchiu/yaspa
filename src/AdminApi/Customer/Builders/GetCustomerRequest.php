<?php

namespace Yaspa\AdminApi\Customer\Builders;

use GuzzleHttp\RequestOptions;
use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class GetCustomerRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#show
 */
class GetCustomerRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'GET';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/%s.json';
    const BODY_TYPE = RequestOptions::JSON;

    /**
     * Builder properties
     */
    /** @var CustomerModel $customerModel */
    protected $customerModel;

    /**
     * GetCustomerRequest constructor.
     */
    public function __construct()
    {
        $this->httpMethod = self::HTTP_METHOD;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->headers = self::HEADERS;
        $this->bodyType = self::BODY_TYPE;
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
     * @return GetCustomerRequest
     */
    public function withCustomer(CustomerModel $customerModel): GetCustomerRequest
    {
        $new = clone $this;
        $new->customerModel = $customerModel;

        return $new;
    }
}
