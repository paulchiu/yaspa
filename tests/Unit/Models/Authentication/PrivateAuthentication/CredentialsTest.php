<?php

namespace Yaspa\Tests\Unit\Models\Authentication\PrivateAuthentication;

use PHPUnit\Framework\TestCase;
use Yaspa\Models\Authentication\PrivateAuthentication\Credentials;

class CredentialsTest extends TestCase
{
    public function testCanRetrieveUnsetCredential()
    {
        $credentials = new Credentials();
        $this->assertNull($credentials->getApiKey());
    }

    public function testCanRetrieveCredential()
    {
        $credentials = new Credentials();
        $credentials
            ->setApiKey('foo')
            ->setPassword('bar');
        $this->assertNotEmpty($credentials->getApiKey());
        $this->assertNotEmpty($credentials->getPassword());
    }
}
