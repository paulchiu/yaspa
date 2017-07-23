<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Yaspa\Authentication\OAuth\Models\AssociatedUser as AssociatedUserModel;
use stdClass;

/**
 * Class AssociatedUser
 *
 * @package Yaspa\Transformers\Authentication\OAuth
 */
class AssociatedUser
{
    /**
     * Transform an Shopify associated user JSON decoded stdClass into a PHP AssociatedUser class.
     *
     * Please note that this response is returned as a nested object in an access token response that
     * is of an online access mode.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#api-access-modes
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
