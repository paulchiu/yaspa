<?php

namespace Yaspa\AdminApi\ScriptTag\Transformers;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\ScriptTag\Models\ScriptTag as ScriptTagModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use stdClass;

/**
 * Class ScriptTag
 *
 * @package Yaspa\AdminApi\ScriptTag\Transformers
 * @see https://help.shopify.com/api/reference/scripttag#show
 *
 * Transform Shopify scripttag(s).
 */
class ScriptTag implements ArrayResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return ScriptTagModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): ScriptTagModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'script_tag')) {
            throw new MissingExpectedAttributeException('script_tag');
        }

        return $this->fromShopifyJsonScriptTag($stdClass->script_tag);
    }

    /**
     * @param ResponseInterface $response
     * @return array|ScriptTagModel[]
     * @throws MissingExpectedAttributeException
     */
    public function fromArrayResponse(ResponseInterface $response): array
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'script_tags')) {
            throw new MissingExpectedAttributeException('script_tags');
        }

        return array_map([$this, 'fromShopifyJsonScriptTag'], $stdClass->script_tags);
    }

    /**
     * @param stdClass $shopifyJsonScriptTag
     * @return ScriptTagModel
     */
    public function fromShopifyJsonScriptTag(stdClass $shopifyJsonScriptTag): ScriptTagModel
    {
        $scriptTag = new ScriptTagModel();

        if (property_exists($shopifyJsonScriptTag, 'id')) {
            $scriptTag->setId($shopifyJsonScriptTag->id);
        }

        if (property_exists($shopifyJsonScriptTag, 'src')) {
            $scriptTag->setSrc($shopifyJsonScriptTag->src);
        }

        if (property_exists($shopifyJsonScriptTag, 'event')) {
            $scriptTag->setEvent($shopifyJsonScriptTag->event);
        }

        if (property_exists($shopifyJsonScriptTag, 'created_at')
            && !empty($shopifyJsonScriptTag->created_at)
        ) {
            $createdAt = new DateTime($shopifyJsonScriptTag->created_at);
            $scriptTag->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonScriptTag, 'updated_at')
            && !empty($shopifyJsonScriptTag->updated_at)
        ) {
            $updatedAt = new DateTime($shopifyJsonScriptTag->updated_at);
            $scriptTag->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonScriptTag, 'display_scope')) {
            $scriptTag->setDisplayScope($shopifyJsonScriptTag->display_scope);
        }

        return $scriptTag;
    }

    /**
     * @param ScriptTagModel $scriptTag
     * @return array
     */
    public function toArray(ScriptTagModel $scriptTag): array
    {
        $array = [];

        $array['id'] = $scriptTag->getId();
        $array['src'] = $scriptTag->getSrc();
        $array['event'] = $scriptTag->getEvent();
        $array['created_at'] = ($scriptTag->getCreatedAt()) ? $scriptTag->getCreatedAt()->format(DateTime::ISO8601) : null;
        $array['updated_at'] = ($scriptTag->getUpdatedAt()) ? $scriptTag->getUpdatedAt()->format(DateTime::ISO8601) : null;
        $array['display_scope'] = $scriptTag->getDisplayScope();

        /**
         * Attributes that cannot be empty
         */
        if ($scriptTag->getSrc() !== null) {
            $array['src'] = $scriptTag->getSrc();
        }

        if ($scriptTag->getEvent() !== null) {
            $array['event'] = $scriptTag->getEvent();
        }

        return $array;
    }
}
