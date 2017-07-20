<?php

namespace Yaspa\Tests\Unit\OAuth;

use PHPUnit\Framework\TestCase;
use Yaspa\Models\Authentication\OAuth\ConfirmationRedirect;
use Yaspa\Models\Authentication\OAuth\Credentials;
use Yaspa\OAuth\SecurityChecks;

class SecurityChecksTest extends TestCase
{
    public function testCanDetermineNonceIsTheSame()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setState('foo');
        $nonce = 'foo';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertTrue($result);
    }

    public function testCantDetermineUnsetNonceIsTheSame()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $nonce = null;

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertTrue($result);
    }

    public function testCanDetermineEmptyNonceIsTheSame()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $nonce = '';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertTrue($result);
    }

    public function testCantDetermineNonceIsNotTheSame()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setState('foo');
        $nonce = 'bar';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertFalse($result);
    }

    public function testCantDetermineNonceIsNotTheSameWhenRequestNoNonce()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setState('foo');
        $nonce = null;

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertFalse($result);
    }

    public function testCantDetermineNonceIsNotTheSameWhenResponseNoNonce()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $nonce = 'bar';

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->nonceIsSame($confirmation, $nonce);
        $this->assertFalse($result);
    }

    public function testCanClassifyCorrectHostname()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setShop('foo.BAR-3.myshopify.com');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($confirmation);
        $this->assertTrue($result);
    }

    public function testCanInvalidateInvalidCharacterInHostname()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setShop('foo:bar.myshopify.com');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($confirmation);
        $this->assertFalse($result);
    }

    public function testCanInvalidateWrongEnding()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation->setShop('foo.myshopify.co.uk');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hostnameIsValid($confirmation);
        $this->assertFalse($result);
    }

    public function testCanValidateHmac()
    {
        // Create fixtures
        $confirmation = new ConfirmationRedirect();
        $confirmation
            ->setCode('foo')
            ->setShop('bar.myshopify.com')
            ->setState('baz')
            ->setTimestamp('1500366499')
            ->setHmac('9d50babc816b055481484ad40665c5e84d71bcbf6d008a72dcf4b523c391616c');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('qux');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($confirmation, $credentials);
        $this->assertTrue($result);
    }

    public function testCanValidateHmacWithoutState()
    {
        // Create fixtures; this is taken directly from Shopify's example
        $confirmation = new ConfirmationRedirect();
        $confirmation
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('hush');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($confirmation, $credentials);
        $this->assertTrue($result);
    }

    public function testCanInvalidateHmac()
    {
        // Create fixtures; this is taken directly from Shopify's example
        $confirmation = new ConfirmationRedirect();
        $confirmation
            ->setCode('0907a61c0c8d55e99db179b68161bc00')
            ->setShop('some-shop.myshopify.com')
            ->setTimestamp('1337178173')
            ->setHmac('4712bf92ffc2917d15a2f5a273e39f0116667419aa4b6ac0b3baaf26fa3c4d20');

        $credentials = new Credentials();
        $credentials->setApiSecretKey('foo');

        // Test method
        $instance = new SecurityChecks();
        $result = $instance->hmacIsValid($confirmation, $credentials);
        $this->assertFalse($result);
    }
}
