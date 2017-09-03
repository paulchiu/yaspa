<?php

namespace Yaspa\AdminApi\ScriptTag;

use GuzzleHttp;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class ScriptTagFactoryProvider
 *
 * @package Yaspa\AdminApi\ScriptTag
 */
class ScriptTagFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            Builders\CountScriptTagsRequest::class => function () {
                return new Builders\CountScriptTagsRequest();
            },
            Builders\CreateNewProductRequest::class => function () use ($factory) {
                return new Builders\CreateNewProductRequest(
                    $factory::make(Transformers\Product::class)
                );
            },
            Builders\DeleteProductRequest::class => function () {
                return new Builders\DeleteProductRequest();
            },
            Builders\GetProductRequest::class => function () {
                return new Builders\GetProductRequest();
            },
            Builders\GetProductsRequest::class => function () {
                return new Builders\GetProductsRequest();
            },
            Builders\ModifyExistingProductRequest::class => function () use ($factory) {
                return new Builders\ModifyExistingProductRequest(
                    $factory::make(Transformers\Product::class),
                    $factory::make(Metafield\Transformers\Metafield::class),
                    $factory::make(ArrayFilters::class)
                );
            },
            Builders\ProductFields::class => function () {
                return new Builders\ProductFields();
            },
            ProductService::class => function () use ($factory) {
                return new ProductService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Product::class),
                    $factory::make(Metafield\Transformers\Metafield::class),
                    $factory::make(Builders\CreateNewProductRequest::class),
                    $factory::make(Builders\GetProductRequest::class),
                    $factory::make(Builders\DeleteProductRequest::class),
                    $factory::make(Metafield\Builders\GetResourceMetafieldsRequest::class),
                    $factory::make(PagedResultsIterator::class)
                );
            },
            Transformers\Product::class => function () use ($factory) {
                return new Transformers\Product(
                    $factory::make(Transformers\Variant::class),
                    $factory::make(Transformers\Image::class),
                    $factory::make(Metafield\Transformers\Metafield::class)
                );
            },
            Transformers\Image::class => function () {
                return new Transformers\Image();
            },
            Transformers\Variant::class => function () {
                return new Transformers\Variant();
            },
        ];
    }
}
