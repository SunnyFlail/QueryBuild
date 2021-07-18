<?php

namespace SunnyFlail\QueryBuilder\Terms;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\PrepareArrayTrait;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class In implements ISearchTerm
{
    use SearchTermTrait, PrepareArrayTrait;

    /**
     * @var string[] $values
     */
    private array $values;

    public function __construct(
        private string $tableName,
        private string $columnName,
        array $values,
        private bool $negate = false,
        string $combinedOperator = "AND"
    ) {
        $this->values = $values;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        $operator = $this->negate ? ' NOT IN (' : ' IN (';

        return $this->tableName . '.' . $this->columnName . $operator . implode(
            ', ', array_keys(
                $this->prepareArray($this->values, $this->tableName . '_' . $this->columnName)
            )
        ) . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->generatePreparedArray($this->values, $this->query);
    }

}