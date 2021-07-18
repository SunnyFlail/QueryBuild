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
        string $tableName,
        string $columnName,
        array $values,
        private bool $negate = false,
        string $combinedOperator = "AND"
    ) {
        $this->value = $values;
        $this->tableName = $tableName;
        $this->columnName = $columnName;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->getFieldName() . ' ' . $this->getOperator() . '  (' . implode(
            ', ', array_keys(
                $this->prepareArray($this->value, $this->getParameterName())
            )
        ) . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->generatePreparedArray($this->value, $this->getParameterName());
    }

    protected function getOperator(): string
    {
        return $this->negate ? 'NOT IN' : 'IN';;
    }

}