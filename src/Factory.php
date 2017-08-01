<?php

namespace Yaspa;

use GuzzleHttp;
use UnexpectedValueException;
use Yaspa\AdminApi;
use Yaspa\Authentication;

/**
 * Class Factory
 *
 * @package Yaspa
 *
 * Factory class for all Yaspa service classes.
 *
 * Model instances are expected to be created using 'new' as they should have no dependencies.
 */
class Factory
{
    /** @var callable[] $constructors */
    protected static $constructors;

    /**
     * Make a instance of a service class.
     *
     * @param string $className
     * @return mixed
     * @throws UnexpectedValueException When a service class constructor hasn't been defined
     */
    public static function make(string $className)
    {
        // Constructors is a singleton array
        if (is_null(self::$constructors)) {
            self::$constructors = self::makeConstructors();
        }

        // If we don't know how to create a given class, throw exception
        if (!isset(self::$constructors[$className])) {
            $message = sprintf('Cannot make a new instance of class %s as it is not defined in %s', $className, __CLASS__);
            throw new UnexpectedValueException($message);
        }

        // Otherwise, create an instance of the requested class
        return call_user_func(self::$constructors[$className]);
    }

    /**
     * Inject a replacement value for a given class name constructor. Used for testing.
     *
     * @param string $className
     * @param mixed $replacement
     * @param int $callsToLive The number of makes the replacement should be used for
     */
    public static function inject(string $className, $replacement, int $callsToLive = 1)
    {
        // Constructors is a singleton array
        if (is_null(self::$constructors)) {
            self::$constructors = self::makeConstructors();
        }

        // Constructor replacement
        $original = self::$constructors[$className] ?? null;
        self::$constructors[$className] = function () use ($className, $original, $replacement, $callsToLive) {
            // Re-inject original constructor
            self::$constructors[$className] = $original;

            // If we still have more calls to go, re-inject
            if ($callsToLive > 1) {
                self::inject($className, $replacement, $callsToLive - 1);
            }

            return $replacement;
        };
    }

