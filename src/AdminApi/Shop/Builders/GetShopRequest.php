<?php

namespace Yaspa\AdminApi\Shop\Builders;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Yaspa\Interfaces\RequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestTrait;
use Yaspa\Traits\RequestBuilderTrait;

/**
 * Class GetShopRequest
 *
 * @package Yaspa\AdminApi\Shop\Builders
 * @mixin AuthorizedRequestTrait
 * @mixin RequestBuilderTrait
 * @see https://help.shopify.com/api/reference/shop#show
 *
 * Show the shop details of the credentials used.
 */
class GetShopRequest implements RequestBuilderInterface
{
    use AuthorizedRequestTrait,
        RequestBuilderTrait;

    const HEADERS = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    const HTTP_METHOD = 'GET';
    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/shop.json';

    /**
     * GetShopRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->httpMethod = self::HTTP_METHOD;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->headers = self::HEADERS;
    }

    /**
     * Generate a Guzzle/PSR-7 request.
     *
     * @return Request
     */
    public function toRequest(): Request
    {
        // Create URI
        $uri = new Uri(sprintf($this->uriTemplate, $this->credentials->getShop()));

        // Create request
        return new Request(
            $this->httpMethod,
            $uri,
            $this->headers
        );
    }

    /**
     * Generate Guzzle request options.
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @return array
     */
    public function toRequestOptions(): array
    {
        return $this->credentials->toRequestOptions();
    }
}
