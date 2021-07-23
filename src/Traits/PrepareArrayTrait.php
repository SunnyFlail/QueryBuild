<?php

namespace SunnyFlail\QueryBuilder\Traits;

use Generator;

trait PrepareArrayTrait
{

    /**
     * Returns an array containing keys prepared for using as PDO parameters
     * 
     * @param  array  $arr    Array to prepare
     * @param  string $prefix
     * @return array
     */
    protected function prepareArray(array $arr, string $prefix): array
    {
        $newArr = [];
        foreach (array_values($arr) as $i => $value)
        {
            $newArr[$prefix . '_' . $i] = $value;
        }
        return $newArr;
    }

    protected function generatePreparedArray(array $arr, string $prefix): Generator
    {
        foreach (array_values($arr) as $i => $value)
        {
            yield $prefix . '_' . $i => $value;
        }
    }

}

