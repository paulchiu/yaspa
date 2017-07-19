<?php

namespace Yaspa\Tests\Unit;

use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use Yaspa\Factory;
use Yaspa\OAuth\ConfirmInstallation;

class FactoryTest extends TestCase
{
    public function testCanMakeDependentInstance()
    {
        $instance = Factory::make(ConfirmInstallation::class);
        $this->assertInstanceOf(ConfirmInstallation::class, $instance);
    }

    public function testWillExceptionIfCannotMake()
    {
        $this->expectException(UnexpectedValueException::class);
        Factory::make('foo');
    }
}
