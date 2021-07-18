<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IDeleteBuilder;
use SunnyFlail\QueryBuilder\Traits\ConditionalBuilderTrait;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;

final class Delete implements IDeleteBuilder
{

    use NestedFieldsTrait, NestedQueriesTrait, ConditionalBuilderTrait;

    /**
     * @param string        $tableName Name of the table this selects data from
     * @param ISearchTerm[] $whereConditions Where conditions
     * @param IOrderBy[]  $orders OrderBy conditions
     * @param int|null  $limit Limit condition
     * @param int|null  $joins Offset for Limit condition
     */
    public function __construct(
        private string $tableName,
        array $whereConditions = [],
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null,
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->orders = $orders;
        $this->whereConditions = $whereConditions;
    }

    public function __toString(): string
    {
        $query = 'DELETE ';

        $query .= ' FROM ' . $this->tableName;
        if ($this->whereConditions) {
            $query .= ' WHERE ' . $this->implodeQueries($this->whereConditions);
        }
        if ($this->orders) {
            $query .= ' ORDER BY ' . implode(', ', $this->orders);
        }
        if ($this->limit) {
            $query .= ' LIMIT ' . $this->limit;
            if ($this->offset !== null) {
                $query .= ' OFFSET ' . $this->offset;
            }
        }
        $query .= ';';

        return $query;
    }

    public function generateParameters(): Generator
    {
        foreach ($this->whereConditions as $where) {
            foreach ($where->generateParameters() as $key => $value) {
                yield $key => $value;
            }
        }
    }

}