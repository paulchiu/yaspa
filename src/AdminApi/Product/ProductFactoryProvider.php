<?php

namespace Yaspa\AdminApi\Product;

use GuzzleHttp;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class ProductFactoryProvider
 *
 * @package Yaspa\AdminApi\Product
 */
class ProductFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            Builders\CreateNewProductRequest::class => function () use ($factory) {
                return new Builders\CreateNewProductRequest(
                    $factory::make(Transformers\Product::class)
                );
            },
            ProductService::class => function () use ($factory) {
                return new ProductService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Product::class),
                    $factory::make(Builders\CreateNewProductRequest::class)
                );
            },
            Transformers\Product::class => function () use ($factory) {
                return new Transformers\Product(
                    $factory::make(Transformers\Variant::class),
                    $factory::make(Transformers\Image::class)
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
