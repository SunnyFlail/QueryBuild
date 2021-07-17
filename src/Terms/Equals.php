<?php

namespace SunnyFlail\QueryBuilder\Terms;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class Equals implements ISearchTerm
{
    use SearchTermTrait;

    private string $fieldName;

    public function __construct(
        private string $tableName,
        private string $columnName,
        private string $value,
        string $combinedOperator = "AND"
    ) {
        $this->value = $value;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->tableName . '.' . $this->columnName . ' = :' . $this->tableName . '_' . $this->columnName;
    }

    public function generateParameters(): Generator
    {
        yield ':' . $this->tableName . '_' . $this->columnName => $this->value;
    }

}