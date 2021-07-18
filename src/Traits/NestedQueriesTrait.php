<?php

namespace SunnyFlail\QueryBuilder\Traits;

use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;

trait NestedQueriesTrait
{

    /**
     * Returns sql code of queries
     * 
     * @param ISearchTerm[] $queries
     * 
     * @return string
     */
    protected function implodeQueries(array $queries): string
    {
        $code = "";

        foreach ($queries as $key => &$value) {
            if ($key !== 0) {
                $code .= ' ' . $value->getCombinedOperator();
            }
            $code .= ' ' . $value->__toString();
        }

        return $code;
    }

}