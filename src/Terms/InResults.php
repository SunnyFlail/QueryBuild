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

    /**
     * @var IQueryBuilder $query
     */
    private array $query;

    public function __construct(
        private string $tableName,
        private string $columnName,
        IQueryBuilder $query,
        private bool $negate = false,
        string $combinedOperator = "AND"
    ) {
        $this->query = $query;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        $operator = $this->negate ? ' NOT IN (' : ' IN (';

        return $this->tableName . '.' . $this->columnName . $operator . $this->query . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->query->generateParameters();
    }

}