<?php

namespace SunnyFlail\QueryBuilder\Terms;

use Iterator;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class Equals implements ISearchTerm
{
    use SearchTermTrait;

    private string $fieldName;

    public function __construct(
        string $tableName,
        string $columnName,
        private string $value,
        string $combinedOperator = "AND"
    ) {
        $this->fieldName = $tableName . '.' . $columnName;
        $this->value = $value;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->fieldName . ' = :' . $this->fieldName;
    }

    public function generateParameters(): Iterator
    {
        yield ':' . $this->fieldName => $this->value;
    }

}