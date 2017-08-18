<?php

namespace Yaspa\AdminApi\Product\Models;

use DateTime;

/**
 * Class Image
 *
 * @package Yaspa\AdminApi\Product\Models
 * @see https://help.shopify.com/api/reference/product#show
 *
 * The image associated with a product.
 */
class Image
{
    /** @var int $id */
    protected $id;
    /** @var int $productId */
    protected $productId;
    /** @var int $position */
    protected $position;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var int $width */
    protected $width;
    /** @var int $height */
    protected $height;
    /** @var string $src */
    protected $src;
    /** @var string $attachment */
    protected $attachment;
    /** @var int[] $variantIds */
    protected $variantIds;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Image
     */
    public function setId(int $id): Image
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductId():? int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return Image
     */
    public function setProductId(int $productId): Image
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition():? int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Image
     */
    public function setPosition(int $position): Image
    {
        $this->position = $position;
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
     * @return Image
     */
    public function setCreatedAt(DateTime $createdAt): Image
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
     * @return Image
     */
    public function setUpdatedAt(DateTime $updatedAt): Image
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth():? int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return Image
     */
    public function setWidth(int $width): Image
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight():? int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return Image
     */
    public function setHeight(int $height): Image
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc():? string
    {
        return $this->src;
    }

    /**
     * @param string $src
     * @return Image
     */
    public function setSrc(string $src): Image
    {
        $this->src = $src;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttachment():? string
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     * @return Image
     */
    public function setAttachment(string $attachment): Image
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getVariantIds():? array
    {
        return $this->variantIds;
    }

    /**
     * @param int[] $variantIds
     * @return Image
     */
    public function setVariantIds(array $variantIds): Image
    {
        $this->variantIds = $variantIds;
        return $this;
    }
}
