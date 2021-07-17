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

    private string $fieldName;
    /**
     * @var IQueryBuilder $query
     */
    private array $query;

    public function __construct(
        string $tableName,
        string $columnName,
        IQueryBuilder $query,
        string $combinedOperator = "AND"
    ) {
        $this->fieldName = $tableName . '.' . $columnName;
        $this->query = $query;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->query . ' IN (' . $this->select . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->query->generateParameters();
    }

}