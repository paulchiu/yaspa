<?php

namespace Yaspa\AdminApi\Metafield\Models;

use DateTime;

/**
 * Class Metafield
 *
 * @package Yaspa\AdminApi\Metafield\Models
 * @see https://help.shopify.com/api/reference/metafield#show
 */
class Metafield
{
    /** @var int $id */
    protected $id;
    /** @var string $namespace */
    protected $namespace;
    /** @var string $key */
    protected $key;
    /** @var int $value */
    protected $value;
    /** @var string $valueType */
    protected $valueType;
    /** @var string $description */
    protected $description;
    /** @var int $ownerId */
    protected $ownerId;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var string $ownerResource */
    protected $ownerResource;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Metafield
     */
    public function setId(int $id): Metafield
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace():? string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return Metafield
     */
    public function setNamespace(string $namespace): Metafield
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey():? string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Metafield
     */
    public function setKey(string $key): Metafield
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue():? int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return Metafield
     */
    public function setValue(int $value): Metafield
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValueType():? string
    {
        return $this->valueType;
    }

    /**
     * @param string $valueType
     * @return Metafield
     */
    public function setValueType(string $valueType): Metafield
    {
        $this->valueType = $valueType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription():? string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Metafield
     */
    public function setDescription(?string $description): Metafield
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getOwnerId():? int
    {
        return $this->ownerId;
    }

    /**
     * @param int $ownerId
     * @return Metafield
     */
    public function setOwnerId(int $ownerId): Metafield
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt():? DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Metafield
     */
    public function setCreatedAt(DateTime $createdAt): Metafield
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt():? DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return Metafield
     */
    public function setUpdatedAt(DateTime $updatedAt): Metafield
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerResource():? string
    {
        return $this->ownerResource;
    }

    /**
     * @param string $ownerResource
     * @return Metafield
     */
    public function setOwnerResource(string $ownerResource): Metafield
    {
        $this->ownerResource = $ownerResource;
        return $this;
    }
}
