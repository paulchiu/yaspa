<?php

namespace Yaspa\Tests\Unit\Filters;

use PHPUnit\Framework\TestCase;
use Yaspa\Factory;
use Yaspa\Filters\ArrayFilters;

class ArrayFitersTest extends TestCase
{
    public function testCanFilterNotNullValues()
    {
        // Create fixtures, test preconditions
        $values = [null, 0, ''];
        $this->assertCount(3, $values);

        // Test method
        $filter = Factory::make(ArrayFilters::class);
        $filteredValues = array_filter($values, [$filter, 'notNull']);
        $this->assertCount(2, $filteredValues);
    }

    public function testCanFilterNotNullArrayValues()
    {
        // Create fixtures, test preconditions
        $valuesArray = [
            [null, 0, ''],
            [null, 0, ''],
        ];
        foreach ($valuesArray as $values) {
            $this->assertCount(3, $values);
        }

        // Test method
        $filter = Factory::make(ArrayFilters::class);
        $filteredValuesArray = $filter->arrayFilterRecursive($valuesArray, [$filter, 'notNull']);
        foreach ($filteredValuesArray as $values) {
            $this->assertCount(2, $values);
        }
    }
}