    /**
     * Create constructors.
     *
     * This is effectively the master service definition list.
     *
     * Remember to annotate in `.phpstorm.meta.php/Factory.meta.php` as well.
     *
     * @return callable[]
     */
    protected static function makeConstructors(): array
    {
        return [
            /**
             * External library constructors
             */
            GuzzleHttp\Client::class => function () {
                return new GuzzleHttp\Client();
            },

            /**
             * Yaspa constructors
             */
            Builders\PagedResultsIterator::class => function () {
                return new Builders\PagedResultsIterator(
                    self::make(GuzzleHttp\Client::class)
                );
            },
            AdminApi\Customer\CustomerService::class => function () {
                return new AdminApi\Customer\CustomerService(
                    self::make(GuzzleHttp\Client::class),
                    self::make(AdminApi\Customer\Transformers\Customer::class),
                    self::make(AdminApi\Customer\Transformers\AccountActivationUrl::class),
                    self::make(AdminApi\Customer\Transformers\CustomerInvite::class),
                    self::make(Builders\PagedResultsIterator::class),
                    self::make(AdminApi\Customer\Builders\GetCustomerRequest::class),
                    self::make(AdminApi\Customer\Builders\CreateAccountActivationUrlRequest::class),
                    self::make(AdminApi\Customer\Builders\SendAccountInviteRequest::class),
                    self::make(AdminApi\Customer\Builders\DeleteCustomerRequest::class)
                );
            },
            AdminApi\Customer\Builders\CustomerFields::class => function () {
                return new AdminApi\Customer\Builders\CustomerFields();
            },
            AdminApi\Customer\Builders\CreateAccountActivationUrlRequest::class => function () {
                return new AdminApi\Customer\Builders\CreateAccountActivationUrlRequest();
            },
            AdminApi\Customer\Builders\CreateNewCustomerRequest::class => function () {
                return new AdminApi\Customer\Builders\CreateNewCustomerRequest(
                    self::make(AdminApi\Customer\Transformers\Customer::class),
                    self::make(AdminApi\Metafield\Transformers\Metafield::class)
                );
            },
            AdminApi\Customer\Builders\DeleteCustomerRequest::class => function () {
                return new AdminApi\Customer\Builders\DeleteCustomerRequest();
            },
            AdminApi\Customer\Builders\GetCustomerRequest::class => function () {
                return new AdminApi\Customer\Builders\GetCustomerRequest();
            },
            AdminApi\Customer\Builders\GetCustomersRequest::class => function () {
                return new AdminApi\Customer\Builders\GetCustomersRequest();
            },
            AdminApi\Customer\Builders\ModifyExistingCustomerRequest::class => function () {
                return new AdminApi\Customer\Builders\ModifyExistingCustomerRequest(
                    self::make(AdminApi\Customer\Transformers\Customer::class),
                    self::make(AdminApi\Metafield\Transformers\Metafield::class)
                );
            },
            AdminApi\Customer\Builders\SearchCustomersRequest::class => function () {
                return new AdminApi\Customer\Builders\SearchCustomersRequest();
            },
            AdminApi\Customer\Builders\SendAccountInviteRequest::class => function () {
                return new AdminApi\Customer\Builders\SendAccountInviteRequest(
                    self::make(AdminApi\Customer\Transformers\CustomerInvite::class)
                );
            },
            AdminApi\Customer\Transformers\AccountActivationUrl::class => function () {
                return new AdminApi\Customer\Transformers\AccountActivationUrl();
            },
            AdminApi\Customer\Transformers\Address::class => function () {
                return new AdminApi\Customer\Transformers\Address();
            },
            AdminApi\Customer\Transformers\Customer::class => function () {
                return new AdminApi\Customer\Transformers\Customer(
                    self::make(AdminApi\Customer\Transformers\Address::class)
                );
            },
            AdminApi\Customer\Transformers\CustomerInvite::class => function () {
                return new AdminApi\Customer\Transformers\CustomerInvite();
            },
            AdminApi\Metafield\Transformers\Metafield::class => function () {
                return new AdminApi\Metafield\Transformers\Metafield();
            },
            AdminApi\Shop\ShopService::class => function () {
                return new AdminApi\Shop\ShopService(
                    self::make(GuzzleHttp\Client::class),
                    self::make(AdminApi\Shop\Builders\GetShopRequest::class),
                    self::make(AdminApi\Shop\Transformers\Shop::class)
                );
            },
            AdminApi\Shop\Transformers\Shop::class => function () {
                return new AdminApi\Shop\Transformers\Shop();
            },
            AdminApi\Shop\Builders\GetShopRequest::class => function () {
                return new AdminApi\Shop\Builders\GetShopRequest();
            },
            Authentication\Builders\ApiCredentials::class => function () {
                return new Authentication\Builders\ApiCredentials(
                    self::make(Authentication\OAuth\Transformers\AccessToken::class),
                    self::make(Authentication\PrivateAuthentication\Transformers\Credentials::class)
                );
            },
            Authentication\Factory\ApiCredentials::class => function () {
                return new Authentication\Factory\ApiCredentials();
            },
            Authentication\OAuth\Builders\AccessTokenRequest::class => function () {
                return new Authentication\OAuth\Builders\AccessTokenRequest();
            },
            Authentication\OAuth\Builders\AuthorizePromptUri::class => function () {
                return new Authentication\OAuth\Builders\AuthorizePromptUri(
                    self::make(Authentication\OAuth\Transformers\Scopes::class)
                );
            },
            Authentication\OAuth\Builders\NewDelegateAccessTokenRequest::class => function () {
                return new Authentication\OAuth\Builders\NewDelegateAccessTokenRequest(
                    self::make(Authentication\OAuth\Transformers\AccessToken::class)
                );
            },
            Authentication\OAuth\Builders\Scopes::class => function () {
                return new Authentication\OAuth\Builders\Scopes();
            },
            Authentication\OAuth\SecurityChecks::class => function () {
                return new Authentication\OAuth\SecurityChecks();
            },
            Authentication\OAuth\OAuthService::class => function () {
                return new Authentication\OAuth\OAuthService(
                    self::make(GuzzleHttp\Client::class),
                    self::make(Authentication\OAuth\SecurityChecks::class),
                    self::make(Authentication\OAuth\Transformers\AuthorizationCode::class),
                    self::make(Authentication\OAuth\Transformers\AccessToken::class)
                );
            },
            Authentication\OAuth\Transformers\AccessToken::class => function () {
                return new Authentication\OAuth\Transformers\AccessToken(
                    self::make(Authentication\OAuth\Transformers\AssociatedUser::class),
                    self::make(Authentication\OAuth\Transformers\Scopes::class)
                );
            },
            Authentication\OAuth\Transformers\AssociatedUser::class => function () {
                return new Authentication\OAuth\Transformers\AssociatedUser();
            },
            Authentication\OAuth\Transformers\AuthorizationCode::class => function () {
                return new Authentication\OAuth\Transformers\AuthorizationCode();
            },
            Authentication\OAuth\Transformers\Scopes::class => function () {
                return new Authentication\OAuth\Transformers\Scopes();
            },
            Authentication\PrivateAuthentication\Transformers\Credentials::class => function () {
                return new Authentication\PrivateAuthentication\Transformers\Credentials();
            },
        ];
    }
}
