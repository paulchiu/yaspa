<?php

namespace Yaspa\AdminApi\Redirect;

use GuzzleHttp;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Filters\ArrayFilters;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class RedirectFactoryProvider
 *
 * @package Yaspa\AdminApi\Redirect
 */
class RedirectFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            Builders\CountAllRedirectsRequest::class => function () {
                return new Builders\CountAllRedirectsRequest();
            },
            Builders\CreateNewRedirectRequest::class => function () use ($factory) {
                return new Builders\CreateNewRedirectRequest(
                    $factory::make(Transformers\Redirect::class)
                );
            },
            Builders\DeleteRedirectRequest::class => function () {
                return new Builders\DeleteRedirectRequest();
            },
            Builders\GetRedirectRequest::class => function () {
                return new Builders\GetRedirectRequest();
            },
            Builders\GetRedirectsRequest::class => function () {
                return new Builders\GetRedirectsRequest();
            },
            Builders\ModifyExistingRedirectRequest::class => function () use ($factory) {
                return new Builders\ModifyExistingRedirectRequest(
                    $factory::make(Transformers\Redirect::class),
                    $factory::make(ArrayFilters::class)
                );
            },
            Builders\RedirectFields::class => function () {
                return new Builders\RedirectFields();
            },
            RedirectService::class => function () use ($factory) {
                return new RedirectService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Redirect::class),
                    $factory::make(Builders\CreateNewRedirectRequest::class),
                    $factory::make(Builders\GetRedirectRequest::class),
                    $factory::make(Builders\DeleteRedirectRequest::class),
                    $factory::make(PagedResultsIterator::class)
                );
            },
            Transformers\Redirect::class => function () use ($factory) {
                return new Transformers\Redirect();
            },
        ];
    }
}
