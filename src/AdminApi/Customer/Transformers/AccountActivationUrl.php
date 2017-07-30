<?php

namespace Yaspa\AdminApi\Customer\Transformers;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Yaspa\Exceptions\MissingExpectedAttributeException;

/**
 * Class AccountActivationUrl
 *
 * @package Yaspa\AdminApi\AccountActivationUrl\Transformers
 * @see https://help.shopify.com/api/reference/customer#account_activation_url
 *
 * AccountActivationUrl transformer.
 */
class AccountActivationUrl
{
    /**
     * Convert a Shopify activation url response into a Guzzle URI.
     *
     * @see https://help.shopify.com/api/reference/customer#show
     * @param ResponseInterface $response
     * @return Uri
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): Uri
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'account_activation_url')) {
            throw new MissingExpectedAttributeException('account_activation_url');
        }

        return new Uri($stdClass->account_activation_url);
    }
}
