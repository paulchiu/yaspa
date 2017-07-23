<?php

namespace Yaspa\Authentication\OAuth\Models;

use Yaspa\Authentication\OAuth\Builders\Scopes;

/**
 * Class AccessToken
 *
 * @package Yaspa\Models\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * This model is based on Shopify's access token with additional data examples. This can be transformed from an OAuth
 * access token request JSON response.
 */
class AccessToken
{
    /** @var string $accessToken */
    protected $accessToken;
    /** @var Scopes $scopes */
    protected $scopes;
    /** @var int $expiresIn */
    protected $expiresIn;

    /**
     * The following properties are only filled when the access token is of type 'online'
     */
    /** @var Scopes $associatedUserScopes */
    protected $associatedUserScopes;
    /** @var AssociatedUser $associatedUser */
    protected $associatedUser;

    /**
     * @return string
     */
    public function getAccessToken():? string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return AccessToken
     */
    public function setAccessToken(string $accessToken): AccessToken
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return Scopes
     */
    public function getScopes():? Scopes
    {
        return $this->scopes;
    }

    /**
     * @param Scopes $scopes
     * @return AccessToken
     */
    public function setScopes(Scopes $scopes): AccessToken
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn():? int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     * @return AccessToken
     */
    public function setExpiresIn(int $expiresIn): AccessToken
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }

    /**
     * @return Scopes
     */
    public function getAssociatedUserScopes():? Scopes
    {
        return $this->associatedUserScopes;
    }

    /**
     * @param Scopes $associatedUserScopes
     * @return AccessToken
     */
    public function setAssociatedUserScopes(Scopes $associatedUserScopes): AccessToken
    {
        $this->associatedUserScopes = $associatedUserScopes;
        return $this;
    }

    /**
     * @return AssociatedUser
     */
    public function getAssociatedUser():? AssociatedUser
    {
        return $this->associatedUser;
    }

    /**
     * @param AssociatedUser $associatedUser
     * @return AccessToken
     */
    public function setAssociatedUser(AssociatedUser $associatedUser): AccessToken
    {
        $this->associatedUser = $associatedUser;
        return $this;
    }
}
