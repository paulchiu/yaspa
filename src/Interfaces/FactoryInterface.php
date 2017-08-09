<?php

namespace Yaspa\Interfaces;

/**
 * Interface FactoryInterface
 *
 * @package Yaspa\Interfaces
 */
interface FactoryInterface
{
    /**
     * @param string $className
     * @return mixed
     */
    public static function make(string $className);

    /**
     * @param string $className
     * @param $replacement
     * @param int $callsToLive
     * @return mixed
     */
    public static function inject(string $className, $replacement, int $callsToLive = 1);
}
