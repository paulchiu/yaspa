<?php

namespace Yaspa\Interfaces;

/**
 * Interface PagingRequestBuilderInterface
 *
 * @package Yaspa\Interfaces
 *
 * This interface describes a builder class that's page aware.
 */
interface PagingBuilderInterface
{
    /**
     * The current page set in the builder
     *
     * @return int
     */
    public function getPage():? int;

    /**
     * Set the page the builder is on.
     *
     * Ideally the interface should specify that the method needs to return the
     * implementing class, but there is no obvious way to do this at the time of writing.
     *
     * @param int $page
     * @return self
     */
    public function withPage(int $page);
}
