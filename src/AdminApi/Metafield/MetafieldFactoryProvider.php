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
            Builders\CreateNewMetafieldRequest::class => function () use ($factory) {
                return new Builders\CreateNewMetafieldRequest(
                    $factory::make(Transformers\Metafield::class)
                );
            },
            Builders\CreateNewResourceMetafieldRequest::class => function () use ($factory) {
                return new Builders\CreateNewResourceMetafieldRequest(
                    $factory::make(Transformers\Metafield::class)
                );
            },
            Builders\DeleteMetafieldRequest::class => function () {
                return new Builders\DeleteMetafieldRequest();
            },
            Builders\DeleteResourceMetafieldRequest::class => function () {
                return new Builders\DeleteResourceMetafieldRequest();
            },
            Builders\GetMetafieldRequest::class => function () {
                return new Builders\GetMetafieldRequest();
            },
            Builders\GetMetafieldsRequest::class => function () {
                return new Builders\GetMetafieldsRequest();
            },
            Builders\GetResourceMetafieldsRequest::class => function () {
                return new Builders\GetResourceMetafieldsRequest();
            },
            Builders\MetafieldFields::class => function () {
                return new Builders\MetafieldFields();
            },
            Builders\UpdateMetafieldRequest::class => function () use ($factory) {
                return new Builders\UpdateMetafieldRequest(
                    $factory::make(Transformers\Metafield::class)
                );
            },
            Builders\UpdateResourceMetafieldRequest::class => function () use ($factory) {
                return new Builders\UpdateResourceMetafieldRequest(
                    $factory::make(Transformers\Metafield::class)
                );
            },
            MetafieldService::class => function () use ($factory) {
                return new MetafieldService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Metafield::class),
                    $factory::make(Builders\CreateNewMetafieldRequest::class),
                    $factory::make(Builders\GetMetafieldRequest::class),
                    $factory::make(Builders\UpdateMetafieldRequest::class),
                    $factory::make(Builders\DeleteMetafieldRequest::class)
                );
            },
            Transformers\Metafield::class => function () {
                return new Transformers\Metafield();
            },
        ];
    }
}
