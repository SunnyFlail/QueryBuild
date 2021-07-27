<?php

namespace SunnyFlail\QueryBuilder\Terms;

use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class Like implements ISearchTerm
{
    use SearchTermTrait;

    public function __construct(
        string $tableName,
        string $columnName,
        mixed $value,
        private bool $negate = false,
        string $combinedOperator = 'AND'
    ) {
        $this->value = $value;
        $this->tableName = $tableName;
        $this->columnName = $columnName;
        $this->combinedOperator = $combinedOperator;
    }

    protected function getOperator(): string
    {
        return $this->negate ? 'NOT LIKE' : 'LIKE';
    }

}