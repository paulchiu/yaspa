<?php

namespace Yaspa\Tests\Unit\OAuth;

use Yaspa\OAuth\AuthorizePrompt;
use PHPUnit\Framework\TestCase;

class AuthorizePromptTest extends TestCase
{
    public function testToUri()
    {
        // Set expectation
        $expectedUri = 'https://bar.myshopify.com/admin/oauth/authorize?client_id=baz&scope=read_content,read_analytics&redirect_uri=http://foo.example.com&state=qux&grant_options[]=per-user';

        // Create and test builder
        $instance = (new AuthorizePrompt('http://foo.example.com'))
            ->withShop('bar')
            ->withApiKey('baz')
            ->withReadContentScope()
            ->withReadContentScope()
            ->withReadAnalyticsScope()
            ->withNonce('qux')
            ->withOnlineAccess();
        $result = urldecode($instance->toUri()->__toString());
        $this->assertEquals($expectedUri, $result);
    }
}
