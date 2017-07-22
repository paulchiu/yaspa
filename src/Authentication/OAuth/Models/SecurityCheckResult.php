<?php

namespace Yaspa\Authentication\OAuth\Models;

use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;

/**
 * Class SecurityCheckResult
 *
 * @package Yaspa\Authentication\OAuth\Models
 * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
 *
 * This is an internal class used to communicate the results of a authorization code security check.
 */
class SecurityCheckResult
{
    const DEFAULT_PASSED_STATE = false;

    /** @var bool $passed */
    protected $passed;
    /** @var FailedSecurityChecksException $failureException */
    protected $failureException;

    /**
     * SecurityCheckResult constructor.
     *
     * @param bool $passed
     */
    public function __construct($passed = self::DEFAULT_PASSED_STATE)
    {
        $this->setPassed($passed);
    }

    /**
     * @return bool
     */
    public function passed():? bool
    {
        return $this->passed;
    }

    /**
     * @param bool $passed
     */
    public function setPassed(bool $passed)
    {
        $this->passed = $passed;
    }

    /**
     * @return FailedSecurityChecksException
     */
    public function getFailureException():? FailedSecurityChecksException
    {
        return $this->failureException;
    }

    /**
     * @param FailedSecurityChecksException $failureException
     */
    public function setFailureException(FailedSecurityChecksException $failureException)
    {
        $this->failureException = $failureException;
    }
}
