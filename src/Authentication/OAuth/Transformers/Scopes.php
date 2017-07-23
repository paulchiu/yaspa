<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Yaspa\Authentication\OAuth\Builder\Scopes as ScopesBuilder;

/**
 * Class Scopes
 *
 * @package Yaspa\Authentication\OAuth\Transformers
 *
 * Transform requested scopes into various representations.
 */
class Scopes
{
    /**
     * Convert scopes into comma separated list. Used by query parameters.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-2-ask-for-permission
     * @param ScopesBuilder $scopes
     * @return string
     */
    public function toCommaSeparatedList(ScopesBuilder $scopes): string
    {
        return implode(',', $scopes->getRequested());
    }
}
