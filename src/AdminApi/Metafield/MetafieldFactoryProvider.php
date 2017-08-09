<?php

namespace Yaspa\AdminApi\Metafield;

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
            Transformers\Metafield::class => function () {
                return new Transformers\Metafield();
            },
        ];
    }
}
