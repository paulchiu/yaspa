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
 * Models are expected to be created using 'new' as they should have no dependencies.
 */
class Factory
{
    /**
     * @todo Annotate using https://confluence.jetbrains.com/display/PhpStorm/PhpStorm+Advanced+Metadata
     * @param string $className
     * @return mixed
     */
    public static function make(string $className)
    {
        switch ($className) {
            case OAuth\ConfirmInstallation::class:
                return new OAuth\ConfirmInstallation(
                    self::make(OAuth\SecurityChecks::class),
                    self::make(Transformers\Authentication\OAuth\ConfirmationRedirect::class)
                );
            case OAuth\SecurityChecks::class:
                return new OAuth\SecurityChecks();
            case Transformers\Authentication\OAuth\ConfirmationRedirect::class:
                return new Transformers\Authentication\OAuth\ConfirmationRedirect();
            default:
                $message = sprintf('Cannot make a new instance of class: %s', $className);
                throw new UnexpectedValueException($message);
        }
    }
}
