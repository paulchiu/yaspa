<?php

namespace Yaspa\Transformers\Authentication\OAuth;

use Yaspa\Authentication\OAuth\Scopes as ScopesBuilder;

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
     * Generates POST body content for a create new delegate access token request.
     *
     * @see https://help.shopify.com/api/getting-started/authentication/oauth#delegating-access-to-subsystems
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     * @param ScopesBuilder $scopes
     * @return array
     */
    public function toCreateNewDelegateAccessTokenPostBody(ScopesBuilder $scopes): array
    {
        $delegateAccessScopes = array_map(function (string $scope): array {
            return [
                'name' => 'delegate_access_scope[]',
                'contents' => $scope,
            ];
        }, $scopes->getRequested());

        return $delegateAccessScopes;
    }
}
