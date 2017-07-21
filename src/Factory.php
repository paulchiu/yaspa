<?php

namespace Yaspa;

use GuzzleHttp;
use UnexpectedValueException;
use Yaspa\Authentication;
use Yaspa\Transformers;

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
            Authentication\OAuth\AuthorizePrompt::class => function () {
                return new Authentication\OAuth\AuthorizePrompt(
                    self::make(Transformers\Authentication\OAuth\Scopes::class)
                );
            },
            Authentication\OAuth\ConfirmInstallation::class => function () {
                return new Authentication\OAuth\ConfirmInstallation(
                    self::make(GuzzleHttp\Client::class),
                    self::make(Authentication\OAuth\SecurityChecks::class),
                    self::make(Transformers\Authentication\OAuth\ConfirmationRedirect::class),
                    self::make(Transformers\Authentication\OAuth\AccessToken::class)
                );
            },
            Authentication\OAuth\DelegateAccess::class => function () {
                return new Authentication\OAuth\DelegateAccess(
                    self::make(GuzzleHttp\Client::class),
                    self::make(Transformers\Authentication\OAuth\AccessToken::class),
                    self::make(Transformers\Authentication\OAuth\Scopes::class)
                );
            },
            Authentication\OAuth\Scopes::class => function () {
                return new Authentication\OAuth\Scopes();
            },
            Authentication\OAuth\SecurityChecks::class => function () {
                return new Authentication\OAuth\SecurityChecks();
            },
            Transformers\Authentication\OAuth\AccessToken::class => function () {
                return new Transformers\Authentication\OAuth\AccessToken(
                    self::make(Transformers\Authentication\OAuth\AssociatedUser::class)
                );
            },
            Transformers\Authentication\OAuth\AssociatedUser::class => function () {
                return new Transformers\Authentication\OAuth\AssociatedUser();
            },
            Transformers\Authentication\OAuth\ConfirmationRedirect::class => function () {
                return new Transformers\Authentication\OAuth\ConfirmationRedirect();
            },
            Transformers\Authentication\OAuth\Scopes::class => function () {
                return new Transformers\Authentication\OAuth\Scopes();
            },
        ];
    }
}
