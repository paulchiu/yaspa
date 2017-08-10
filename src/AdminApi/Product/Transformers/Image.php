<?php

namespace Yaspa\AdminApi\Product\Transformers;

use DateTime;
use Yaspa\AdminApi\Product\Models\Image as ImageModel;
use stdClass;

/**
 * Class Image
 *
 * @package Yaspa\AdminApi\Product\Transformers
 * @see https://help.shopify.com/api/reference/product#show
 *
 * Transform the image attribute of a product.
 */
class Image
{
    /**
     * @param stdClass $shopifyJsonImage
     * @return ImageModel
     */
    public function fromShopifyJsonImage(stdClass $shopifyJsonImage): ImageModel
    {
        $image = new ImageModel();

        if (property_exists($shopifyJsonImage, 'id')) {
            $image->setId($shopifyJsonImage->id);
        }

        if (property_exists($shopifyJsonImage, 'product_id')) {
            $image->setProductId($shopifyJsonImage->product_id);
        }

        if (property_exists($shopifyJsonImage, 'position')) {
            $image->setPosition($shopifyJsonImage->position);
        }

        if (property_exists($shopifyJsonImage, 'created_at')
            && !empty($shopifyJsonImage->created_at)
        ) {
            $createdAt = new DateTime($shopifyJsonImage->created_at);
            $image->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonImage, 'updated_at')
            && !empty($shopifyJsonImage->updated_at)
        ) {
            $updatedAt = new DateTime($shopifyJsonImage->updated_at);
            $image->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonImage, 'width')) {
            $image->setWidth($shopifyJsonImage->width);
        }

        if (property_exists($shopifyJsonImage, 'height')) {
            $image->setHeight($shopifyJsonImage->height);
        }

        if (property_exists($shopifyJsonImage, 'src')) {
            $image->setSrc($shopifyJsonImage->src);
        }

        if (property_exists($shopifyJsonImage, 'variant_ids')) {
            $image->setVariantIds($shopifyJsonImage->variant_ids);
        }

        return $image;
    }

    /**
     * @param ImageModel $image
     * @return array
     */
    public function toArray(ImageModel $image): array
    {
        $array = [];

        $array['id'] = $image->getId();
        $array['product_id'] = $image->getProductId();
        $array['position'] = $image->getPosition();
        $array['created_at'] = ($image->getCreatedAt()) ? $image->getCreatedAt()->format(DateTime::ISO8601) : null;
        $array['updated_at'] = ($image->getUpdatedAt()) ? $image->getUpdatedAt()->format(DateTime::ISO8601) : null;
        $array['width'] = $image->getWidth();
        $array['height'] = $image->getHeight();
        $array['src'] = $image->getSrc();
        $array['variant_ids'] = $image->getVariantIds();

        if ($image->getAttachment()) {
            $array['attachment'] = $image->getAttachment();
        }

        return $array;
    }
}
