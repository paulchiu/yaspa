<?php

namespace Yaspa\Models\Authentication\OAuth;

/**
 * Class AssociatedUser
 * @package Yaspa\Models\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * This model is based on Shopify's access token with additional data examples. This can be transformed from an OAuth
 * access token request JSON response's `associated_user` property.
 */
class AssociatedUser
{
    /** @var int $id */
    protected $id;
    /** @var string $firstName */
    protected $firstName;
    /** @var string $lastName */
    protected $lastName;
    /** @var string $email */
    protected $email;
    /** @var bool $accountOwner */
    protected $accountOwner;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AssociatedUser
     */
    public function setId(int $id): AssociatedUser
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
     * @return AssociatedUser
     */
    public function setFirstName(string $firstName): AssociatedUser
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
     * @return AssociatedUser
     */
    public function setLastName(string $lastName): AssociatedUser
    {
        $this->lastName = $lastName;
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
     * @return AssociatedUser
     */
    public function setEmail(string $email): AssociatedUser
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountOwner():? bool
    {
        return $this->accountOwner;
    }

    /**
     * @param bool $accountOwner
     * @return AssociatedUser
     */
    public function setAccountOwner(bool $accountOwner): AssociatedUser
    {
        $this->accountOwner = $accountOwner;
        return $this;
    }
}
