<?php

namespace Yaspa\Authentication\OAuth\Models;

/**
 * Class Credentials
 *
 * @package Yaspa\Models\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-1-get-the-clients-credentials
 *
 * Public API credentials; also called App Credentials in the Shopify Partners interface.
 */
class Credentials
{
    /** @var string $apiKey */
    protected $apiKey;
    /** @var string $apiSecretKey */
    protected $apiSecretKey;

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
    public function getApiSecretKey():? string
    {
        return $this->apiSecretKey;
    }

    /**
     * @param string $apiSecretKey
     * @return Credentials
     */
    public function setApiSecretKey(string $apiSecretKey): Credentials
    {
        $this->apiSecretKey = $apiSecretKey;
        return $this;
    }
}
