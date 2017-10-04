<?php

namespace Yaspa\AdminApi\ScriptTag\Models;

use DateTime;
use stdClass;

/**
 * Class ScriptTag
 *
 * @package Yaspa\AdminApi\ScriptTag\Models
 * @see https://help.shopify.com/api/reference/scripttag#show
 */
class ScriptTag
{
    /** @var int $id */
    protected $id;
    /** @var string $src */
    protected $src;
    /** @var string $event */
    protected $event;
    /** @var DateTime $createdAt */
    protected $createdAt;
    /** @var DateTime $updatedAt */
    protected $updatedAt;
    /** @var string $displayScope */
    protected $displayScope;

    /**
     * @return int
     */
    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ScriptTag
     */
    public function setId(int $id): ScriptTag
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc():? string
    {
        return $this->src;
    }

    /**
     * @param string $src
     * @return ScriptTag
     */
    public function setSrc(string $src): ScriptTag
    {
        $this->src = $src;
        return $this;
    }

    /**
     * @return string
     */
    public function getEvent():? string
    {
        return $this->event;
    }

    /**
     * @param string $event
     * @return ScriptTag
     */
    public function setEvent(string $event): ScriptTag
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt():? DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return ScriptTag
     */
    public function setCreatedAt(DateTime $createdAt): ScriptTag
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt():? DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return ScriptTag
     */
    public function setUpdatedAt(DateTime $updatedAt): ScriptTag
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayScope():? string
    {
        return $this->displayScope;
    }

    /**
     * @param string $displayScope
     * @return ScriptTag
     */
    public function setDisplayScope(string $displayScope): ScriptTag
    {
        $this->displayScope = $displayScope;
        return $this;
    }
}
