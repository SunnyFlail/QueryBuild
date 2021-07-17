<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use AppendIterator;
use NoRewindIterator;
use SunnyFlail\QueryBuilder\Interfaces\IGroupBy;
use SunnyFlail\QueryBuilder\Interfaces\IOrderBy;
use SunnyFlail\QueryBuilder\Interfaces\IJoinQuery;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use SunnyFlail\QueryBuilder\Interfaces\IQueryBuilder;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;

final class Select implements IQueryBuilder
{

    use NestedFieldsTrait, NestedQueriesTrait;

    /**
     * @param string        $tableName Name of the table this selects data from
     * @param IQueryField[] $fields Fields to be selected
     * @param IJoinQuery[]  $joins Table joins
     * @param ISearchTerm[] $where Where conditions
     * @param IGroupBy|null  $groupBy GroupBy condition
     * @param ISearchTerm[]  $having Having conditions
     * @param IOdrderBy[]  $orders OrderBy conditions
     * @param int|null  $limit Limit condition
     * @param int|null  $joins Offset for Limit condition
     */
    public function __construct(
        private string $tableName,
        private array $fields,
        private array $joins = [],
        private array $where = [],
        private ?IGroupBy $groupBy = null,
        private array $having = [],
        private array $orders = [],
        private ?int $limit = null,
        private ?int $offset = null,
    ) {}

    public function where(ISearchTerm ...$where): IQueryBuilder
    {
        $this->where = [...$this->where, ...$where];
        return $this;
    }

    public function join(IJoinQuery ...$joins): IQueryBuilder
    {
        $this->joins = [...$this->joins, ...$joins];
        return $this;
    }

    public function groupBy(IGroupBy $groupBy): IQueryBuilder
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    public function having(ISearchTerm ...$having): IQueryBuilder
    {
        $this->having = [...$this->having, ...$having];
        return $this;
    }

    public function orderBy(IOrderBy ...$orders): IQueryBuilder
    {
        $this->orders = [...$this->orders, ...$orders];
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): IQueryBuilder
    {
        $this->limit = $limit;
        $this->offset = $offset;
        
        return $this;
    }

    public function generateParameters(): Generator
    {
        $iterator = new AppendIterator();
        foreach ($this->fields as $field) {
            $generator = $field->generateParameters();
            $iterator->append(new NoRewindIterator(
                $generator
            ));
        }
        if ($this->where) {
            foreach ($this->where as $field) {
                $generator = $field->generateParameters();
                $iterator->append(new NoRewindIterator(
                    $generator
                ));
            }
        }
        if ($this->having && $this->groupBy) {
            foreach ($this->having as $field) {
                $generator = $field->generateParameters();
                $iterator->append(new NoRewindIterator(
                    $generator
                ));
            }
        }

        return $iterator;
    }

    public function __toString(): string
    {
        $query = 'SELECT';
        $query .= ' ' . $this->implodeFields($this->fields);
        $query .= ' FROM ' . $this->tableName;
        if ($this->where) {
            $query .= ' WHERE ' . $this->implodeQueries($this->where);
        }
        if ($this->joins) {
            $query .= ' ' . implode(' ', $this->joins);
        }
        if ($this->groupBy) {
            $query .= ' GROUP BY ' . $this->groupBy;
            if ($this->having) {
                $query .= ' HAVING' . implode(', ', $this->having);                
            }
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

    public function resetFields(IQueryField ...$fields): IQueryBuilder
    {
        $copy = clone $this;
        $copy->fields = $fields;
        return $copy;
    }

}