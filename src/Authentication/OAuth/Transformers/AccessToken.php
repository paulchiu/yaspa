<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Psr\Http\Message\ResponseInterface;
use Yaspa\Authentication\OAuth\Models\AccessToken as AccessTokenModel;
use stdClass;

/**
 * Class AccessToken
 *
 * @package Yaspa\Transformers\Authentication\OAuth
 */
class AccessToken
{
    /** @var AssociatedUser $associatedUserTransformer */
    protected $associatedUserTransformer;
    /** @var Scopes $scopesTransformer */
    protected $scopesTransformer;

    /**
     * AccessToken constructor.
     *
     * @param AssociatedUser $associatedUserTransformer
     * @param Scopes $scopesTransformer
     */
    public function __construct(
        AssociatedUser $associatedUserTransformer,
        Scopes $scopesTransformer
    ) {
        $this->associatedUserTransformer = $associatedUserTransformer;
        $this->scopesTransformer = $scopesTransformer;
    }

    /**
     * Transform a Guzzle response into an AccessToken model.
     *
     * The expected response contents is a JSON string.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
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
     * Transform a Shopify JSON access token stdClass into a PHP AccessToken model class.
     *
     * Please note that this transformer deeply transforms scope attributes into Scope builder classes.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
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
            $scopes = $this->scopesTransformer->fromCommaSeparatedList($shopifyJsonAccessToken->scope);
            $accessToken->setScopes($scopes);
        }

        if (property_exists($shopifyJsonAccessToken, 'expires_in')) {
            $accessToken->setExpiresIn($shopifyJsonAccessToken->expires_in);
        }

        if (property_exists($shopifyJsonAccessToken, 'associated_user_scope')) {
            $associatedUserScopes = $this->scopesTransformer->fromCommaSeparatedList($shopifyJsonAccessToken->associated_user_scope);
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
