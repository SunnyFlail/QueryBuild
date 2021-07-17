<?php

namespace SunnyFlail\QueryBuilder\Traits;

use ArrayIterator;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;

trait NestedFieldsTrait
{
    
    /**
     * Returns sql code of queries
     * 
     * @param IQueryField[] $queries
     * 
     * @return string
     */
    protected function implodeFields(array $fields): string
    {
        $code = "";
        while (($iterator = new ArrayIterator($fields))->valid()) {
            $current = $iterator->current();
            $code .= ' ' . $current->__toString();
            $iterator->next();
            if ($iterator->valid()) {
                $code .= ', ';
            }
        }
        return $code;
    }

}