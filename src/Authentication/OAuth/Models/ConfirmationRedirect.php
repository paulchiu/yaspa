<?php

namespace Yaspa\Authentication\OAuth\Models;

/**
 * Class ConfirmationRedirect
 * @package Yaspa\Models\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * This model represents the data returned by Shopify once a shop has confirmed an OAuth grant and is modelled
 * on the pattern of https://example.org/some/redirect/uri?code={authorization_code}&hmac=da9d83c171400a41f8db91a950508985&timestamp=1409617544&state={nonce}&shop={hostname}
 */
class ConfirmationRedirect
{
    /** @var string $code */
    protected $code;
    /** @var string $hmac */
    protected $hmac;
    /** @var string $shop */
    protected $shop;
    /** @var string $state This is the nonce returned by Shopify */
    protected $state;
    /** @var string $timestamp */
    protected $timestamp;

    /**
     * @return string
     */
    public function getCode():? string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return ConfirmationRedirect
     */
    public function setCode(string $code): ConfirmationRedirect
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getHmac():? string
    {
        return $this->hmac;
    }

    /**
     * @param string $hmac
     * @return ConfirmationRedirect
     */
    public function setHmac(string $hmac): ConfirmationRedirect
    {
        $this->hmac = $hmac;
        return $this;
    }

    /**
     * @return string
     */
    public function getShop():? string
    {
        return $this->shop;
    }

    /**
     * @param string $shop
     * @return ConfirmationRedirect
     */
    public function setShop(string $shop): ConfirmationRedirect
    {
        $this->shop = $shop;
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
     * @param string|null $state
     * @return ConfirmationRedirect
     */
    public function setState(?string $state): ConfirmationRedirect
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp():? string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     * @return ConfirmationRedirect
     */
    public function setTimestamp(string $timestamp): ConfirmationRedirect
    {
        $this->timestamp = $timestamp;
        return $this;
    }
}
