<?php

namespace Yaspa\Models\Authentication\OAuth;

/**
 * Class ConfirmationRedirect
 * @package Yaspa\Models\Authentication\OAuth
 */
class ConfirmationRedirect
{
    /** @var string $code */
    protected $code;
    /** @var string $hmac */
    protected $hmac;
    /** @var string $shop */
    protected $shop;
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
