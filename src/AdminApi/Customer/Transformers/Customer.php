<?php

namespace Yaspa\AdminApi\Customer\Transformers;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Customer\Models\Customer as CustomerModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use stdClass;

/**
 * Class Customer
 *
 * @package Yaspa\AdminApi\Customer\Transformers
 * @see https://help.shopify.com/api/reference/customer#show
 *
 * Customer transformer.
 */
class Customer implements ArrayResponseTransformerInterface
{
    /** @var Address $addressTransformer */
    protected $addressTransformer;

    /**
     * Customer constructor.
     *
     * @param Address $addressTransformer
     */
    public function __construct(Address $addressTransformer)
    {
        $this->addressTransformer = $addressTransformer;
    }

    /**
     * Convert a Shopify customer response into a customer model.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param ResponseInterface $response
     * @return CustomerModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): CustomerModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'customer')) {
            throw new MissingExpectedAttributeException('customer');
        }

        return $this->fromShopifyJsonCustomer($stdClass->customer);
    }

    /**
     * Convert a Shopify customers response into an array of customer models.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param ResponseInterface $response
     * @return array|CustomerModel[]
     * @throws MissingExpectedAttributeException
     */
    public function fromArrayResponse(ResponseInterface $response): array
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'customers')) {
            throw new MissingExpectedAttributeException('customers');
        }

        return array_map([$this, 'fromShopifyJsonCustomer'], $stdClass->customers);
    }

    /**
     * Convert a Shopify customer JSON class into a customer model.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param stdClass $shopifyJsonCustomer
     * @return CustomerModel
     */
    public function fromShopifyJsonCustomer(stdClass $shopifyJsonCustomer): CustomerModel
    {
        $customer = new CustomerModel();

        if (property_exists($shopifyJsonCustomer, 'id')) {
            $customer->setId($shopifyJsonCustomer->id);
        }

        if (property_exists($shopifyJsonCustomer, 'email')) {
            $customer->setEmail($shopifyJsonCustomer->email);
        }

        if (property_exists($shopifyJsonCustomer, 'accepts_marketing')) {
            $customer->setAcceptsMarketing($shopifyJsonCustomer->accepts_marketing);
        }

        if (property_exists($shopifyJsonCustomer, 'created_at')) {
            $createdAt = new DateTime($shopifyJsonCustomer->created_at);
            $customer->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonCustomer, 'updated_at')) {
            $updatedAt = new DateTime($shopifyJsonCustomer->updated_at);
            $customer->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonCustomer, 'first_name')) {
            $customer->setFirstName($shopifyJsonCustomer->first_name);
        }

        if (property_exists($shopifyJsonCustomer, 'last_name')) {
            $customer->setLastName($shopifyJsonCustomer->last_name);
        }

        if (property_exists($shopifyJsonCustomer, 'orders_count')) {
            $customer->setOrdersCount($shopifyJsonCustomer->orders_count);
        }

        if (property_exists($shopifyJsonCustomer, 'state')) {
            $customer->setState($shopifyJsonCustomer->state);
        }

        if (property_exists($shopifyJsonCustomer, 'total_spent')) {
            $customer->setTotalSpent($shopifyJsonCustomer->total_spent);
        }

        if (property_exists($shopifyJsonCustomer, 'last_order_id')) {
            $customer->setLastOrderId($shopifyJsonCustomer->last_order_id);
        }

        if (property_exists($shopifyJsonCustomer, 'note')) {
            $customer->setNote($shopifyJsonCustomer->note);
        }

        if (property_exists($shopifyJsonCustomer, 'verified_email')) {
            $customer->setVerifiedEmail($shopifyJsonCustomer->verified_email);
        }

        if (property_exists($shopifyJsonCustomer, 'multipass_identifier')) {
            $customer->setMultipassIdentifier($shopifyJsonCustomer->multipass_identifier);
        }

        if (property_exists($shopifyJsonCustomer, 'tax_exempt')) {
            $customer->setTaxExempt($shopifyJsonCustomer->tax_exempt);
        }

        if (property_exists($shopifyJsonCustomer, 'phone')) {
            $customer->setPhone($shopifyJsonCustomer->phone);
        }

        if (property_exists($shopifyJsonCustomer, 'tags')) {
            $customer->setTags(explode(',', $shopifyJsonCustomer->tags));
        }

        if (property_exists($shopifyJsonCustomer, 'last_order_name')) {
            $customer->setLastOrderName($shopifyJsonCustomer->last_order_name);
        }

        if (property_exists($shopifyJsonCustomer, 'addresses')) {
            $addresses = array_map([$this->addressTransformer, 'fromShopifyJsonAddress'], $shopifyJsonCustomer->addresses);
            $customer->setAddresses($addresses);
        }

        if (property_exists($shopifyJsonCustomer, 'default_address')) {
            $defaultAddress = $this->addressTransformer
                ->fromShopifyJsonAddress($shopifyJsonCustomer->default_address);
            $customer->setDefaultAddress($defaultAddress);
        }

        return $customer;
    }

    /**
     * @param CustomerModel $customer
     * @return array
     */
    public function toArray(CustomerModel $customer): array
    {
        $array = [];

        $array['id'] = $customer->getId();
        $array['email'] = $customer->getEmail();
        $array['accepts_marketing'] = $customer->isAcceptsMarketing();
        $array['created_at'] = $customer->getCreatedAt();
        $array['updated_at'] = $customer->getUpdatedAt();
        $array['first_name'] = $customer->getFirstName();
        $array['last_name'] = $customer->getLastName();
        $array['orders_count'] = $customer->getOrdersCount();
        $array['state'] = $customer->getState();
        $array['total_spent'] = $customer->getTotalSpent();
        $array['last_order_id'] = $customer->getLastOrderId();
        $array['note'] = $customer->getNote();
        $array['verified_email'] = $customer->isVerifiedEmail();
        $array['multipass_identifier'] = $customer->getMultipassIdentifier();
        $array['tax_exempt'] = $customer->isTaxExempt();
        $array['phone'] = $customer->getPhone();
        $array['tags'] = empty($customer->getTags()) ? null : implode(',', $customer->getTags());
        $array['last_order_name'] = $customer->getLastOrderName();
        $array['addresses'] = array_map([$this->addressTransformer, 'toArray'], $customer->getAddresses());

        // Only provide default address is one
        if ($customer->getDefaultAddress()) {
            $array['default_address'] = $this->addressTransformer->toArray($customer->getDefaultAddress());
        }

        return $array;
    }
}
