<?php

namespace Yaspa\Filters;

/**
 * Class Mixed
 *
 * @package Yaspa\Filters
 *
 * Array filters and methods that can be used to filter array values.
 */
class ArrayFilters
{
    /**
     * @param array $values
     * @param callable $filter
     * @return array
     */
    public function arrayFilterRecursive(array $values, callable $filter): array
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $values[$key] = $this->arrayFilterRecursive($value, $filter);
            }
        }

        return array_filter($values, $filter);
    }

    /**
     * Filter out not null values.
     *
     * @param mixed $value
     * @return bool
     */
    public function notNull($value): bool
    {
        return !is_null($value);
    }
}
