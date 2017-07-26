<?php

namespace Yaspa\Interfaces;

/**
 * Interface PagingRequestBuilderInterface
 *
 * @package Yaspa\Interfaces
 *
 * This is a union interface between PagingBuilderInterface and RequestBuilderInterface.
 *
 * This interface exists purely to get around the inability to type hint multiple interfaces.
 */
interface PagingRequestBuilderInterface extends PagingBuilderInterface, RequestBuilderInterface
{
}
