<?php

namespace Yaspa\Authentication\Builders;

use Yaspa\Authentication\OAuth\Models\AccessToken as OAuthAccessToken;
use Yaspa\Authentication\OAuth\Transformers\AccessToken as OAuthAccessTokenTransformer;
use Yaspa\Authentication\PrivateAuthentication\Models\Credentials as PrivateAuthCredentials;
use Yaspa\Authentication\PrivateAuthentication\Transformers\Credentials as PrivateAuthCredentialsTransformer;
use Yaspa\Exceptions\MissingRequiredParameterException;

/**
 * Class ApiCredentials
 *
 * @package Yaspa\Authentication\Builders
 *
 * This is a convenience wrapper to consolidate API authentication methods.
 *
 * To use, set shop and either an OAuthAccess token or private authentication credentials.
 *
 * Please note that the OAuth access token will take precedence if both are provided.
 */
class ApiCredentials
{
    /**
     * Properties
     */
    /** @var string $shop */
    protected $shop;
    /** @var OAuthAccessToken $oAuthAccessToken */
    protected $oAuthAccessToken;
    /** @var PrivateAuthCredentials $privateAuthCredentials */
    protected $privateAuthCredentials;

    /**
     * Dependencies
     */
    /** @var OAuthAccessTokenTransformer $oAuthAccessTokenTransformer */
    protected $oAuthAccessTokenTransformer;
    /** @var PrivateAuthCredentialsTransformer $privateAuthCredentialsTransformer */
    protected $privateAuthCredentialsTransformer;

    /**
     * ApiCredentials constructor.
     *
     * @param OAuthAccessTokenTransformer $oAuthAccessTokenTransformer
     * @param PrivateAuthCredentialsTransformer $privateAuthCredentialsTransformer
     */
    public function __construct(
        OAuthAccessTokenTransformer $oAuthAccessTokenTransformer,
        PrivateAuthCredentialsTransformer $privateAuthCredentialsTransformer
    ) {
        $this->oAuthAccessTokenTransformer = $oAuthAccessTokenTransformer;
        $this->privateAuthCredentialsTransformer = $privateAuthCredentialsTransformer;
    }

    /**
     * @return string
     */
    public function getShop():? string
    {
        return $this->shop;
    }

    /**
     * Converts API credentials to Guzzle request options.
     *
     * @return array
     * @throws MissingRequiredParameterException
     */
    public function toRequestOptions(): array
    {
        if ($this->oAuthAccessToken) {
            return $this->oAuthAccessTokenTransformer->toRequestOptions($this->oAuthAccessToken);
        }

        if ($this->privateAuthCredentials) {
            return $this->privateAuthCredentialsTransformer->toRequestOptions($this->privateAuthCredentials);
        }

        throw new MissingRequiredParameterException('oAuthAccessToken OR privateAuthCredentials');
    }
    
    /**
     * @param string $shop
     * @return ApiCredentials
     */
    public function withShop(string $shop): ApiCredentials
    {
        $new = clone $this;
        $new->shop = $shop;

        return $new;
    }

    /**
     * @param OAuthAccessToken $oAuthAccessToken
     * @return ApiCredentials
     */
    public function withOAuthAccessToken(OAuthAccessToken $oAuthAccessToken): ApiCredentials
    {
        $new = clone $this;
        $new->oAuthAccessToken = $oAuthAccessToken;

        return $new;
    }

    /**
     * @param PrivateAuthCredentials $privateAuthCredentials
     * @return ApiCredentials
     */
    public function withPrivateAuthCredentials(PrivateAuthCredentials $privateAuthCredentials): ApiCredentials
    {
        $new = clone $this;
        $new->privateAuthCredentials = $privateAuthCredentials;

        return $new;
    }
}
