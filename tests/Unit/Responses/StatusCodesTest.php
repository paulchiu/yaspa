<?php

namespace Yaspa\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Yaspa\Factory;
use Yaspa\Responses\Exceptions;
use Yaspa\Responses\StatusCodes;

class StatusCodesTest extends TestCase
{
    public function testCanFindReason()
    {
        $instance = Factory::make(StatusCodes::class);
        $result = $instance->findReason(200);
        $this->assertEquals(StatusCodes::DEFINITIONS['200'], $result);
    }

    public function testThrowsExceptionWhenCannotFindReason()
    {
        $this->expectException(Exceptions\StatusCodeDefinitionNotFoundException::class);
        $instance = Factory::make(StatusCodes::class);
        $instance->findReason(0);
    }
}
