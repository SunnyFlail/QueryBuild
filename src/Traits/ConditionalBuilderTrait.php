<?php

namespace SunnyFlail\QueryBuilder\Traits;

use SunnyFlail\QueryBuilder\Interfaces\IConditionalBuilder;
use SunnyFlail\QueryBuilder\Interfaces\IOrderBy;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;

/**
 * Trait for QueryBuilders implementing IConditionalBuilder interface
 */
trait ConditionalBuilderTrait
{

    /**
     * @var ISearchTerm[] $whereConditions
     */
    protected array $whereConditions;

    /**
     * @var IOrderBy[] $orders
     */
    protected array $orders;
    /**
     * @var int|null $limit
     */
    protected ?int $limit;
    /**
     * @var int|null $offset
     */
    protected ?int $offset;
    
    public function where(ISearchTerm ...$where): IConditionalBuilder
    {
        $this->whereConditions = [...$this->whereConditions, ...$where];
        return $this;
    }

    public function orderBy(IOrderBy ...$orders): IConditionalBuilder
    {
        $this->orders = [...$this->orders, ...$orders];
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): IConditionalBuilder
    {
        $this->limit = $limit;
        $this->offset = $offset;
        
        return $this;
    }

    protected function implodeWhereConditions(): string
    {
        if ($this->whereConditions) {
            return ' WHERE ' . $this->implodeQueries($this->whereConditions);
        }
        return '';
    }

    protected function implodeOrderBy(): string
    {
        if ($this->orders) {
            return ' ORDER BY ' . implode(', ', $this->orders);
        }
        return '';
    }

    protected function implodeLimit(): string
    {
        $query = '';
        if ($this->limit) {
            $query .= ' LIMIT ' . $this->limit;
            if ($this->offset !== null) {
                $query .= ' OFFSET ' . $this->offset;
            }
        }
        return $query;
    }
}