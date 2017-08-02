<?php

namespace Yaspa\AdminApi\Customer\Builders;

use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CountAllCustomersRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#count
 */
class CountAllCustomersRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/count.json';

    /**
     * Builder properties
     */
    /** @var CustomerModel $customerModel */
    protected $customerModel;

    /**
     * CountAllCustomersRequest constructor.
     */
    public function __construct()
    {
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::JSON_BODY_TYPE;
    }
}
