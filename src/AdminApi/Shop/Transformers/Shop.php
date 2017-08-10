<?php

namespace Yaspa\AdminApi\Shop\Transformers;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Shop\Models\Shop as ShopModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use stdClass;

/**
 * Class Shop
 *
 * @package Yaspa\AdminApi\Shop\Transformers
 * @see https://help.shopify.com/api/reference/shop
 *
 * Shop model transformer.
 */
class Shop
{
    /**
     * Transform from a Shopify JSON response to a shop PHP class.
     *
     * @see https://help.shopify.com/api/reference/shop#show
     * @param ResponseInterface $response
     * @return ShopModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): ShopModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'shop')) {
            throw new MissingExpectedAttributeException('shop');
        }

        return $this->fromShopifyJsonShop($stdClass->shop);
    }

    /**
     * Transform from a Shopify JSON shop details to a shop PHP class.
     *
     * @see https://help.shopify.com/api/reference/shop#show
     * @param stdClass $shopifyJsonShop
     * @return ShopModel
     */
    public function fromShopifyJsonShop(stdClass $shopifyJsonShop): ShopModel
    {
        $shop = new ShopModel();

        if (property_exists($shopifyJsonShop, 'id')) {
            $shop->setId($shopifyJsonShop->id);
        }

        if (property_exists($shopifyJsonShop, 'name')) {
            $shop->setName($shopifyJsonShop->name);
        }

        if (property_exists($shopifyJsonShop, 'email')) {
            $shop->setEmail($shopifyJsonShop->email);
        }

        if (property_exists($shopifyJsonShop, 'domain')) {
            $shop->setDomain($shopifyJsonShop->domain);
        }

        if (property_exists($shopifyJsonShop, 'created_at')
            && !empty($shopifyJsonShop->created_at)
        ) {
            $createdAt = new DateTime($shopifyJsonShop->created_at);
            $shop->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonShop, 'province')) {
            $shop->setProvince($shopifyJsonShop->province);
        }

        if (property_exists($shopifyJsonShop, 'country')) {
            $shop->setCountry($shopifyJsonShop->country);
        }

        if (property_exists($shopifyJsonShop, 'address1')) {
            $shop->setAddress1($shopifyJsonShop->address1);
        }

        if (property_exists($shopifyJsonShop, 'zip')) {
            $shop->setZip($shopifyJsonShop->zip);
        }

        if (property_exists($shopifyJsonShop, 'city')) {
            $shop->setCity($shopifyJsonShop->city);
        }

        if (property_exists($shopifyJsonShop, 'source')) {
            $shop->setSource($shopifyJsonShop->source);
        }

        if (property_exists($shopifyJsonShop, 'phone')) {
            $shop->setPhone($shopifyJsonShop->phone);
        }

