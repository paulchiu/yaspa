<?php

namespace Yaspa\Tests\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use Yaspa\Authentication\OAuth\Service;
use Yaspa\Factory;

class FactoryTest extends TestCase
{
    public function testCanMakeDependentInstance()
    {
        $instance = Factory::make(Service::class);
        $this->assertInstanceOf(Service::class, $instance);
    }

    public function testWillExceptionIfCannotMake()
    {
        $this->expectException(UnexpectedValueException::class);
        Factory::make('foo');
    }

    public function testCanInjectAndReturnsToNormal()
    {
        // Test before inject
        $instance = Factory::make(Client::class);
        $this->assertInstanceOf(Client::class, $instance);

        // Test after inject
        Factory::inject(Client::class, 'foo');
        $instance = Factory::make(Client::class);
        $this->assertEquals('foo', $instance);

        // Test after injection used
        $instance = Factory::make(Client::class);
        $this->assertInstanceOf(Client::class, $instance);
    }

    public function testCanInjectAndReturnsToNormalWithCallsToLive()
    {
        // Test before inject
        $instance = Factory::make(Client::class);
        $this->assertInstanceOf(Client::class, $instance);

        // Test after inject
        Factory::inject(Client::class, 'foo', 2);
        $instance = Factory::make(Client::class);
        $this->assertEquals('foo', $instance);

        $instance = Factory::make(Client::class);
        $this->assertEquals('foo', $instance);

        // Test after injection used
        $instance = Factory::make(Client::class);
        $this->assertInstanceOf(Client::class, $instance);
    }

    public function testCanInjectUndefinedClass()
    {
        // Test before inject
        try {
            Factory::make('foo');
        } catch (UnexpectedValueException $e) {
            $this->assertInstanceOf(UnexpectedValueException::class, $e);
        }

        // Test after inject
        Factory::inject('foo', 'bar');
        $instance = Factory::make('foo');
        $this->assertEquals('bar', $instance);

        // Test after injection used
        try {
            Factory::make('foo');
        } catch (UnexpectedValueException $e) {
            $this->assertInstanceOf(UnexpectedValueException::class, $e);
        }
    }
}
