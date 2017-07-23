<?php

namespace Yaspa;

use GuzzleHttp;
use UnexpectedValueException;
use Yaspa\Authentication;

/**
 * Class Factory
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
            $message = sprintf('Cannot make a new instance of class %s as it is not defined', $className);
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
            GuzzleHttp\Client::class => function () {
                return new GuzzleHttp\Client();
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
            Authentication\OAuth\Service::class => function () {
                return new Authentication\OAuth\Service(
                    self::make(GuzzleHttp\Client::class),
                    self::make(Authentication\OAuth\SecurityChecks::class),
                    self::make(Authentication\OAuth\Transformers\AuthorizationCode::class),
                    self::make(Authentication\OAuth\Transformers\AccessToken::class),
                    self::make(Authentication\OAuth\Builders\NewDelegateAccessTokenRequest::class)
                );
            },
            Authentication\OAuth\SecurityChecks::class => function () {
                return new Authentication\OAuth\SecurityChecks();
            },
            Authentication\OAuth\Transformers\AccessToken::class => function () {
                return new Authentication\OAuth\Transformers\AccessToken(
                    self::make(Authentication\OAuth\Transformers\AssociatedUser::class)
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
        ];
    }
}
