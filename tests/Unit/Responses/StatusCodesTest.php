<?php

namespace Yaspa\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Yaspa\Responses\Exceptions;
use Yaspa\Responses\StatusCodes;

class StatusCodesTest extends TestCase
{
    public function testFindReason()
    {
        $instance = new StatusCodes();
        $result = $instance->findReason(200);
        $this->assertEquals(StatusCodes::DEFINITIONS['200'], $result);
    }

    public function testFindReasonWhereNotFound()
    {
        $this->expectException(Exceptions\StatusCodeDefinitionNotFoundException::class);
        $instance = new StatusCodes();
        $instance->findReason(0);
    }
}
