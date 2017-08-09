<?php

namespace Yaspa\AdminApi\Shop;

use GuzzleHttp;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class ShopFactoryProvider
 *
 * @package Yaspa\AdminApi\Shop
 */
class ShopFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            ShopService::class => function () use ($factory) {
                return new ShopService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Builders\GetShopRequest::class),
                    $factory::make(Transformers\Shop::class)
                );
            },
            Transformers\Shop::class => function () {
                return new Transformers\Shop();
            },
            Builders\GetShopRequest::class => function () {
                return new Builders\GetShopRequest();
            },
        ];
    }
}
