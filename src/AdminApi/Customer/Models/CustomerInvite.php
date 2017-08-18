<?php

namespace Yaspa\AdminApi\Customer\Models;

/**
 * Class CustomerInvite
 *
 * @package Yaspa\AdminApi\Customer\Models
 * @see https://help.shopify.com/api/reference/customer#send_invite
 */
class CustomerInvite
{
    /** @var string $to */
    protected $to;
    /** @var string $from */
    protected $from;
    /** @var array|string[] $bcc */
    protected $bcc;
    /** @var string $subject */
    protected $subject;
    /** @var string $customMessage */
    protected $customMessage;

    /**
     * @return string
     */
    public function getTo():? string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @return CustomerInvite
     */
    public function setTo(string $to): CustomerInvite
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom():? string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return CustomerInvite
     */
    public function setFrom(string $from): CustomerInvite
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getBcc():? array
    {
        return $this->bcc;
    }

    /**
     * @param array|string[] $bcc
     * @return CustomerInvite
     */
    public function setBcc(array $bcc): CustomerInvite
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject():? string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return CustomerInvite
     */
    public function setSubject(string $subject): CustomerInvite
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomMessage():? string
    {
        return $this->customMessage;
    }

    /**
     * @param string $customMessage
     * @return CustomerInvite
     */
    public function setCustomMessage(string $customMessage): CustomerInvite
    {
        $this->customMessage = $customMessage;
        return $this;
    }
}
