<?php

namespace Yaspa\Tests\Unit\Authentication\OAuth;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\OAuth\AuthorizePrompt;
use Yaspa\Authentication\OAuth\Scopes;
use Yaspa\Factory;

class AuthorizePromptTest extends TestCase
{
    public function testToUri()
    {
        // Set expectation
        $expectedUri = 'https://bar.myshopify.com/admin/oauth/authorize?client_id=baz&scope=read_content,read_analytics&redirect_uri=http://foo.example.com&state=qux&grant_options[]=per-user';

        // Create and test builder
        $scopes = Factory::make(Scopes::class)
            ->withReadContent()
            ->withReadContent()
            ->withReadAnalytics();

        $instance = (new AuthorizePrompt('http://foo.example.com'))
            ->withShop('bar')
            ->withApiKey('baz')
            ->withNonce('qux')
            ->withScopes($scopes)
            ->withOnlineAccess();
        $result = urldecode($instance->toUri()->__toString());
        $this->assertEquals($expectedUri, $result);
    }
}
