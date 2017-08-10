<?php

namespace Yaspa\AdminApi\Metafield\Transformers;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Metafield\Models\Metafield as MetafieldModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use stdClass;

class Metafield implements ArrayResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return MetafieldModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): MetafieldModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'metafield')) {
            throw new MissingExpectedAttributeException('metafield');
        }

        return $this->fromShopifyJsonMetafield($stdClass->metafield);
    }

    /**
     * @param ResponseInterface $response
     * @return array|MetafieldModel[]
     * @throws MissingExpectedAttributeException
     */
    public function fromArrayResponse(ResponseInterface $response): array
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'metafields')) {
            throw new MissingExpectedAttributeException('metafields');
        }

        return array_map([$this, 'fromShopifyJsonMetafield'], $stdClass->metafields);
    }


    /**
     * @param stdClass $shopifyJsonMetafield
     * @return MetafieldModel
     */
    public function fromShopifyJsonMetafield(stdClass $shopifyJsonMetafield): MetafieldModel
    {
        $metafield = new MetafieldModel();

        if (property_exists($shopifyJsonMetafield, 'id')) {
            $metafield->setId($shopifyJsonMetafield->id);
        }

        if (property_exists($shopifyJsonMetafield, 'namespace')) {
            $metafield->setNamespace($shopifyJsonMetafield->namespace);
        }

        if (property_exists($shopifyJsonMetafield, 'key')) {
            $metafield->setKey($shopifyJsonMetafield->key);
        }

        if (property_exists($shopifyJsonMetafield, 'value')) {
            $metafield->setValue($shopifyJsonMetafield->value);
        }

        if (property_exists($shopifyJsonMetafield, 'value_type')) {
            $metafield->setValueType($shopifyJsonMetafield->value_type);
        }

        if (property_exists($shopifyJsonMetafield, 'description')) {
            $metafield->setDescription($shopifyJsonMetafield->description);
        }

        if (property_exists($shopifyJsonMetafield, 'owner_id')) {
            $metafield->setOwnerId($shopifyJsonMetafield->owner_id);
        }

        if (property_exists($shopifyJsonMetafield, 'created_at')
            && !empty($shopifyJsonMetafield->created_at)
        ) {
            $createdAt = new DateTime($shopifyJsonMetafield->created_at);
            $metafield->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonMetafield, 'updated_at')
            && !empty($shopifyJsonMetafield->updated_at)
        ) {
            $updatedAt = new DateTime($shopifyJsonMetafield->updated_at);
            $metafield->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonMetafield, 'owner_resource')) {
            $metafield->setOwnerResource($shopifyJsonMetafield->owner_resource);
        }

        return $metafield;
    }

    /**
     * @param MetafieldModel $metafield
     * @return array
     */
    public function toArray(MetafieldModel $metafield): array
    {
        $array = [];

        $array['id'] = $metafield->getId();
        $array['namespace'] = $metafield->getNamespace();
        $array['key'] = $metafield->getKey();
        $array['value'] = $metafield->getValue();
        $array['value_type'] = $metafield->getValueType();
        $array['description'] = $metafield->getDescription();
        $array['owner_id'] = $metafield->getOwnerId();
        $array['created_at'] = ($metafield->getCreatedAt()) ? $metafield->getCreatedAt()->format(DateTime::ISO8601) : null;
        $array['updated_at'] = ($metafield->getUpdatedAt()) ? $metafield->getUpdatedAt()->format(DateTime::ISO8601) : null;
        $array['owner_resource'] = $metafield->getOwnerResource();

        return $array;
    }
}
