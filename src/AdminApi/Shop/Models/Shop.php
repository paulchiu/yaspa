<?php

namespace Yaspa\AdminApi\Shop\Models;

use DateTime;

/**
 * Class Shop
 *
 * @package Yaspa\AdminApi\Shop\Models
 * @see https://help.shopify.com/api/reference/shop
 *
 * Please note that some null-able fields are based on documentation, others based on
 * inspecting real responses.
 */
class Shop
{
    /** @var int $id */
    protected $id;
    /** @var string $name */
    protected $name;
    /** @var string $email */
    protected $email;
    /** @var string $domain */
    protected $domain;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var string $province */
    protected $province;
    /** @var string $country */
    protected $country;
    /** @var string $address1 */
    protected $address1;
    /** @var string $zip */
    protected $zip;
    /** @var string $city */
    protected $city;
    /** @var string $source */
    protected $source;
    /** @var string $phone */
    protected $phone;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var string $customerEmail */
    protected $customerEmail;
    /** @var float $latitude */
    protected $latitude;
    /** @var float $longitude */
    protected $longitude;
    /** @var int $primaryLocationId */
    protected $primaryLocationId;
    /** @var string $primaryLocale */
    protected $primaryLocale;
    /** @var string $address2 */
    protected $address2;
    /** @var string $countryCode */
    protected $countryCode;
    /** @var string $countryName */
    protected $countryName;
    /** @var string $currency */
    protected $currency;
    /** @var string $timezone */
    protected $timezone;
    /** @var string $ianaTimezone */
    protected $ianaTimezone;
    /** @var string $shopOwner */
    protected $shopOwner;
    /** @var string $moneyFormat */
    protected $moneyFormat;
    /** @var string $moneyWithCurrencyFormat */
    protected $moneyWithCurrencyFormat;
    /** @var string $weightUnit */
    protected $weightUnit;
    /** @var string $provinceCode */
    protected $provinceCode;
    /** @var bool $taxesIncluded */
    protected $taxesIncluded;
    /** @var bool $taxShipping */
    protected $taxShipping;
    /** @var bool $countyTaxes */
    protected $countyTaxes;
    /** @var string $planDisplayName */
    protected $planDisplayName;
    /** @var string $planName */
    protected $planName;
    /** @var bool $hasDiscounts */
    protected $hasDiscounts;
    /** @var bool $hasGiftCards */
    protected $hasGiftCards;
    /** @var string $myshopifyDomain */
    protected $myshopifyDomain;
    /** @var string $googleAppsDomain */
    protected $googleAppsDomain;
    /** @var bool $googleAppsLoginEnabled */
    protected $googleAppsLoginEnabled;
    /** @var string $moneyInEmailsFormat */
    protected $moneyInEmailsFormat;
    /** @var string $moneyWithCurrencyInEmailsFormat */
    protected $moneyWithCurrencyInEmailsFormat;
    /** @var bool $eligibleForPayments */
    protected $eligibleForPayments;
    /** @var bool $requiresExtraPaymentsAgreement */
    protected $requiresExtraPaymentsAgreement;
    /** @var bool $passwordEnabled */
    protected $passwordEnabled;
    /** @var bool $hasStorefront */
    protected $hasStorefront;
    /** @var bool $eligibleForCardReaderGiveaway */
    protected $eligibleForCardReaderGiveaway;
    /** @var bool $finances */
    protected $finances;
    /** @var bool $setupRequired */
    protected $setupRequired;
    /** @var bool $forceSsl */
    protected $forceSsl;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Shop
     */
    public function setId(int $id): Shop
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Shop
     */
    public function setName(string $name): Shop
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail():? string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Shop
     */
    public function setEmail(string $email): Shop
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain():? string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return Shop
     */
    public function setDomain(string $domain): Shop
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt():? DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Shop
     */
    public function setCreatedAt(DateTime $createdAt): Shop
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince():? string
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return Shop
     */
    public function setProvince(string $province): Shop
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry():? string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Shop
     */
    public function setCountry(string $country): Shop
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1():? string
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return Shop
     */
    public function setAddress1(string $address1): Shop
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip():? string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return Shop
     */
    public function setZip(string $zip): Shop
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity():? string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Shop
     */
    public function setCity(string $city): Shop
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource():? string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return Shop
     */
    public function setSource(?string $source): Shop
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone():? string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Shop
     */
    public function setPhone(?string $phone): Shop
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt():? DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Shop
     */
    public function setUpdatedAt(DateTime $updatedAt): Shop
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerEmail():? string
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     * @return Shop
     */
    public function setCustomerEmail(?string $customerEmail): Shop
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude():? float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Shop
     */
    public function setLatitude(float $latitude): Shop
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude():? float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Shop
     */
    public function setLongitude(float $longitude): Shop
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrimaryLocationId():? int
    {
        return $this->primaryLocationId;
    }

