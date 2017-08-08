<?php

namespace Yaspa\AdminApi\Product\Transformers;

use DateTime;
use Yaspa\AdminApi\Product\Models\Variant as VariantModel;
use stdClass;

/**
 * Class Variant
 *
 * @package Yaspa\AdminApi\Product\Transformers
 * @see https://help.shopify.com/api/reference/product#show
 *
 * Transform the variant attribute of a product.
 */
class Variant
{
    /**
     * @param stdClass $shopifyJsonVariant
     * @return VariantModel
     */
    public function fromShopifyJsonVariant(stdClass $shopifyJsonVariant): VariantModel
    {
        $variant = new VariantModel();

        if (property_exists($shopifyJsonVariant, 'id')) {
            $variant->setId($shopifyJsonVariant->id);
        }

        if (property_exists($shopifyJsonVariant, 'product_id')) {
            $variant->setProductId($shopifyJsonVariant->product_id);
        }

        if (property_exists($shopifyJsonVariant, 'title')) {
            $variant->setTitle($shopifyJsonVariant->title);
        }

        if (property_exists($shopifyJsonVariant, 'price')) {
            $variant->setPrice($shopifyJsonVariant->price);
        }

        if (property_exists($shopifyJsonVariant, 'sku')) {
            $variant->setSku($shopifyJsonVariant->sku);
        }

        if (property_exists($shopifyJsonVariant, 'position')) {
            $variant->setPosition($shopifyJsonVariant->position);
        }

        if (property_exists($shopifyJsonVariant, 'grams')) {
            $variant->setGrams($shopifyJsonVariant->grams);
        }

        if (property_exists($shopifyJsonVariant, 'inventory_policy')) {
            $variant->setInventoryPolicy($shopifyJsonVariant->inventory_policy);
        }

        if (property_exists($shopifyJsonVariant, 'compare_at_price')) {
            $variant->setCompareAtPrice($shopifyJsonVariant->compare_at_price);
        }

        if (property_exists($shopifyJsonVariant, 'fulfillment_service')) {
            $variant->setFulfillmentService($shopifyJsonVariant->fulfillment_service);
        }

        if (property_exists($shopifyJsonVariant, 'inventory_management')) {
            $variant->setInventoryManagement($shopifyJsonVariant->inventory_management);
        }

        if (property_exists($shopifyJsonVariant, 'option1')) {
            $variant->setOption1($shopifyJsonVariant->option1);
        }

        if (property_exists($shopifyJsonVariant, 'option2')) {
            $variant->setOption2($shopifyJsonVariant->option2);
        }

        if (property_exists($shopifyJsonVariant, 'option3')) {
            $variant->setOption3($shopifyJsonVariant->option3);
        }

        if (property_exists($shopifyJsonVariant, 'created_at')) {
            $createdAt = new DateTime($shopifyJsonVariant->created_at);
            $variant->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonVariant, 'updated_at')) {
            $updatedAt = new DateTime($shopifyJsonVariant->updated_at);
            $variant->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonVariant, 'taxable')) {
            $variant->setTaxable($shopifyJsonVariant->taxable);
        }

        if (property_exists($shopifyJsonVariant, 'barcode')) {
            $variant->setBarcode($shopifyJsonVariant->barcode);
        }

        if (property_exists($shopifyJsonVariant, 'image_id')) {
            $variant->setImageId($shopifyJsonVariant->image_id);
        }

        if (property_exists($shopifyJsonVariant, 'inventory_quantity')) {
            $variant->setInventoryQuantity($shopifyJsonVariant->inventory_quantity);
        }

        if (property_exists($shopifyJsonVariant, 'weight')) {
            $variant->setWeight($shopifyJsonVariant->weight);
        }

        if (property_exists($shopifyJsonVariant, 'weight_unit')) {
            $variant->setWeightUnit($shopifyJsonVariant->weight_unit);
        }

        if (property_exists($shopifyJsonVariant, 'old_inventory_quantity')) {
            $variant->setOldInventoryQuantity($shopifyJsonVariant->old_inventory_quantity);
        }

        if (property_exists($shopifyJsonVariant, 'requires_shipping')) {
            $variant->setRequiresShipping($shopifyJsonVariant->requires_shipping);
        }

        return $variant;
    }

    /**
     * @param VariantModel $variant
     * @return array
     */
    public function toArray(VariantModel $variant): array
    {
        $array = [];

        $array['id'] = $variant->getId();
        $array['product_id'] = $variant->getProductId();
        $array['title'] = $variant->getTitle();
        $array['price'] = $variant->getPrice();
        $array['sku'] = $variant->getSku();
        $array['position'] = $variant->getPosition();
        $array['grams'] = $variant->getGrams();
        $array['inventory_policy'] = $variant->getInventoryPolicy();
        $array['compare_at_price'] = $variant->getCompareAtPrice();
        $array['fulfillment_service'] = $variant->getFulfillmentService();
        $array['inventory_management'] = $variant->getInventoryManagement();
        $array['option1'] = $variant->getOption1();
        $array['option2'] = $variant->getOption2();
        $array['option3'] = $variant->getOption3();
        $array['created_at'] = $variant->getCreatedAt();
        $array['updated_at'] = $variant->getUpdatedAt();
        $array['taxable'] = $variant->isTaxable();
        $array['barcode'] = $variant->getBarcode();
        $array['image_id'] = $variant->getImageId();
        $array['inventory_quantity'] = $variant->getInventoryQuantity();
        $array['weight'] = $variant->getWeight();
        $array['weight_unit'] = $variant->getWeightUnit();
        $array['old_inventory_quantity'] = $variant->getOldInventoryQuantity();
        $array['requires_shipping'] = $variant->isRequiresShipping();

        return $array;
    }
}
