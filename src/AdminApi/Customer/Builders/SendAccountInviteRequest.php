<?php

namespace Yaspa\AdminApi\Customer\Builders;

use Yaspa\AdminApi\Customer\Models\Customer;
use Yaspa\AdminApi\Customer\Models\CustomerInvite;
use Yaspa\AdminApi\Customer\Transformers;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class SendAccountInviteRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 */
class SendAccountInviteRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/%s/send_invite.json';

    /**
     * Dependencies
     */
    /** @var Transformers\CustomerInvite $customerInviteTransformer */
    protected $customerInviteTransformer;
    /** @var ArrayFilters $arrayFilters */
    protected $arrayFilters;

    /**
     * Builder properties
     */
    /** @var Customer $customer */
    protected $customer;
    /** @var CustomerInvite $customerInvite */
    protected $customerInvite;

    /**
     * SendAccountInviteRequest constructor.
     *
     * @param Transformers\CustomerInvite $customerInviteTransformer
     * @param ArrayFilters $arrayFilters
     */
    public function __construct(
        Transformers\CustomerInvite $customerInviteTransformer,
        ArrayFilters $arrayFilters
    ) {
        $this->customerInviteTransformer = $customerInviteTransformer;
        $this->arrayFilters = $arrayFilters;
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
        return $this->customer->getId();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = (object) [];

        if (!is_null($this->customerInvite)) {
            $array = $this->customerInviteTransformer->toArray($this->customerInvite);
            $array = $this->arrayFilters->arrayFilterRecursive($array, [$this->arrayFilters, 'notNull']);
        }

        return ['customer_invite' => $array];
    }

    /**
     * @param Customer $customer
     * @return SendAccountInviteRequest
     */
    public function withCustomer(Customer $customer): SendAccountInviteRequest
    {
        $new = clone $this;
        $new->customer = $customer;

        return $new;
    }

    /**
     * @param CustomerInvite $customerInvite
     * @return SendAccountInviteRequest
     */
    public function withCustomerInvite(?CustomerInvite $customerInvite): SendAccountInviteRequest
    {
        $new = clone $this;
        $new->customerInvite = $customerInvite;

        return $new;
    }
}
