<?php

namespace Yaspa\AdminApi\Customer\Builders;

use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\AdminApi\Customer\Transformers\Customer as CustomerTransformer;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;
use Yaspa\Traits\ResourceRequestBuilderTrait;

/**
 * Class ModifyExistingCustomerRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#update
 */
class ModifyExistingCustomerRequest implements RequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait,
        ResourceRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/%s.json';

    /**
     * Dependencies
     */
    /** @var CustomerTransformer */
    protected $customerTransformer;
    /** @var MetafieldTransformer */
    protected $metafieldTransformer;
    /** @var ArrayFilters $arrayFilters */
    protected $arrayFilters;

    /**
     * Builder properties
     */
    /** @var CustomerModel $customerModel */
    protected $customerModel;
    /** @var array|MetafieldModel[] $metafields */
    protected $metafields;

    /**
     * ModifyExistingCustomerRequest constructor.
     *
     * @param CustomerTransformer $customerTransformer
     * @param MetafieldTransformer $metafieldTransformer
     * @param ArrayFilters $arrayFilters
     */
    public function __construct(
        CustomerTransformer $customerTransformer,
        MetafieldTransformer $metafieldTransformer,
        ArrayFilters $arrayFilters
    ) {
        // Set dependencies
        $this->customerTransformer = $customerTransformer;
        $this->metafieldTransformer = $metafieldTransformer;
        $this->arrayFilters = $arrayFilters;

        // Set properties with defaults
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
        return $this->customerModel->getId();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->customerModel)) {
            $array = $this->customerTransformer->toArray($this->customerModel);
        }

        if (!empty($this->metafields)) {
            $array['metafields'] = array_map([$this->metafieldTransformer, 'toArray'], $this->metafields);
        }

        $array = $this->arrayFilters->arrayFilterRecursive($array, [$this->arrayFilters, 'notNull']);

        return ['customer' => $array];
    }

    /**
     * @param CustomerModel $customerModel
     * @return ModifyExistingCustomerRequest
     */
    public function withCustomer(CustomerModel $customerModel): ModifyExistingCustomerRequest
    {
        $new = clone $this;
        $new->customerModel = $customerModel;

        return $new;
    }

    /**
     * @param array|MetafieldModel[] $metafields
     * @return ModifyExistingCustomerRequest
     */
    public function withMetafields(array $metafields): ModifyExistingCustomerRequest
    {
        $new = clone $this;
        $new->metafields = $metafields;

        return $new;
    }
}
