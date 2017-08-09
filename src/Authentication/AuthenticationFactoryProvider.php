<?php

namespace Yaspa\Authentication;

use GuzzleHttp;
use Yaspa\Interfaces\FactoryInterface;
use Yaspa\Interfaces\FactoryProviderInterface;

/**
 * Class AuthenticationFactoryProvider
 *
 * @package Yaspa\Authentication
 */
class AuthenticationFactoryProvider implements FactoryProviderInterface
{
    /**
     * @param FactoryInterface $factory
     * @return array
     */
    public static function makeConstructors(FactoryInterface $factory): array
    {
        return [
            Builders\ApiCredentials::class => function () use ($factory) {
                return new Builders\ApiCredentials(
                    $factory::make(OAuth\Transformers\AccessToken::class),
                    $factory::make(PrivateAuthentication\Transformers\Credentials::class)
                );
            },
            Factory\ApiCredentials::class => function () {
                return new Factory\ApiCredentials();
            },
            OAuth\Builders\AccessTokenRequest::class => function () {
                return new OAuth\Builders\AccessTokenRequest();
            },
            OAuth\Builders\AuthorizePromptUri::class => function () use ($factory) {
                return new OAuth\Builders\AuthorizePromptUri(
                    $factory::make(OAuth\Transformers\Scopes::class)
                );
            },
            OAuth\Builders\NewDelegateAccessTokenRequest::class => function () use ($factory) {
                return new OAuth\Builders\NewDelegateAccessTokenRequest(
                    $factory::make(OAuth\Transformers\AccessToken::class)
                );
            },
            OAuth\Builders\Scopes::class => function () {
                return new OAuth\Builders\Scopes();
            },
            OAuth\SecurityChecks::class => function () {
                return new OAuth\SecurityChecks();
            },
            OAuth\OAuthService::class => function () use ($factory) {
                return new OAuth\OAuthService(
                    $factory::make(GuzzleHttp\Client::class),
                    $factory::make(OAuth\SecurityChecks::class),
                    $factory::make(OAuth\Transformers\AuthorizationCode::class),
                    $factory::make(OAuth\Transformers\AccessToken::class)
                );
            },
            OAuth\Transformers\AccessToken::class => function () use ($factory) {
                return new OAuth\Transformers\AccessToken(
                    $factory::make(OAuth\Transformers\AssociatedUser::class),
                    $factory::make(OAuth\Transformers\Scopes::class)
                );
            },
            OAuth\Transformers\AssociatedUser::class => function () {
                return new OAuth\Transformers\AssociatedUser();
            },
            OAuth\Transformers\AuthorizationCode::class => function () {
                return new OAuth\Transformers\AuthorizationCode();
            },
            OAuth\Transformers\Scopes::class => function () {
                return new OAuth\Transformers\Scopes();
            },
            PrivateAuthentication\Transformers\Credentials::class => function () {
                return new PrivateAuthentication\Transformers\Credentials();
            },
        ];
    }
}
