<?php

namespace Yaspa\AdminApi\Customer\Builders;

use GuzzleHttp\RequestOptions;
use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\AdminApi\Customer\Transformers\Customer as CustomerTransformer;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
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

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'PUT';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/%s.json';
    const BODY_TYPE = RequestOptions::JSON;

    /**
     * Dependencies
     */
    /** @var CustomerTransformer */
    protected $customerTransformer;
    /** @var MetafieldTransformer */
    protected $metafieldTransformer;

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
     */
    public function __construct(
        CustomerTransformer $customerTransformer,
        MetafieldTransformer $metafieldTransformer
    ) {
        // Set dependencies
        $this->customerTransformer = $customerTransformer;
        $this->metafieldTransformer = $metafieldTransformer;

        // Set properties with defaults
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

        $array = array_filter($array);

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
