<?php

namespace Yaspa\AdminApi\Customer\Transformers;

use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Customer\Models\CustomerInvite as CustomerInviteModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use stdClass;

/**
 * Class CustomerInvite
 *
 * @package Yaspa\AdminApi\Customer\Transformers
 * @see https://help.shopify.com/api/reference/customer#send_invite
 */
class CustomerInvite
{
    /**
     * @param ResponseInterface $response
     * @return CustomerInviteModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): CustomerInviteModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'customer_invite')) {
            throw new MissingExpectedAttributeException('customer_invite');
        }

        return $this->fromShopifyJsonCustomerInvite($stdClass->customer_invite);
    }

    /**
     * @param stdClass $shopifyJsonCustomerInvite
     * @return CustomerInviteModel
     */
    public function fromShopifyJsonCustomerInvite(stdClass $shopifyJsonCustomerInvite): CustomerInviteModel
    {
        $customerInvite = new CustomerInviteModel();

        if (property_exists($shopifyJsonCustomerInvite, 'to')) {
            $customerInvite->setTo($shopifyJsonCustomerInvite->to);
        }

        if (property_exists($shopifyJsonCustomerInvite, 'from')) {
            $customerInvite->setFrom($shopifyJsonCustomerInvite->from);
        }

        if (property_exists($shopifyJsonCustomerInvite, 'bcc')) {
            $customerInvite->setBcc($shopifyJsonCustomerInvite->bcc);
        }

        if (property_exists($shopifyJsonCustomerInvite, 'subject')) {
            $customerInvite->setSubject($shopifyJsonCustomerInvite->subject);
        }

        if (property_exists($shopifyJsonCustomerInvite, 'custom_message')) {
            $customerInvite->setCustomMessage($shopifyJsonCustomerInvite->custom_message);
        }

        return $customerInvite;
    }

    /**
     * @param CustomerInviteModel $customerInvite
     * @return array
     */
    public function toArray(CustomerInviteModel $customerInvite): array
    {
        $array = [];

        $array['to'] = $customerInvite->getTo();
        $array['from'] = $customerInvite->getFrom();
        $array['bcc'] = $customerInvite->getBcc();
        $array['subject'] = $customerInvite->getSubject();
        $array['custom_message'] = $customerInvite->getCustomMessage();

        return $array;
    }
}