    /**
     * @param int $primaryLocationId
     * @return Shop
     */
    public function setPrimaryLocationId(int $primaryLocationId): Shop
    {
        $this->primaryLocationId = $primaryLocationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryLocale():? string
    {
        return $this->primaryLocale;
    }

    /**
     * @param string $primaryLocale
     * @return Shop
     */
    public function setPrimaryLocale(string $primaryLocale): Shop
    {
        $this->primaryLocale = $primaryLocale;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2():? string
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return Shop
     */
    public function setAddress2(string $address2): Shop
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode():? string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return Shop
     */
    public function setCountryCode(string $countryCode): Shop
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryName():? string
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     * @return Shop
     */
    public function setCountryName(string $countryName): Shop
    {
        $this->countryName = $countryName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency():? string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Shop
     */
    public function setCurrency(string $currency): Shop
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone():? string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     * @return Shop
     */
    public function setTimezone(string $timezone): Shop
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @return string
     */
    public function getIanaTimezone():? string
    {
        return $this->ianaTimezone;
    }

    /**
     * @param string $ianaTimezone
     * @return Shop
     */
    public function setIanaTimezone(string $ianaTimezone): Shop
    {
        $this->ianaTimezone = $ianaTimezone;
        return $this;
    }

    /**
     * @return string
     */
    public function getShopOwner():? string
    {
        return $this->shopOwner;
    }

    /**
     * @param string $shopOwner
     * @return Shop
     */
    public function setShopOwner(string $shopOwner): Shop
    {
        $this->shopOwner = $shopOwner;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoneyFormat():? string
    {
        return $this->moneyFormat;
    }

    /**
     * @param string $moneyFormat
     * @return Shop
     */
    public function setMoneyFormat(string $moneyFormat): Shop
    {
        $this->moneyFormat = $moneyFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoneyWithCurrencyFormat():? string
    {
        return $this->moneyWithCurrencyFormat;
    }

    /**
     * @param string $moneyWithCurrencyFormat
     * @return Shop
     */
    public function setMoneyWithCurrencyFormat(string $moneyWithCurrencyFormat): Shop
    {
        $this->moneyWithCurrencyFormat = $moneyWithCurrencyFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeightUnit():? string
    {
        return $this->weightUnit;
    }

    /**
     * @param string $weightUnit
     * @return Shop
     */
    public function setWeightUnit(string $weightUnit): Shop
    {
        $this->weightUnit = $weightUnit;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvinceCode():? string
    {
        return $this->provinceCode;
    }

    /**
     * @param string $provinceCode
     * @return Shop
     */
    public function setProvinceCode(string $provinceCode): Shop
    {
        $this->provinceCode = $provinceCode;
        return $this;
    }

    /**
     * @return bool
     */
    public function taxesIncluded():? bool
    {
        return $this->taxesIncluded;
    }

    /**
     * @param bool $taxesIncluded
     * @return Shop
     */
    public function setTaxesIncluded(?bool $taxesIncluded): Shop
    {
        $this->taxesIncluded = $taxesIncluded;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxShipping():? bool
    {
        return $this->taxShipping;
    }

    /**
     * @param bool $taxShipping
     * @return Shop
     */
    public function setTaxShipping(?bool $taxShipping): Shop
    {
        $this->taxShipping = $taxShipping;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasCountyTaxes():? bool
    {
        return $this->countyTaxes;
    }

    /**
     * @param bool $countyTaxes
     * @return Shop
     */
    public function setCountyTaxes(?bool $countyTaxes): Shop
    {
        $this->countyTaxes = $countyTaxes;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanDisplayName():? string
    {
        return $this->planDisplayName;
    }

    /**
     * @param string $planDisplayName
     * @return Shop
     */
    public function setPlanDisplayName(string $planDisplayName): Shop
    {
        $this->planDisplayName = $planDisplayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlanName():? string
    {
        return $this->planName;
    }

    /**
     * @param string $planName
     * @return Shop
     */
    public function setPlanName(string $planName): Shop
    {
        $this->planName = $planName;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasDiscounts():? bool
    {
        return $this->hasDiscounts;
    }

    /**
     * @param bool $hasDiscounts
     * @return Shop
     */
    public function setHasDiscounts(bool $hasDiscounts): Shop
    {
        $this->hasDiscounts = $hasDiscounts;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasGiftCards():? bool
    {
        return $this->hasGiftCards;
    }

    /**
     * @param bool $hasGiftCards
     * @return Shop
     */
    public function setHasGiftCards(bool $hasGiftCards): Shop
    {
        $this->hasGiftCards = $hasGiftCards;
        return $this;
    }

    /**
     * @return string
     */
    public function getMyshopifyDomain():? string
    {
        return $this->myshopifyDomain;
    }

    /**
     * @param string $myshopifyDomain
     * @return Shop
     */
    public function setMyshopifyDomain(string $myshopifyDomain): Shop
    {
        $this->myshopifyDomain = $myshopifyDomain;
        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleAppsDomain():? string
    {
        return $this->googleAppsDomain;
    }

    /**
     * @param string $googleAppsDomain
     * @return Shop
     */
    public function setGoogleAppsDomain(?string $googleAppsDomain): Shop
    {
        $this->googleAppsDomain = $googleAppsDomain;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGoogleAppsLoginEnabled():? bool
    {
        return $this->googleAppsLoginEnabled;
    }

    /**
     * @param bool $googleAppsLoginEnabled
     * @return Shop
     */
    public function setGoogleAppsLoginEnabled(?bool $googleAppsLoginEnabled): Shop
    {
        $this->googleAppsLoginEnabled = $googleAppsLoginEnabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoneyInEmailsFormat():? string
    {
        return $this->moneyInEmailsFormat;
    }

    /**
     * @param string $moneyInEmailsFormat
     * @return Shop
     */
    public function setMoneyInEmailsFormat(string $moneyInEmailsFormat): Shop
    {
        $this->moneyInEmailsFormat = $moneyInEmailsFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getMoneyWithCurrencyInEmailsFormat():? string
    {
        return $this->moneyWithCurrencyInEmailsFormat;
    }

    /**
     * @param string $moneyWithCurrencyInEmailsFormat
     * @return Shop
     */
    public function setMoneyWithCurrencyInEmailsFormat(string $moneyWithCurrencyInEmailsFormat): Shop
    {
        $this->moneyWithCurrencyInEmailsFormat = $moneyWithCurrencyInEmailsFormat;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEligibleForPayments():? bool
    {
        return $this->eligibleForPayments;
    }

    /**
     * @param bool $eligibleForPayments
     * @return Shop
     */
    public function setEligibleForPayments(bool $eligibleForPayments): Shop
    {
        $this->eligibleForPayments = $eligibleForPayments;
        return $this;
    }

    /**
     * @return bool
     */
    public function requiresExtraPaymentsAgreement():? bool
    {
        return $this->requiresExtraPaymentsAgreement;
    }

    /**
     * @param bool $requiresExtraPaymentsAgreement
     * @return Shop
     */
    public function setRequiresExtraPaymentsAgreement(bool $requiresExtraPaymentsAgreement): Shop
    {
        $this->requiresExtraPaymentsAgreement = $requiresExtraPaymentsAgreement;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPasswordEnabled():? bool
    {
        return $this->passwordEnabled;
    }

    /**
     * @param bool $passwordEnabled
     * @return Shop
     */
    public function setPasswordEnabled(bool $passwordEnabled): Shop
    {
        $this->passwordEnabled = $passwordEnabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasStorefront():? bool
    {
        return $this->hasStorefront;
    }

    /**
     * @param bool $hasStorefront
     * @return Shop
     */
    public function setHasStorefront(bool $hasStorefront): Shop
    {
        $this->hasStorefront = $hasStorefront;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEligibleForCardReaderGiveaway():? bool
    {
        return $this->eligibleForCardReaderGiveaway;
    }

    /**
     * @param bool $eligibleForCardReaderGiveaway
     * @return Shop
     */
    public function setEligibleForCardReaderGiveaway(bool $eligibleForCardReaderGiveaway): Shop
    {
        $this->eligibleForCardReaderGiveaway = $eligibleForCardReaderGiveaway;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFinances():? bool
    {
        return $this->finances;
    }

    /**
     * @param bool $finances
     * @return Shop
     */
    public function setFinances(bool $finances): Shop
    {
        $this->finances = $finances;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSetupRequired():? bool
    {
        return $this->setupRequired;
    }

    /**
     * @param bool $setupRequired
     * @return Shop
     */
    public function setSetupRequired(bool $setupRequired): Shop
    {
        $this->setupRequired = $setupRequired;
        return $this;
    }

    /**
     * @return bool
     */
    public function forceSsl():? bool
    {
        return $this->forceSsl;
    }

    /**
     * @param bool $forceSsl
     * @return Shop
     */
    public function setForceSsl(bool $forceSsl): Shop
    {
        $this->forceSsl = $forceSsl;
        return $this;
    }
}
