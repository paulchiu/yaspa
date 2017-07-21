<?php

namespace Yaspa\Transformers\Authentication\OAuth;

use Psr\Http\Message\ResponseInterface;
use Yaspa\Models\Authentication\OAuth\AccessToken as AccessTokenModel;
use stdClass;

/**
 * Class AccessToken
 * @package Yaspa\Transformers\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Converts a response or `json_decoded` standard class from Shopify into a PHP object.
 */
class AccessToken
{
    /** @var AssociatedUser $associatedUserTransformer */
    protected $associatedUserTransformer;

    /**
     * AccessToken constructor.
     * @param AssociatedUser $associatedUserTransformer
     */
    public function __construct(AssociatedUser $associatedUserTransformer)
    {
        $this->associatedUserTransformer = $associatedUserTransformer;
    }

    /**
     * @param ResponseInterface $response
     * @return AccessTokenModel
     */
    public function fromResponse(ResponseInterface $response): AccessTokenModel
    {
        $responseContents = $response->getBody()->getContents();
        $stdClass = json_decode($responseContents);
        return $this->fromShopifyJsonAccessToken($stdClass);
    }

    /**
     * @param stdClass $shopifyJsonAccessToken
     * @return AccessTokenModel
     */
    public function fromShopifyJsonAccessToken(stdClass $shopifyJsonAccessToken): AccessTokenModel
    {
        $accessToken = new AccessTokenModel();

        if (property_exists($shopifyJsonAccessToken, 'access_token')) {
            $accessToken->setAccessToken($shopifyJsonAccessToken->access_token);
        }

        if (property_exists($shopifyJsonAccessToken, 'scope')) {
            $scopes = explode(',', $shopifyJsonAccessToken->scope);
            $accessToken->setScopes($scopes);
        }

        if (property_exists($shopifyJsonAccessToken, 'expires_in')) {
            $accessToken->setExpiresIn($shopifyJsonAccessToken->expires_in);
        }

        if (property_exists($shopifyJsonAccessToken, 'associated_user_scope')) {
            $associatedUserScopes = explode(',', $shopifyJsonAccessToken->associated_user_scope);
            $accessToken->setAssociatedUserScopes($associatedUserScopes);
        }

        if (property_exists($shopifyJsonAccessToken, 'associated_user')) {
            $associatedUser = $this->associatedUserTransformer
                ->fromShopifyJsonAssociatedUser($shopifyJsonAccessToken->associated_user);
            $accessToken->setAssociatedUser($associatedUser);
        }

        return $accessToken;
    }

    /**
     * Returns a Shopify specified header array that can be used as part of Guzzle request options.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-4-making-authenticated-requests
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#headers
     * @param AccessTokenModel $accessToken
     * @return array
     */
    public function toAuthenticatedRequestHeader(AccessTokenModel $accessToken): array
    {
        return ['X-Shopify-Access-Token' => $accessToken->getAccessToken()];
    }
}
