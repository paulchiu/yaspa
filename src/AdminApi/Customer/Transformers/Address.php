<?php

namespace Yaspa\AdminApi\Customer\Transformers;

use Yaspa\AdminApi\Customer\Models\Address as AddressModel;
use stdClass;

/**
 * Class Address
 *
 * @package Yaspa\AdminApi\Customer\Transformers
 * @see https://help.shopify.com/api/reference/customer#show
 *
 * Customer address transformer. This resource is only documented as a sub-resource
 * of customer and not available independently.
 */
class Address
{
    /**
     * Given a Shopify JSON object, transform to an address model.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param stdClass $shopifyJsonAddress
     * @return AddressModel
     */
    public function fromShopifyJsonAddress(stdClass $shopifyJsonAddress): AddressModel
    {
        $address = new AddressModel();

        if (property_exists($shopifyJsonAddress, 'id')) {
            $address->setId($shopifyJsonAddress->id);
        }

        if (property_exists($shopifyJsonAddress, 'first_name')) {
            $address->setFirstName($shopifyJsonAddress->first_name);
        }

        if (property_exists($shopifyJsonAddress, 'last_name')) {
            $address->setLastName($shopifyJsonAddress->last_name);
        }

        if (property_exists($shopifyJsonAddress, 'company')) {
            $address->setCompany($shopifyJsonAddress->company);
        }

        if (property_exists($shopifyJsonAddress, 'address1')) {
            $address->setAddress1($shopifyJsonAddress->address1);
        }

        if (property_exists($shopifyJsonAddress, 'address2')) {
            $address->setAddress2($shopifyJsonAddress->address2);
        }

        if (property_exists($shopifyJsonAddress, 'city')) {
            $address->setCity($shopifyJsonAddress->city);
        }

        if (property_exists($shopifyJsonAddress, 'province')) {
            $address->setProvince($shopifyJsonAddress->province);
        }

        if (property_exists($shopifyJsonAddress, 'country')) {
            $address->setCountry($shopifyJsonAddress->country);
        }

        if (property_exists($shopifyJsonAddress, 'zip')) {
            $address->setZip($shopifyJsonAddress->zip);
        }

        if (property_exists($shopifyJsonAddress, 'phone')) {
            $address->setPhone($shopifyJsonAddress->phone);
        }

        if (property_exists($shopifyJsonAddress, 'name')) {
            $address->setName($shopifyJsonAddress->name);
        }

        if (property_exists($shopifyJsonAddress, 'province_code')) {
            $address->setProvinceCode($shopifyJsonAddress->province_code);
        }

        if (property_exists($shopifyJsonAddress, 'country_code')) {
            $address->setCountryCode($shopifyJsonAddress->country_code);
        }

        if (property_exists($shopifyJsonAddress, 'country_name')) {
            $address->setCountryName($shopifyJsonAddress->country_name);
        }

        if (property_exists($shopifyJsonAddress, 'default')) {
            $address->setDefault($shopifyJsonAddress->default);
        }

        return $address;
    }

    /**
     * Transform an address model to array version of Shopify JSON representation.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param AddressModel $address
     * @return array
     */
    public function toArray(AddressModel $address): array
    {
        $array = [];

        $array['id'] = $address->getId();
        $array['first_name'] = $address->getFirstName();
        $array['last_name'] = $address->getLastName();
        $array['company'] = $address->getCompany();
        $array['address1'] = $address->getAddress1();
        $array['address2'] = $address->getAddress2();
        $array['city'] = $address->getCity();
        $array['province'] = $address->getProvince();
        $array['country'] = $address->getCountry();
        $array['zip'] = $address->getZip();
        $array['phone'] = $address->getPhone();
        $array['name'] = $address->getName();
        $array['province_code'] = $address->getProvinceCode();
        $array['country_code'] = $address->getCountryCode();
        $array['country_name'] = $address->getCountryName();
        $array['default'] = $address->isDefault();

        return $array;
    }
}
