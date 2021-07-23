<?php

namespace SunnyFlail\QueryBuilder\Traits;

use Generator;

/**
 * Trait for classes implementing ISearchTerm interface
 */
trait SearchTermTrait
{

    /**
     * @var string $combinedOperator Operator printed when this is used in compound queries
     */
    protected string $combinedOperator;
    protected string $tableName;
    protected string $columnName;
    protected mixed $value;

    public function getCombinedOperator(): string
    {
        return $this->combinedOperator;
    }

    public function __toString(): string
    {
        return $this->getFieldName() . ' ' . $this->getOperator() . ' ' . $this->getParameterName();
    }

    public function generateParameters(): Generator
    {
        yield $this->getParameterName() => $this->value;
    }

    protected function getFieldName(): string
    {
        return $this->tableName . '.' . $this->columnName;
    }

    protected function getParameterName(): string
    {
        return ':' . $this->tableName . '_' . $this->columnName;
    }

    /**
     * Returns the operator this condition uses
     * 
     * @return string
     */
    abstract protected function getOperator(): string;

}