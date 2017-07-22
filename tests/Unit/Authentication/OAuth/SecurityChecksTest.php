<?php

namespace Yaspa\Tests\Unit\Authentication\OAuth;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\OAuth\Exceptions\FailedSecurityChecksException;
use Yaspa\Authentication\OAuth\SecurityChecks;
use Yaspa\Authentication\OAuth\Models\AuthorizationCode;
use Yaspa\Authentication\OAuth\Models\Credentials;

class SecurityChecksTest extends TestCase
{
    public function testCanCheckPassingAuthorizationCode()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('foo')
            ->setShop('bar.myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('9d50babc816b055481484ad40665c5e84d71bcbf6d008a72dcf4b523c391616c');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        $nonce = 'baz';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->checkAuthorizationCode($authorizationCode, $credentials, $nonce);
        $this->assertTrue($result->passed());
        $this->assertEmpty($result->getFailureException());
    }

    public function testCanFailAuthorizationCodeOnBadNonce()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('foo')
            ->setShop('bar.myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('9d50babc816b055481484ad40665c5e84d71bcbf6d008a72dcf4b523c391616c');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        $nonce = 'not-baz';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->checkAuthorizationCode($authorizationCode, $credentials, $nonce);
        $this->assertFalse($result->passed());
        $this->assertInstanceOf(FailedSecurityChecksException::class, $result->getFailureException());
    }

    public function testCanFailAuthorizationCodeOnInvalidHostname()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('foo')
            ->setShop('bar.not-myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('9d50babc816b055481484ad40665c5e84d71bcbf6d008a72dcf4b523c391616c');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        $nonce = 'baz';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->checkAuthorizationCode($authorizationCode, $credentials, $nonce);
        $this->assertFalse($result->passed());
        $this->assertInstanceOf(FailedSecurityChecksException::class, $result->getFailureException());
    }

    public function testCanFailAuthorizationCodeOnInvalidHmac()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('foo')
            ->setShop('bar.myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('invalid-hmac');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        $nonce = 'baz';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->checkAuthorizationCode($authorizationCode, $credentials, $nonce);
        $this->assertFalse($result->passed());
        $this->assertInstanceOf(FailedSecurityChecksException::class, $result->getFailureException());
    }

    public function testCanDetermineNonceIsTheSame()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setState('foo');
        $nonce = 'foo';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertTrue($result);
    }

    public function testCantDetermineUnsetNonceIsTheSame()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $nonce = null;

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertTrue($result);
    }

    public function testCanDetermineEmptyNonceIsTheSame()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $nonce = '';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertTrue($result);
    }

    public function testCantDetermineNonceIsNotTheSame()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setState('foo');
        $nonce = 'bar';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertFalse($result);
    }

    public function testCantDetermineNonceIsNotTheSameWhenRequestNoNonce()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setState('foo');
        $nonce = null;

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertFalse($result);
    }

    public function testCantDetermineNonceIsNotTheSameWhenResponseNoNonce()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $nonce = 'bar';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($authorizationCode, $nonce);
        $this->assertFalse($result);
    }

    public function testCanClassifyCorrectHostname()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setShop('foo.BAR-3.myshopify.com');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($authorizationCode);
        $this->assertTrue($result);
    }

    public function testCanInvalidateInvalidCharacterInHostname()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setShop('foo:bar.myshopify.com');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($authorizationCode);
        $this->assertFalse($result);
    }

    public function testCanInvalidateWrongEnding()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode->setShop('foo.myshopify.co.uk');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($authorizationCode);
        $this->assertFalse($result);
    }

    public function testCanValidateHmac()
    {
        // Create fixtures
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('foo')
            ->setShop('bar.myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('9d50babc816b055481484ad40665c5e84d71bcbf6d008a72dcf4b523c391616c');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($authorizationCode, $credentials);
        $this->assertTrue($result);
    }

    public function testCanValidateHmacWithoutState()
    {
        // Create fixtures; this is taken directly from Shopify's example
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('hush');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($authorizationCode, $credentials);
        $this->assertTrue($result);
    }

    public function testCanInvalidateHmac()
    {
        // Create fixtures; this is taken directly from Shopify's example
        $authorizationCode = new AuthorizationCode();
        $authorizationCode
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('foo');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($authorizationCode, $credentials);
        $this->assertFalse($result);
    }
}
