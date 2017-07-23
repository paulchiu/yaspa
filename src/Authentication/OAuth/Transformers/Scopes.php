<?php

namespace Yaspa\Authentication\OAuth\Transformers;

use Yaspa\Authentication\OAuth\Builders\Scopes as ScopesBuilder;
use Yaspa\Factory;

/**
 * Class Scopes
 *
 * @package Yaspa\Authentication\OAuth\Transformers
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

    /**
     * Convert scopes from comma separated list. Returned by Shopify when requesting an access token or delegated
     * access token.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
     * @param string $scopesCsv
     * @return ScopesBuilder
     */
    public function fromCommaSeparatedList(string $scopesCsv): ScopesBuilder
    {
        $scopesArray = str_getcsv($scopesCsv);

        return Factory::make(ScopesBuilder::class)
            ->withRequested($scopesArray);
    }
}
