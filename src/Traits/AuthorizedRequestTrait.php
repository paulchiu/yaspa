<?php

namespace Yaspa\Traits;

use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Trait AuthorizedRequestTrait
 *
 * @package Yaspa\Traits
 *
 * Response builders will probably need these properties and immutable setters.
 */
trait AuthorizedRequestTrait
{
    /**
     * Builder properties
     */
    /** @var RequestCredentialsInterface $credentials */
    protected $credentials;

    /**
     * @param RequestCredentialsInterface $credentials
     * @return self
     */
    public function withCredentials(RequestCredentialsInterface $credentials): self
    {
        $new = clone $this;
        $new->credentials = $credentials;

        return $new;
    }
}