        if (property_exists($shopifyJsonShop, 'updated_at')
            && !empty($shopifyJsonShop->updated_at)
        ) {
            $updatedAt = new DateTime($shopifyJsonShop->updated_at);
            $shop->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonShop, 'customer_email')) {
            $shop->setCustomerEmail($shopifyJsonShop->customer_email);
        }

        if (property_exists($shopifyJsonShop, 'latitude')) {
            $shop->setLatitude($shopifyJsonShop->latitude);
        }

        if (property_exists($shopifyJsonShop, 'longitude')) {
            $shop->setLongitude($shopifyJsonShop->longitude);
        }

        if (property_exists($shopifyJsonShop, 'primary_location_id')) {
            $shop->setPrimaryLocationId($shopifyJsonShop->primary_location_id);
        }

        if (property_exists($shopifyJsonShop, 'primary_locale')) {
            $shop->setPrimaryLocale($shopifyJsonShop->primary_locale);
        }

        if (property_exists($shopifyJsonShop, 'address2')) {
            $shop->setAddress2($shopifyJsonShop->address2);
        }

        if (property_exists($shopifyJsonShop, 'country_code')) {
            $shop->setCountryCode($shopifyJsonShop->country_code);
        }

        if (property_exists($shopifyJsonShop, 'country_name')) {
            $shop->setCountryName($shopifyJsonShop->country_name);
        }

        if (property_exists($shopifyJsonShop, 'currency')) {
            $shop->setCurrency($shopifyJsonShop->currency);
        }

        if (property_exists($shopifyJsonShop, 'timezone')) {
            $shop->setTimezone($shopifyJsonShop->timezone);
        }

        if (property_exists($shopifyJsonShop, 'iana_timezone')) {
            $shop->setIanaTimezone($shopifyJsonShop->iana_timezone);
        }

        if (property_exists($shopifyJsonShop, 'shop_owner')) {
            $shop->setShopOwner($shopifyJsonShop->shop_owner);
        }

        if (property_exists($shopifyJsonShop, 'money_format')) {
            $shop->setMoneyFormat($shopifyJsonShop->money_format);
        }

        if (property_exists($shopifyJsonShop, 'money_with_currency_format')) {
            $shop->setMoneyWithCurrencyFormat($shopifyJsonShop->money_with_currency_format);
        }

        if (property_exists($shopifyJsonShop, 'weight_unit')) {
            $shop->setWeightUnit($shopifyJsonShop->weight_unit);
        }

        if (property_exists($shopifyJsonShop, 'province_code')) {
            $shop->setProvinceCode($shopifyJsonShop->province_code);
        }

        if (property_exists($shopifyJsonShop, 'taxes_included')) {
            $shop->setTaxesIncluded($shopifyJsonShop->taxes_included);
        }

        if (property_exists($shopifyJsonShop, 'tax_shipping')) {
            $shop->setTaxShipping($shopifyJsonShop->tax_shipping);
        }

        if (property_exists($shopifyJsonShop, 'county_taxes')) {
            $shop->setCountyTaxes($shopifyJsonShop->county_taxes);
        }

        if (property_exists($shopifyJsonShop, 'plan_display_name')) {
            $shop->setPlanDisplayName($shopifyJsonShop->plan_display_name);
        }

        if (property_exists($shopifyJsonShop, 'plan_name')) {
            $shop->setPlanName($shopifyJsonShop->plan_name);
        }

        if (property_exists($shopifyJsonShop, 'has_discounts')) {
            $shop->setHasDiscounts($shopifyJsonShop->has_discounts);
        }

        if (property_exists($shopifyJsonShop, 'has_gift_cards')) {
            $shop->setHasGiftCards($shopifyJsonShop->has_gift_cards);
        }

        if (property_exists($shopifyJsonShop, 'myshopify_domain')) {
            $shop->setMyshopifyDomain($shopifyJsonShop->myshopify_domain);
        }

        if (property_exists($shopifyJsonShop, 'google_apps_domain')) {
            $shop->setGoogleAppsDomain($shopifyJsonShop->google_apps_domain);
        }

        if (property_exists($shopifyJsonShop, 'google_apps_login_enabled')) {
            $shop->setGoogleAppsLoginEnabled($shopifyJsonShop->google_apps_login_enabled);
        }

        if (property_exists($shopifyJsonShop, 'money_in_emails_format')) {
            $shop->setMoneyInEmailsFormat($shopifyJsonShop->money_in_emails_format);
        }

        if (property_exists($shopifyJsonShop, 'money_with_currency_in_emails_format')) {
            $shop->setMoneyWithCurrencyInEmailsFormat($shopifyJsonShop->money_with_currency_in_emails_format);
        }

        if (property_exists($shopifyJsonShop, 'eligible_for_payments')) {
            $shop->setEligibleForPayments($shopifyJsonShop->eligible_for_payments);
        }

        if (property_exists($shopifyJsonShop, 'requires_extra_payments_agreement')) {
            $shop->setRequiresExtraPaymentsAgreement($shopifyJsonShop->requires_extra_payments_agreement);
        }

        if (property_exists($shopifyJsonShop, 'password_enabled')) {
            $shop->setPasswordEnabled($shopifyJsonShop->password_enabled);
        }

        if (property_exists($shopifyJsonShop, 'has_storefront')) {
            $shop->setHasStorefront($shopifyJsonShop->has_storefront);
        }

        if (property_exists($shopifyJsonShop, 'eligible_for_card_reader_giveaway')) {
            $shop->setEligibleForCardReaderGiveaway($shopifyJsonShop->eligible_for_card_reader_giveaway);
        }

        if (property_exists($shopifyJsonShop, 'finances')) {
            $shop->setFinances($shopifyJsonShop->finances);
        }

        if (property_exists($shopifyJsonShop, 'setup_required')) {
            $shop->setSetupRequired($shopifyJsonShop->setup_required);
        }

        if (property_exists($shopifyJsonShop, 'force_ssl')) {
            $shop->setForceSsl($shopifyJsonShop->force_ssl);
        }

        return $shop;
    }
}
