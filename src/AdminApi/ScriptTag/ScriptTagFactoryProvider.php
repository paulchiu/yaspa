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
            Builders\CreateNewScriptTagRequest::class => function () use ($factory) {
                return new Builders\CreateNewScriptTagRequest(
                    $factory::make(Transformers\ScriptTag::class)
                );
            },
            Builders\DeleteScriptTagRequest::class => function () {
                return new Builders\DeleteScriptTagRequest();
            },
            Builders\GetScriptTagRequest::class => function () {
                return new Builders\GetScriptTagRequest();
            },
            Builders\GetScriptTagsRequest::class => function () {
                return new Builders\GetScriptTagsRequest();
            },
            Builders\ModifyExistingScriptTagRequest::class => function () use ($factory) {
                return new Builders\ModifyExistingScriptTagRequest(
                    $factory::make(Transformers\ScriptTag::class),
                    $factory::make(ArrayFilters::class)
                );
            },
            Builders\ScriptTagFields::class => function () {
                return new Builders\ScriptTagFields();
            },
            ScriptTagService::class => function () use ($factory) {
                return new ScriptTagService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\ScriptTag::class),
                    $factory::make(Builders\CountScriptTagsRequest::class),
                    $factory::make(Builders\CreateNewScriptTagRequest::class),
                    $factory::make(Builders\DeleteScriptTagRequest::class),
                    $factory::make(Builders\GetScriptTagRequest::class),
                    $factory::make(Builders\GetScriptTagsRequest::class),
                    $factory::make(Builders\ModifyExistingScriptTagRequest::class),
                    $factory::make(PagedResultsIterator::class)
                );
            },
            Transformers\ScriptTag::class => function () use ($factory) {
                return new Transformers\ScriptTag();
            },
        ];
    }
}
