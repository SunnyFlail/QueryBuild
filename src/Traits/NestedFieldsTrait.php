<?php

namespace SunnyFlail\QueryBuilder\Traits;

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
    protected function implodeFields(array &$fields): string
    {
        $code = '';

        foreach ($fields as $key => &$value) {
            if ($key !== 0) {
                $code .= ', ';
            }
            $code .= ' ' . $value->__toString();
        }
        return $code;
    }

}