<?php

namespace Yaspa\AdminApi\Customer;

use GuzzleHttp;
use Yaspa\AdminApi;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class FactoryProvider
 *
 * @package Yaspa\AdminApi\Customer
 */
class CustomerFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            CustomerService::class => function () use ($factory) {
                return new CustomerService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(Transformers\Customer::class),
                    $factory::make(Transformers\AccountActivationUrl::class),
                    $factory::make(Transformers\CustomerInvite::class),
                    $factory::make(PagedResultsIterator::class),
                    $factory::make(Builders\GetCustomerRequest::class),
                    $factory::make(Builders\CreateAccountActivationUrlRequest::class),
                    $factory::make(Builders\SendAccountInviteRequest::class),
                    $factory::make(Builders\DeleteCustomerRequest::class),
                    $factory::make(Builders\CountAllCustomersRequest::class)
                );
            },
            Builders\CountAllCustomersRequest::class => function () {
                return new Builders\CountAllCustomersRequest();
            },
            Builders\CustomerFields::class => function () {
                return new Builders\CustomerFields();
            },
            Builders\CreateAccountActivationUrlRequest::class => function () {
                return new Builders\CreateAccountActivationUrlRequest();
            },
            Builders\CreateNewCustomerRequest::class => function () use ($factory) {
                return new Builders\CreateNewCustomerRequest(
                    $factory::make(Transformers\Customer::class),
                    $factory::make(AdminApi\Metafield\Transformers\Metafield::class)
                );
            },
            Builders\DeleteCustomerRequest::class => function () {
                return new Builders\DeleteCustomerRequest();
            },
            Builders\GetCustomerRequest::class => function () {
                return new Builders\GetCustomerRequest();
            },
            Builders\GetCustomersRequest::class => function () {
                return new Builders\GetCustomersRequest();
            },
            Builders\ModifyExistingCustomerRequest::class => function () use ($factory) {
                return new Builders\ModifyExistingCustomerRequest(
                    $factory::make(Transformers\Customer::class),
                    $factory::make(AdminApi\Metafield\Transformers\Metafield::class)
                );
            },
            Builders\SearchCustomersRequest::class => function () {
                return new Builders\SearchCustomersRequest();
            },
            Builders\SendAccountInviteRequest::class => function () use ($factory) {
                return new Builders\SendAccountInviteRequest(
                    $factory::make(Transformers\CustomerInvite::class)
                );
            },
            Transformers\AccountActivationUrl::class => function () {
                return new Transformers\AccountActivationUrl();
            },
            Transformers\Address::class => function () {
                return new Transformers\Address();
            },
            Transformers\Customer::class => function () use ($factory) {
                return new Transformers\Customer(
                    $factory::make(Transformers\Address::class)
                );
            },
            Transformers\CustomerInvite::class => function () {
                return new Transformers\CustomerInvite();
            },
        ];
    }
}
