<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Psr\Http\Message\ResponseInterface;
use Yaspa\Authentication\OAuth\Models\AssociatedUser as AssociatedUserModel;
use stdClass;

/**
 * Class AssociatedUser
 * @package Yaspa\Transformers\Authentication\OAuth
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * Converts a response or `json_decoded` standard class from Shopify into a PHP object.
 */
class AssociatedUser
{
    /**
     * @param ResponseInterface $response
     * @return AssociatedUserModel
     */
    public function fromResponse(ResponseInterface $response): AssociatedUserModel
    {
        $stdClass = json_decode($response->getBody()->getContents());
        return $this->fromShopifyJsonAssociatedUser($stdClass);
    }

    /**
     * @param stdClass $shopifyJsonAssociatedUser
     * @return AssociatedUserModel
     */
    public function fromShopifyJsonAssociatedUser(stdClass $shopifyJsonAssociatedUser): AssociatedUserModel
    {
        $associatedUser = new AssociatedUserModel();

        if (property_exists($shopifyJsonAssociatedUser, 'id')) {
            $associatedUser->setId($shopifyJsonAssociatedUser->id);
        }

        if (property_exists($shopifyJsonAssociatedUser, 'first_name')) {
            $associatedUser->setFirstName($shopifyJsonAssociatedUser->first_name);
        }

        if (property_exists($shopifyJsonAssociatedUser, 'last_name')) {
            $associatedUser->setLastName($shopifyJsonAssociatedUser->last_name);
        }

        if (property_exists($shopifyJsonAssociatedUser, 'email')) {
            $associatedUser->setEmail($shopifyJsonAssociatedUser->email);
        }

        if (property_exists($shopifyJsonAssociatedUser, 'account_owner')) {
            $associatedUser->setAccountOwner($shopifyJsonAssociatedUser->account_owner);
        }

        return $associatedUser;
    }
}
