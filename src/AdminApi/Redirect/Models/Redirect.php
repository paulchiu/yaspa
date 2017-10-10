<?php

namespace Yaspa\AdminApi\Redirect\Models;

/**
 * Class Redirect
 *
 * @package Yaspa\AdminApi\Redirect\Models
 * @see https://help.shopify.com/api/reference/redirect#show
 */
class Redirect
{
    /** @var int $id */
    protected $id;
    /** @var string $path */
    protected $path;
    /** @var string $target */
    protected $target;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Redirect
     */
    public function setId(int $id): Redirect
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath():? string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Redirect
     */
    public function setPath(string $path): Redirect
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget():? string
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return Redirect
     */
    public function setTarget(string $target): Redirect
    {
        $this->target = $target;
        return $this;
    }

}
