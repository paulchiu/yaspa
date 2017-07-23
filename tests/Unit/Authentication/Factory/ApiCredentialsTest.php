<?php

namespace Yaspa\Tests\Unit\Authentication\Factory;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\Factory\ApiCredentials;
use Yaspa\Factory;
use Yaspa\Interfaces\RequestCredentialsInterface;

class ApiCredentialsTest extends TestCase
{
    public function testCanMakeOAuthCredentials()
    {
        $credentials = Factory::make(ApiCredentials::class)
            ->makeOAuth('foo', 'bar');
        $this->assertInstanceOf(RequestCredentialsInterface::class, $credentials);
    }

    public function testCanMakePrivateCredentials()
    {
        $credentials = Factory::make(ApiCredentials::class)
            ->makePrivate('foo', 'bar', 'baz');
        $this->assertInstanceOf(RequestCredentialsInterface::class, $credentials);
    }
}
