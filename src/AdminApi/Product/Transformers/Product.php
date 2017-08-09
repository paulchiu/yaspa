<?php

namespace Yaspa\AdminApi\Product\Transformers;

use DateTime;
use Psr\Http\Message\ResponseInterface;
use Yaspa\AdminApi\Product\Models\Product as ProductModel;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\ArrayResponseTransformerInterface;
use stdClass;

/**
 * Class Product
 *
 * @package Yaspa\AdminApi\Product\Transformers
 * @see https://help.shopify.com/api/reference/product#show
 *
 * Transform Shopify product(s) deeply.
 */
class Product implements ArrayResponseTransformerInterface
{
    /** @var Variant $variantTransformer */
    protected $variantTransformer;
    /** @var Image $imageTransformer */
    protected $imageTransformer;

    /**
     * Product constructor.
     *
     * @param Variant $variantTransformer
     * @param Image $imageTransformer
     */
    public function __construct(Variant $variantTransformer, Image $imageTransformer)
    {
        $this->variantTransformer = $variantTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * @param ResponseInterface $response
     * @return ProductModel
     * @throws MissingExpectedAttributeException
     */
    public function fromResponse(ResponseInterface $response): ProductModel
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'product')) {
            throw new MissingExpectedAttributeException('product');
        }

        return $this->fromShopifyJsonProduct($stdClass->product);
    }

    /**
     * @param ResponseInterface $response
     * @return array|ProductModel[]
     * @throws MissingExpectedAttributeException
     */
    public function fromArrayResponse(ResponseInterface $response): array
    {
        $stdClass = json_decode($response->getBody()->getContents());

        if (!property_exists($stdClass, 'products')) {
            throw new MissingExpectedAttributeException('products');
        }

        return array_map([$this, 'fromShopifyJsonProduct'], $stdClass->products);
    }

    /**
     * @param stdClass $shopifyJsonProduct
     * @return ProductModel
     */
    public function fromShopifyJsonProduct(stdClass $shopifyJsonProduct): ProductModel
    {
        $product = new ProductModel();

        if (property_exists($shopifyJsonProduct, 'id')) {
            $product->setId($shopifyJsonProduct->id);
        }

        if (property_exists($shopifyJsonProduct, 'title')) {
            $product->setTitle($shopifyJsonProduct->title);
        }

        if (property_exists($shopifyJsonProduct, 'body_html')) {
            $product->setBodyHtml($shopifyJsonProduct->body_html);
        }

        if (property_exists($shopifyJsonProduct, 'vendor')) {
            $product->setVendor($shopifyJsonProduct->vendor);
        }

        if (property_exists($shopifyJsonProduct, 'product_type')) {
            $product->setProductType($shopifyJsonProduct->product_type);
        }

        if (property_exists($shopifyJsonProduct, 'created_at')) {
            $createdAt = new DateTime($shopifyJsonProduct->created_at);
            $product->setCreatedAt($createdAt);
        }

        if (property_exists($shopifyJsonProduct, 'handle')) {
            $product->setHandle($shopifyJsonProduct->handle);
        }

        if (property_exists($shopifyJsonProduct, 'updated_at')) {
            $updatedAt = new DateTime($shopifyJsonProduct->updated_at);
            $product->setUpdatedAt($updatedAt);
        }

        if (property_exists($shopifyJsonProduct, 'published_at')) {
            $publishedAt = new DateTime($shopifyJsonProduct->published_at);
            $product->setPublishedAt($publishedAt);
        }

        if (property_exists($shopifyJsonProduct, 'template_suffix')) {
            $product->setTemplateSuffix($shopifyJsonProduct->template_suffix);
        }

        if (property_exists($shopifyJsonProduct, 'published_scope')) {
            $product->setPublishedScope($shopifyJsonProduct->published_scope);
        }

        if (property_exists($shopifyJsonProduct, 'tags')) {
            $tags = explode(',', $shopifyJsonProduct->tags);
            $product->setTags($tags);
        }

        if (property_exists($shopifyJsonProduct, 'variants')) {
            $variants = array_map([$this->variantTransformer, 'fromShopifyJsonVariant'], $shopifyJsonProduct->variants);
            $product->setVariants($variants);
        }

        if (property_exists($shopifyJsonProduct, 'options')) {
            $product->setOptions($shopifyJsonProduct->options);
        }

        if (property_exists($shopifyJsonProduct, 'images')) {
            $images = array_map([$this->imageTransformer, 'fromShopifyJsonImage'], $shopifyJsonProduct->images);
            $product->setImages($images);
        }

        if (property_exists($shopifyJsonProduct, 'image')) {
            $image = $this->imageTransformer->fromShopifyJsonImage($shopifyJsonProduct->image);
            $product->setImage($image);
        }

        return $product;
    }

    /**
     * @param ProductModel $product
     * @return array
     */
    public function toArray(ProductModel $product): array
    {
        $array = [];

        $array['id'] = $product->getId();
        $array['title'] = $product->getTitle();
        $array['body_html'] = $product->getBodyHtml();
        $array['vendor'] = $product->getVendor();
        $array['product_type'] = $product->getProductType();
        $array['created_at'] = $product->getCreatedAt();
        $array['handle'] = $product->getHandle();
        $array['updated_at'] = $product->getUpdatedAt();
        $array['published_at'] = $product->getPublishedAt();
        $array['template_suffix'] = $product->getTemplateSuffix();
        $array['published_scope'] = $product->getPublishedScope();
        $array['tags'] = $product->getTags();
        $array['options'] = $product->getOptions();

        /**
         * Transform typed attributes
         */
        if ($product->getVariants()) {
            $array['variants'] = array_map([$this->variantTransformer, 'toArray'], $product->getVariants());
        }

        if ($product->getImages()) {
            $array['images'] = array_map([$this->imageTransformer, 'toArray'], $product->getImages());
        }

        if ($product->getImage()) {
            $array['image'] = $this->imageTransformer->toArray($product->getImage());
        }

        return $array;
    }
}