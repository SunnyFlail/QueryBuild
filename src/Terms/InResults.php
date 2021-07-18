<?php

namespace SunnyFlail\QueryBuilder\Terms;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IQueryBuilder;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\PrepareArrayTrait;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class InResults implements ISearchTerm
{
    use SearchTermTrait, PrepareArrayTrait;

    public function __construct(
        string $tableName,
        string $columnName,
        IQueryBuilder $query,
        private bool $negate = false,
        string $combinedOperator = "AND"
    ) {
        $this->value = $query;
        $this->tableName = $tableName;
        $this->columnName = $columnName;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->getFieldName() . ' ' . $this->getOperator() . ' (' . $this->value . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->query->generateParameters();
    }

    protected function getOperator(): string
    {
        return $this->negate ? 'NOT IN' : 'IN';;
    }

}