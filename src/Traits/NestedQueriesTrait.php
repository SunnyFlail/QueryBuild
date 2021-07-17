<?php

namespace SunnyFlail\QueryBuilder\Traits;

use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use ArrayIterator;

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
        while (($iterator = new ArrayIterator($queries))->valid()) {
            /**
             * @var ISearchTerm $current
             */
            $current = $iterator->current();
            if ($iterator->key() !== 0) {
                $code .= ' ' . $current->getCombinedOperator();
            }
            $code .= ' ' . $current->__toString();
            $iterator->next();
        }
        return $code;
    }

}