<?php

namespace Yaspa;

use Yaspa\OAuth;
use Yaspa\Transformers;
use UnexpectedValueException;

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
     * @param string $className
     * @return mixed
     */
    public static function make(string $className)
    {
        if (is_null(self::$constructors)) {
            self::$constructors = self::makeConstructors();
        }

        if (!isset(self::$constructors[$className])) {
            $message = sprintf('Cannot make a new instance of class: %s', $className);
            throw new UnexpectedValueException($message);
        }

        return call_user_func(self::$constructors[$className]);
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
            OAuth\ConfirmInstallation::class => function () {
                return new OAuth\ConfirmInstallation(
                    self::make(OAuth\SecurityChecks::class),
                    self::make(Transformers\Authentication\OAuth\ConfirmationRedirect::class)
                );
            },
            OAuth\SecurityChecks::class => function () {
                return new OAuth\SecurityChecks();
            },
            Transformers\Authentication\OAuth\ConfirmationRedirect::class => function () {
                return new Transformers\Authentication\OAuth\ConfirmationRedirect();
            },
        ];
    }
}
