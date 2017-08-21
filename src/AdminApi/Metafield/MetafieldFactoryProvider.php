<?php

namespace Yaspa\AdminApi\Metafield;

use GuzzleHttp;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class MetafieldFactoryProvider
 *
 * @package Yaspa\AdminApi\Metafield
 */
class MetafieldFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            Builders\GetMetafieldsRequest::class => function () {
                return new Builders\GetMetafieldsRequest();
            },
            Builders\MetafieldFields::class => function () {
                return new Builders\MetafieldFields();
            },
            MetafieldService::class => function () use ($factory) {
                return new MetafieldService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Metafield::class)
                );
            },
            Transformers\Metafield::class => function () {
                return new Transformers\Metafield();
            },
        ];
    }
}
