<?php

namespace Yaspa\AdminApi\Customer\Builders;

use GuzzleHttp\RequestOptions;
use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\AdminApi\Customer\Transformers\Customer as CustomerTransformer;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\AdminApi\Metafield\Transformers\Metafield as MetafieldTransformer;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class CreateNewCustomerRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#create
 */
class CreateNewCustomerRequest
{
    use AuthorizedRequestBuilderTrait;

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'POST';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers.json';
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
    /** @var bool $sendEmailInvite */
    protected $sendEmailInvite;
    /** @var array|MetafieldModel[] $metafields */
    protected $metafields;
    /** @var string $password */
    protected $password;
    /** @var string $passwordConfirmation */
    protected $passwordConfirmation;

    /**
     * CreateNewCustomerRequest constructor.
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
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->customerModel)) {
            $array = $this->customerTransformer->toArray($this->customerModel);
        }

        if (!is_null($this->sendEmailInvite)) {
            $array['send_email_invite'] = $this->sendEmailInvite;
        }

        if (!empty($this->metafields)) {
            $array['metafields'] = array_map([$this->metafieldTransformer, 'toArray'], $this->metafields);
        }

        if (!is_null($this->password)) {
            $array['password'] = $this->password;
        }

        if (!is_null($this->passwordConfirmation)) {
            $array['password_confirmation'] = $this->passwordConfirmation;
        }

        $array = array_filter($array);

        return ['customer' => $array];
    }

    /**
     * @param CustomerModel $customerModel
     * @return CreateNewCustomerRequest
     */
    public function withCustomer(CustomerModel $customerModel): CreateNewCustomerRequest
    {
        $new = clone $this;
        $new->customerModel = $customerModel;

        return $new;
    }

    /**
     * @param bool $sendEmailInvite
     * @return CreateNewCustomerRequest
     */
    public function withSendEmailInvite(bool $sendEmailInvite): CreateNewCustomerRequest
    {
        $new = clone $this;
        $new->sendEmailInvite = $sendEmailInvite;

        return $new;
    }

    /**
     * @param array|MetafieldModel[] $metafields
     * @return CreateNewCustomerRequest
     */
    public function withMetafields(array $metafields): CreateNewCustomerRequest
    {
        $new = clone $this;
        $new->metafields = $metafields;

        return $new;
    }

    /**
     * @param string $password
     * @return CreateNewCustomerRequest
     */
    public function withPassword(string $password): CreateNewCustomerRequest
    {
        $new = clone $this;
        $new->password = $password;

        return $new;
    }

    /**
     * @param string $passwordConfirmation
     * @return CreateNewCustomerRequest
     */
    public function withPasswordConfirmation(string $passwordConfirmation): CreateNewCustomerRequest
    {
        $new = clone $this;
        $new->passwordConfirmation = $passwordConfirmation;

        return $new;
    }
}
