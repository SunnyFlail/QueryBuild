<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IGroupBy;
use SunnyFlail\QueryBuilder\Interfaces\IOrderBy;
use SunnyFlail\QueryBuilder\Interfaces\IJoinQuery;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use SunnyFlail\QueryBuilder\Interfaces\ISelectBuilder;
use SunnyFlail\QueryBuilder\Traits\ConditionalBuilderTrait;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;

final class Select implements ISelectBuilder
{

    use NestedFieldsTrait, NestedQueriesTrait, ConditionalBuilderTrait;

    /**
     * @param string        $tableName Name of the table this selects data from
     * @param IQueryField[] $fields Fields to be selected
     * @param IJoinQuery[]  $joins Table joins
     * @param ISearchTerm[] $whereConditions Where conditions
     * @param IGroupBy|null  $groupBy GroupBy condition
     * @param ISearchTerm[]  $having Having conditions
     * @param IOrderBy[]  $orders OrderBy conditions
     * @param int|null  $limit Limit condition
     * @param int|null  $joins Offset for Limit condition
     */
    public function __construct(
        private string $tableName,
        private array $fields,
        private array $joins = [],
        array $whereConditions = [],
        private ?IGroupBy $groupBy = null,
        private array $having = [],
        array $orders = [],
        ?int $limit = null,
        ?int $offset = null,
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->orders = $orders;
        $this->whereConditions = $whereConditions;
    }

    public function join(IJoinQuery ...$joins): ISelectBuilder
    {
        $this->joins = [...$this->joins, ...$joins];
        return $this;
    }

    public function groupBy(IGroupBy $groupBy): ISelectBuilder
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    public function having(ISearchTerm ...$having): ISelectBuilder
    {
        $this->having = [...$this->having, ...$having];
        return $this;
    }

    public function generateParameters(): Generator
    {
        $fields = [
            ...$this->fields,
            ...$this->whereConditions
        ];
        if ($this->having && $this->groupBy) {
            $fields = [...$fields, ...$this->having];
        }

        foreach ($fields as $field) {
            foreach ($field->generateParameters() as $key => $param) {
                yield $key => $param;
            }
        }
    }

    public function __toString(): string
    {
        $query = 'SELECT';
        $query .= ' ' . $this->implodeFields($this->fields);
        $query .= ' FROM ' . $this->tableName;
        if ($this->joins) {
            $query .= ' ' . implode(' ', $this->joins);
        }
        $query .= $this->implodeWhereConditions();
        if ($this->groupBy) {
            $query .= ' GROUP BY ' . $this->groupBy;
            if ($this->having) {
                $query .= ' HAVING' . implode(', ', $this->having);                
            }
        }
        $query .= $this->implodeOrderBy();
        $query .= $this->implodeLimit();

        return $query;
    }

    public function resetFields(IQueryField ...$fields): ISelectBuilder
    {
        $copy = clone $this;
        $copy->fields = $fields;
        return $copy;
    }

}