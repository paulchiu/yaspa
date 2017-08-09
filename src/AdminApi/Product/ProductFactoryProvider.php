<?php

namespace Yaspa\AdminApi\Product;

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
            Transformers\Product::class => function () use ($factory) {
                return new Transformers\Product(
                    $factory::make(Transformers\Image::class),
                    $factory::make(Transformers\Variant::class)
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
