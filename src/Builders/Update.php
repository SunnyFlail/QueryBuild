<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IValue;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Interfaces\IOrderBy;
use SunnyFlail\QueryBuilder\Interfaces\IUpdateBuilder;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;
use SunnyFlail\QueryBuilder\Traits\ConditionalBuilderTrait;
use SunnyFlail\QueryBuilder\Traits\PersistBuilderTrait;

final class Update implements IUpdateBuilder
{

    use NestedQueriesTrait, NestedFieldsTrait, ConditionalBuilderTrait, PersistBuilderTrait;

    /**
     * @param string $tableName Name of the table to update
     * @param IValue[] $values Values to update it with
     * @param ISearchTerm[] $whereConditions Where conditions
     * @param IOrderBy[] $orders OrderBy condtions
     * @param int|null $limit
     * @param int|null $offset
     */
    public function __construct(
        private string $tableName,
        array $values,
        array $whereConditions,
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null,
    ) {
        $this->values = [];
        foreach ($values as $value) {
            $this->values[$value->getColumnName()] = $value;
        }
        $this->limit = $limit;
        $this->orders = $orders;
        $this->offset = $offset;
        $this->whereConditions = $whereConditions;
    }

    public function generateParameters(): Generator
    {
        $params = [
            ...array_values($this->values),
            ...$this->whereConditions
        ];

        foreach ($params as $param) {
            foreach ($param->generateParameters() as $key => $value) {
                yield $key => $value;
            }
        }
    }

    public function __toString(): string
    {
        $query = 'UPDATE ' . $this->tableName . ' SET ';

        foreach (array_values($this->values) as $index => $value) {
            if ($index !== 0) {
                $query .= ', ';
            }
            $query .= $value;
        }
        $query .= $this->implodeWhereConditions();
        $query .= $this->implodeOrderBy();
        $query .= $this->implodeLimit();
        
        return $query;
    }

}