<?php

namespace SunnyFlail\QueryBuilder\Traits;

use Iterator;

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
            $newArr[$prefix.$i] = $value;
        }
        return $newArr;
    }

    protected function generatePreparedArray(array $arr, string $prefix): Generator
    {
        foreach (array_values($arr) as $i => $value)
        {
            yield [$prefix.$i => $value];
        }
    }

}