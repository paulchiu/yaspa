<?php

namespace Yaspa\AdminApi\Customer\Models;

/**
 * Class Address
 *
 * @package Yaspa\AdminApi\Customer\Models
 * @see https://help.shopify.com/api/reference/customer#show
 */
class Address
{
    /** @var int $id */
    protected $id;
    /** @var string $firstName */
    protected $firstName;
    /** @var string $lastName */
    protected $lastName;
    /** @var string $company */
    protected $company;
    /** @var string $address1 */
    protected $address1;
    /** @var string $address2 */
    protected $address2;
    /** @var string $city */
    protected $city;
    /** @var string $province */
    protected $province;
    /** @var string $country */
    protected $country;
    /** @var int $zip */
    protected $zip;
    /** @var string $phone */
    protected $phone;
    /** @var string $name */
    protected $name;
    /** @var string $provinceCode */
    protected $provinceCode;
    /** @var string $countryCode */
    protected $countryCode;
    /** @var string $countryName */
    protected $countryName;
    /** @var bool $default */
    protected $default;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Address
     */
    public function setId(int $id): Address
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName():? string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Address
     */
    public function setFirstName(?string $firstName): Address
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName():? string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Address
     */
    public function setLastName(?string $lastName): Address
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany():? string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return Address
     */
    public function setCompany(?string $company): Address
    {
        $this->company = $company;
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
     * @return Address
     */
    public function setAddress1(string $address1): Address
    {
        $this->address1 = $address1;
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
     * @return Address
     */
    public function setAddress2(?string $address2): Address
    {
        $this->address2 = $address2;
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
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;
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
     * @return Address
     */
    public function setProvince(string $province): Address
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
     * @return Address
     */
    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return int
     */
    public function getZip():? int
    {
        return $this->zip;
    }

    /**
     * @param int $zip
     * @return Address
     */
    public function setZip(int $zip): Address
    {
        $this->zip = $zip;
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
     * @return Address
     */
    public function setPhone(?string $phone): Address
    {
        $this->phone = $phone;
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
     * @return Address
     */
    public function setName(string $name): Address
    {
        $this->name = $name;
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
     * @return Address
     */
    public function setProvinceCode(string $provinceCode): Address
    {
        $this->provinceCode = $provinceCode;
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
     * @return Address
     */
    public function setCountryCode(string $countryCode): Address
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
     * @return Address
     */
    public function setCountryName(string $countryName): Address
    {
        $this->countryName = $countryName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault():? bool
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return Address
     */
    public function setDefault(bool $default): Address
    {
        $this->default = $default;
        return $this;
    }
}
