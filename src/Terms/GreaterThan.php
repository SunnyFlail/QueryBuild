<?php

namespace SunnyFlail\QueryBuilder\Terms;

use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class GreaterThan implements ISearchTerm
{
    use SearchTermTrait;

    public function __construct(
        string $tableName,
        string $columnName,
        mixed $value,
        private bool $orEqual = false,
        string $combinedOperator = 'AND'
    ) {
        $this->value = $value;
        $this->tableName = $tableName;
        $this->columnName = $columnName;
        $this->combinedOperator = $combinedOperator;
    }

    protected function getOperator(): string
    {
        return $this->orEqual ? '>=' : '>';
    }

}