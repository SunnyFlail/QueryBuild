<?php

namespace SunnyFlail\QueryBuilder\Joins;

use SunnyFlail\QueryBuilder\Interfaces\IJoinQuery;

class Join implements IJoinQuery
{
    protected ?string $prefix;

    public function __construct(
        protected string $tableOne,
        protected string $columnOne,
        protected string $tableTwo,
        protected string $columnTwo
    ) {
        $this->prefix = null;
    }

    public function __toString(): string
    {
        return $this->prefix . ' JOIN'  . $this->tableTwo . ' ON ' . $this->tableOne
        . '.' . $this->columnOne . ' = ' . $this->tableTwo . '.' . $this->columnTwo;
    }
}