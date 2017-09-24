<?php

namespace Yaspa\AdminApi\Product\Models;

use DateTime;

/**
 * Class Variant
 *
 * @package Yaspa\AdminApi\Product\Models
 * @see https://help.shopify.com/api/reference/product#show
 *
 * A variant of a product. Also known as a product variant.
 */
class Variant
{
    /** @var int $id */
    protected $id;
    /** @var int $productId */
    protected $productId;
    /** @var string $title */
    protected $title;
    /** @var float $price */
    protected $price;
    /** @var string $sku */
    protected $sku;
    /** @var int $position */
    protected $position;
    /** @var int $grams */
    protected $grams;
    /** @var string $inventoryPolicy */
    protected $inventoryPolicy;
    /** @var string $compareAtPrice */
    protected $compareAtPrice;
    /** @var string $fulfillmentService */
    protected $fulfillmentService;
    /** @var string $inventoryManagement */
    protected $inventoryManagement;
    /** @var string $option1 */
    protected $option1;
    /** @var string $option2 */
    protected $option2;
    /** @var string $option3 */
    protected $option3;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var bool $taxable */
    protected $taxable;
    /** @var string $barcode */
    protected $barcode;
    /** @var int $imageId */
    protected $imageId;
    /** @var int $inventoryQuantity */
    protected $inventoryQuantity;
    /** @var float $weight */
    protected $weight;
    /** @var string $weightUnit */
    protected $weightUnit;
    /** @var int $oldInventoryQuantity */
    protected $oldInventoryQuantity;
    /** @var bool $requiresShipping */
    protected $requiresShipping;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Variant
     */
    public function setId(int $id): Variant
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
     * @return Variant
     */
    public function setProductId(int $productId): Variant
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle():? string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Variant
     */
    public function setTitle(string $title): Variant
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice():? float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Variant
     */
    public function setPrice(float $price): Variant
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku():? string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return Variant
     */
    public function setSku(?string $sku): Variant
    {
        $this->sku = $sku;
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
     * @return Variant
     */
    public function setPosition(int $position): Variant
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getGrams():? int
    {
        return $this->grams;
    }

    /**
     * @param int $grams
     * @return Variant
     */
    public function setGrams(?int $grams): Variant
    {
        $this->grams = $grams;
        return $this;
    }

    /**
     * @return string
     */
    public function getInventoryPolicy():? string
    {
        return $this->inventoryPolicy;
    }

    /**
     * @param string $inventoryPolicy
     * @return Variant
     */
    public function setInventoryPolicy(string $inventoryPolicy): Variant
    {
        $this->inventoryPolicy = $inventoryPolicy;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompareAtPrice():? string
    {
        return $this->compareAtPrice;
    }

    /**
     * @param string $compareAtPrice
     * @return Variant
     */
    public function setCompareAtPrice(?string $compareAtPrice): Variant
    {
        $this->compareAtPrice = $compareAtPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getFulfillmentService():? string
    {
        return $this->fulfillmentService;
    }

    /**
     * @param string $fulfillmentService
     * @return Variant
     */
    public function setFulfillmentService(string $fulfillmentService): Variant
    {
        $this->fulfillmentService = $fulfillmentService;
        return $this;
    }

    /**
     * @return string
     */
    public function getInventoryManagement():? string
    {
        return $this->inventoryManagement;
    }

    /**
     * @param string $inventoryManagement
     * @return Variant
     */
    public function setInventoryManagement(?string $inventoryManagement): Variant
    {
        $this->inventoryManagement = $inventoryManagement;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption1():? string
    {
        return $this->option1;
    }

    /**
     * @param string $option1
     * @return Variant
     */
    public function setOption1(string $option1): Variant
    {
        $this->option1 = $option1;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption2():? string
    {
        return $this->option2;
    }

    /**
     * @param string $option2
     * @return Variant
     */
    public function setOption2(?string $option2): Variant
    {
        $this->option2 = $option2;
        return $this;
    }

    /**
     * @return string
     */
    public function getOption3():? string
    {
        return $this->option3;
    }

    /**
     * @param string $option3
     * @return Variant
     */
    public function setOption3(?string $option3): Variant
    {
        $this->option3 = $option3;
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
     * @return Variant
     */
    public function setCreatedAt(DateTime $createdAt): Variant
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
     * @return Variant
     */
    public function setUpdatedAt(DateTime $updatedAt): Variant
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxable():? bool
    {
        return $this->taxable;
    }

    /**
     * @param bool $taxable
     * @return Variant
     */
    public function setTaxable(bool $taxable): Variant
    {
        $this->taxable = $taxable;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode():? string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     * @return Variant
     */
    public function setBarcode(?string $barcode): Variant
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return int
     */
    public function getImageId():? int
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     * @return Variant
     */
    public function setImageId(?int $imageId): Variant
    {
        $this->imageId = $imageId;
        return $this;
    }

    /**
     * @return int
     */
    public function getInventoryQuantity():? int
    {
        return $this->inventoryQuantity;
    }

    /**
     * @param int $inventoryQuantity
     * @return Variant
     */
    public function setInventoryQuantity(int $inventoryQuantity): Variant
    {
        $this->inventoryQuantity = $inventoryQuantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight():? float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Variant
     */
    public function setWeight(float $weight): Variant
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeightUnit():? string
    {
        return $this->weightUnit;
    }

    /**
     * @param string $weightUnit
     * @return Variant
     */
    public function setWeightUnit(string $weightUnit): Variant
    {
        $this->weightUnit = $weightUnit;
        return $this;
    }

    /**
     * @return int
     */
    public function getOldInventoryQuantity():? int
    {
        return $this->oldInventoryQuantity;
    }

    /**
     * @param int $oldInventoryQuantity
     * @return Variant
     */
    public function setOldInventoryQuantity(int $oldInventoryQuantity): Variant
    {
        $this->oldInventoryQuantity = $oldInventoryQuantity;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequiresShipping():? bool
    {
        return $this->requiresShipping;
    }

    /**
     * @param bool $requiresShipping
     * @return Variant
     */
    public function setRequiresShipping(bool $requiresShipping): Variant
    {
        $this->requiresShipping = $requiresShipping;
        return $this;
    }
}
