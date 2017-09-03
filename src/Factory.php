<?php

namespace Yaspa;

use GuzzleHttp;
use UnexpectedValueException;
use Yaspa\Interfaces\FactoryInterface;

/**
 * Class Factory
 *
 * @package Yaspa
 *
 * Factory class for all Yaspa service classes.
 *
 * Model instances are expected to be created using 'new' as they should have no dependencies.
 */
class Factory implements FactoryInterface
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
     * @return mixed|void
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
     * Create constructors. Also imports and combines constructors from various factory providers
     * in the project.
     *
     * This is effectively the master service definition list.
     *
     * Remember to annotate in `.phpstorm.meta.php/Factory.meta.php` as well, although it seems
     * largely automated.
     *
     * @return callable[]
     */
    protected static function makeConstructors(): array
    {
        $self = new self();

        /**
         * Constructors that belong to namespaces that do not warrant separate factory providers
         */
        $localConstructors = [
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
            Filters\ArrayFilters::class => function () {
                return new Filters\ArrayFilters();
            },
            Responses\StatusCodes::class => function () {
                return new Responses\StatusCodes();
            },
        ];

        return array_merge(
            $localConstructors,
            AdminApi\Customer\CustomerFactoryProvider::makeConstructors($self),
            AdminApi\Metafield\MetafieldFactoryProvider::makeConstructors($self),
            AdminApi\Product\ProductFactoryProvider::makeConstructors($self),
            AdminApi\Shop\ShopFactoryProvider::makeConstructors($self),
            AdminApi\ScriptTag\ScriptTagFactoryProvider::makeConstructors($self),
            Authentication\AuthenticationFactoryProvider::makeConstructors($self)
        );
    }
}
