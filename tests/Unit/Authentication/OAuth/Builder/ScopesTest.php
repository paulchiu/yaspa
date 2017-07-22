<?php

namespace Yaspa\Tests\Unit\Authentication\OAuth\Builder;

use PHPUnit\Framework\TestCase;
use Yaspa\Authentication\OAuth\Builder\Scopes;
use Yaspa\Factory;

class ScopesTest extends TestCase
{
    public function testGetRequested()
    {
        // Create scopes
        $scopes = Factory::make(Scopes::class)
            ->withWriteCustomers()
            ->withWriteOrders()
            ->withWriteOrders();

        // Get and test builder results
        $requestedScopes = $scopes->getRequested();
        $this->assertCount(2, $requestedScopes);
        $this->assertContains(Scopes::WRITE_CUSTOMERS, $requestedScopes);
        $this->assertContains(Scopes::WRITE_ORDERS, $requestedScopes);
    }
}
