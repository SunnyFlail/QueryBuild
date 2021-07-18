<?php

namespace SunnyFlail\QueryBuilder\Terms;

use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;
use Generator;

final class Like implements ISearchTerm
{
    use SearchTermTrait;

    private string $fieldName;

    public function __construct(
        private string $tableName,
        private string $columnName,
        private string $value,
        private bool $negate = false,
        string $combinedOperator = "AND"
    ) {
        $this->value = $value;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        $operator = $this->negate ? ' NOT LIKE :' : ' LIKE :';
        return $this->tableName . '.' . $this->columnName .  $operator . $this->tableName . '_' . $this->columnName;
    }

    public function generateParameters(): Generator
    {
        yield ':' . $this->tableName . '_' . $this->columnName => $this->value;
    }

}