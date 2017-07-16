<?php

namespace Yaspa\Responses;

use Yaspa\Responses\Exceptions;

/**
 * Class StatusCodes
 * @package Yaspa\Responses
 * @see https://help.shopify.com/api/getting-started/response-status-codes
 *
 * Status codes lookup based on definitions provided by Shopify
 */
class StatusCodes
{
    const DEFINITIONS = [
        '200' => 'The request was successfully processed by Shopify.',
        '201' => 'The request has been fulfilled and a new resource has been created.',
        '202' => 'The request has been accepted, but not yet processed.',
        '303' => 'The response to the request can be found under a different URI in the Location header and can be retrieved using a GET method on that resource.',
        '400' => "The request was not understood by the server, generally due to bad syntax or because the Content-Type header was not correctly set to application/json.\n\nThis status is also returned when the request provides an invalid code parameter during the OAuth token exchange process.",
        '401' => 'The necessary authentication credentials are not present in the request or are incorrect.',
        '402' => 'The requested shop is currently frozen.',
        '403' => 'The server is refusing to respond to the request. This is generally because you have not requested the appropriate scope for this action.',
        '404' => 'The requested resource was not found but could be available again in the future.',
        '406' => 'The requested resource is only capable of generating content not acceptable according to the Accept headers sent in the request.',
        '422' => 'The request body was well-formed but contains semantical errors. The response body will provide more details in the errors parameter.',
        '429' => 'The request was not accepted because the application has exceeded the rate limit. See the API Call Limit documentation for a breakdown of Shopify\'s rate-limiting mechanism.',
        '500' => 'An internal error occurred in Shopify. Please post to the API & Technology forum so that Shopify staff can investigate.',
        '501' => 'The requested endpoint is not available on that particular shop, e.g. requesting access to a Plus-specific API on a non-Plus shop. This response may also indicate that this endpoint is reserved for future use.',
        '503' => 'The server is currently unavailable. Check the status page for reported service outages.',
        '504' => 'The request could not complete in time. Try breaking it down in multiple smaller requests.',
    ];

    /**
     * For a given status code, return the Shopify reason for returning it.
     *
     * @param int $statusCode
     * @return string The Shopify definition for the status code.
     * @throws Exceptions\StatusCodeDefinitionNotFoundException
     */
    public function findReason(int $statusCode): string
    {
        // Return definition if found
        if (isset(self::DEFINITIONS[$statusCode])) {
            return self::DEFINITIONS[$statusCode];
        }

        // Throw exception otherwise
        throw new Exceptions\StatusCodeDefinitionNotFoundException($statusCode);
    }
}
