<?php

namespace Yaspa\Transformers\Authentication\OAuth;

use Yaspa\Authentication\OAuth\Scopes as ScopesBuilder;

class Scopes
{
    /**
     * Convert scopes into comma separated list.
     *
     * @param ScopesBuilder $scopes
     * @return string
     */
    public function toCommaSeparatedList(ScopesBuilder $scopes): string
    {
        return implode(',', $scopes->getRequested());
    }
}
