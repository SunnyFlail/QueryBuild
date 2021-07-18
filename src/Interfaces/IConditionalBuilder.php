<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

interface IConditionalBuilder extends IQueryBuilder
{

    /**
     * Adds Where Conditions
     * 
     * @param ISearchTerm[] $where
     * 
     * @return IConditionalBuilder
     */
    public function where(ISearchTerm ...$where): IConditionalBuilder;

    /**
     * Adds OrderBy constraints
     * 
     * @param IOrderBy[] $orders
     * 
     * @return IConditionalBuilder
     */
    public function orderBy(IOrderBy ...$orders): IConditionalBuilder;

    /**
     * Adds a Limit constraint
     * 
     * @param int      $limit
     * @param int|null $offset
     * 
     * @return IConditionalBuilder
     */
    public function limit(int $limit, ?int $offset = null): IConditionalBuilder;

}