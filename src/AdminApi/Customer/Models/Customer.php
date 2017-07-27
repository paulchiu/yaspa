<?php

namespace Yaspa\AdminApi\Customer\Models;

use DateTime;

/**
 * Class Customer
 *
 * @package Yaspa\AdminApi\Customer\Models
 * @see https://help.shopify.com/api/reference/customer#show
 */
class Customer
{
    /** @var int $id */
    protected $id;
    /** @var string $email */
    protected $email;
    /** @var bool $acceptsMarketing */
    protected $acceptsMarketing;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var string $firstName */
    protected $firstName;
    /** @var string $lastName */
    protected $lastName;
    /** @var int $ordersCount */
    protected $ordersCount;
    /** @var string $state */
    protected $state;
    /** @var string $totalSpent */
    protected $totalSpent;
    /** @var int $lastOrderId */
    protected $lastOrderId;
    /** @var string $note */
    protected $note;
    /** @var bool $verifiedEmail */
    protected $verifiedEmail;
    /** @var string $multipassIdentifier */
    protected $multipassIdentifier;
    /** @var bool $taxExempt */
    protected $taxExempt;
    /** @var string $phone */
    protected $phone;
    /** @var array|string[] $tags */
    protected $tags;
    /** @var string $lastOrderName */
    protected $lastOrderName;
    /** @var array|Address[] $addresses */
    protected $addresses;
    /** @var Address $defaultAddress */
    protected $defaultAddress;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->addresses = [];
        $this->tags = [];
    }


    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Customer
     */
    public function setId(int $id): Customer
    {
        $this->id = $id;
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
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAcceptsMarketing():? bool
    {
        return $this->acceptsMarketing;
    }

    /**
     * @param bool $acceptsMarketing
     * @return Customer
     */
    public function setAcceptsMarketing(bool $acceptsMarketing): Customer
    {
        $this->acceptsMarketing = $acceptsMarketing;
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
     * @return Customer
     */
    public function setCreatedAt(DateTime $createdAt): Customer
    {
        $this->createdAt = $createdAt;
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
     * @return Customer
     */
    public function setUpdatedAt(DateTime $updatedAt): Customer
    {
        $this->updatedAt = $updatedAt;
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
     * @return Customer
     */
    public function setFirstName(string $firstName): Customer
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
     * @return Customer
     */
    public function setLastName(string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrdersCount():? int
    {
        return $this->ordersCount;
    }

    /**
     * @param int $ordersCount
     * @return Customer
     */
    public function setOrdersCount(int $ordersCount): Customer
    {
        $this->ordersCount = $ordersCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getState():? string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Customer
     */
    public function setState(?string $state): Customer
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalSpent():? string
    {
        return $this->totalSpent;
    }

    /**
     * @param string $totalSpent
     * @return Customer
     */
    public function setTotalSpent(string $totalSpent): Customer
    {
        $this->totalSpent = $totalSpent;
        return $this;
    }

    /**
     * @return int
     */
    public function getLastOrderId():? int
    {
        return $this->lastOrderId;
    }

    /**
     * @param int $lastOrderId
     * @return Customer
     */
    public function setLastOrderId(?int $lastOrderId): Customer
    {
        $this->lastOrderId = $lastOrderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote():? string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return Customer
     */
    public function setNote(?string $note): Customer
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVerifiedEmail():? bool
    {
        return $this->verifiedEmail;
    }

    /**
     * @param bool $verifiedEmail
     * @return Customer
     */
    public function setVerifiedEmail(bool $verifiedEmail): Customer
    {
        $this->verifiedEmail = $verifiedEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getMultipassIdentifier():? string
    {
        return $this->multipassIdentifier;
    }

    /**
     * @param string $multipassIdentifier
     * @return Customer
     */
    public function setMultipassIdentifier(?string $multipassIdentifier): Customer
    {
        $this->multipassIdentifier = $multipassIdentifier;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxExempt():? bool
    {
        return $this->taxExempt;
    }

    /**
     * @param bool $taxExempt
     * @return Customer
     */
    public function setTaxExempt(bool $taxExempt): Customer
    {
        $this->taxExempt = $taxExempt;
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
     * @return Customer
     */
    public function setPhone(?string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getTags():? array
    {
        return $this->tags;
    }

    /**
     * @param array|string[] $tags
     * @return Customer
     */
    public function setTags(array $tags): Customer
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastOrderName():? string
    {
        return $this->lastOrderName;
    }

    /**
     * @param string $lastOrderName
     * @return Customer
     */
    public function setLastOrderName(?string $lastOrderName): Customer
    {
        $this->lastOrderName = $lastOrderName;
        return $this;
    }

    /**
     * @return array|Address[]
     */
    public function getAddresses():? array
    {
        return $this->addresses;
    }

    /**
     * @param array|Address[] $addresses
     * @return Customer
     */
    public function setAddresses(array $addresses): Customer
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return Address
     */
    public function getDefaultAddress():? Address
    {
        return $this->defaultAddress;
    }

    /**
     * @param Address $defaultAddress
     * @return Customer
     */
    public function setDefaultAddress(Address $defaultAddress): Customer
    {
        $this->defaultAddress = $defaultAddress;
        return $this;
    }
}
