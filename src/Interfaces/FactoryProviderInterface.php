<?php

namespace Yaspa\Interfaces;

/**
 * Interface FactoryProviderInterface
 *
 * @package Yaspa\Interfaces
 */
interface FactoryProviderInterface
{
    /**
     * Returns an array of constructors with a class name as the key.
     *
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array;
}
