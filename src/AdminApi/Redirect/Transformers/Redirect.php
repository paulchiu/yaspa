<?php

namespace Yaspa\AdminApi\Redirect\Transformers;

use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Redirect\Models\Redirect as RedirectModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use stdClass;

/**
 * Class Redirect
 *
 * @package Yaspa\AdminApi\Redirect\Transformers
 * @see https://help.shopify.com/api/reference/redirect#show
 */
class Redirect implements ArrayResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return RedirectModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): RedirectModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'redirect')) {
            throw new MissingExpectedAttributeException('redirect');
        }

        return $this->fromShopifyJsonRedirect($stdClass->redirect);
    }


    /**
     * @param ResponseInterface $response
     * @return array|RedirectModel[]
     * @throws MissingExpectedAttributeException
     */
    public function fromArrayResponse(ResponseInterface $response): array
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'redirects')) {
            throw new MissingExpectedAttributeException('redirects');
        }

        return array_map([$this, 'fromShopifyJsonRedirect'], $stdClass->redirects);
    }


    /**
     * @param stdClass $shopifyJsonRedirect
     * @return RedirectModel
     */
    public function fromShopifyJsonRedirect(stdClass $shopifyJsonRedirect): RedirectModel
    {
        $redirect = new RedirectModel();

        if (property_exists($shopifyJsonRedirect, 'id')) {
            $redirect->setId($shopifyJsonRedirect->id);
        }

        if (property_exists($shopifyJsonRedirect, 'path')) {
            $redirect->setPath($shopifyJsonRedirect->path);
        }

        if (property_exists($shopifyJsonRedirect, 'target')) {
            $redirect->setTarget($shopifyJsonRedirect->target);
        }

        return $redirect;
    }

    /**
     * @param RedirectModel $redirect
     * @return array
     */
    public function toArray(RedirectModel $redirect): array
    {
        $array = [];

        $array['id'] = $redirect->getId();
        $array['path'] = $redirect->getPath();
        $array['target'] = $redirect->getTarget();

        return $array;
    }
}
