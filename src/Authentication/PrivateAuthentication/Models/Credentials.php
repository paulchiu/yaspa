<?php

namespace Yaspa\Authentication\PrivateAuthentication\Models;

/**
 * Class Credentials
 *
 * @package Yaspa\Models\Authentication\PrivateAuthentication
 * @see https://help.shopify.com/api/getting-started/authentication/private-authentication
 *
 * Private authentication credentials as defined by Shopify.
 */
class Credentials
{
    /** @var string $apiKey */
    protected $apiKey;
    /** @var string $password */
    protected $password;
    /** @var string $sharedSecret */
    protected $sharedSecret;

    /**
     * @return string
     */
    public function getApiKey():? string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return Credentials
     */
    public function setApiKey(string $apiKey): Credentials
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword():? string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Credentials
     */
    public function setPassword(string $password): Credentials
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSharedSecret():? string
    {
        return $this->sharedSecret;
    }

    /**
     * @param string $sharedSecret
     * @return Credentials
     */
    public function setSharedSecret(string $sharedSecret): Credentials
    {
        $this->sharedSecret = $sharedSecret;
        return $this;
    }
}
