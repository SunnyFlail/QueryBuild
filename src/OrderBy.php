<?php

namespace SunnyFlail\QueryBuilder;

use SunnyFlail\QueryBuilder\Interfaces\IOrderBy;

final class OrderBy implements IOrderBy
{

    /**
     * Constructs new instance of OrderBy
     * 
     * @param string $fieldName Table and Column name separated by dot
     * @param bool   $reverse   if set to false this defaults to ASCENDING, true to DESCENDING 
     */
    public function __construct(
        private string $fieldName,
        private bool $reverse = false
    ) {
    }

    public function __toString(): string
    {
        return $this->fieldName . ($this->reverse ? ' DESC' : ' ASC');
    }

}