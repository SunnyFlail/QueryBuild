<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

/**
 * Common interface for QueryBuilders
 */
interface IQueryBuilder extends IQueryField
{
    /**
     * Adds Where Conditions
     * 
     * @param ISearchTerm[] $where
     * 
     * @return IQueryBuilder
     */
    public function where(ISearchTerm ...$where): IQueryBuilder;

    /**
     * Adds Join constraints
     * 
     * @param IJoin[] $joins
     * 
     * @return IQueryBuilder
     */
    public function join(IJoinQuery ...$joins): IQueryBuilder;

    /**
     * Adds a GroupBy constraint
     * 
     * @param IGroupBy $groupBy
     * 
     * @return IQueryBuilder
     */
    public function groupBy(IGroupBy $groupBy): IQueryBuilder;

    /**
     * Adds Having Conditions
     * 
     * @param ISearchTerm[] $having
     * 
     * @return IQueryBuilder
     */
    public function having(ISearchTerm ...$having): IQueryBuilder;

    /**
     * Adds OrderBy constraints
     * 
     * @param IOrderBy[] $orders
     * 
     * @return IQueryBuilder
     */
    public function orderBy(IOrderBy ...$orders): IQueryBuilder;

    /**
     * Adds a Limit constraint
     * 
     * @param int      $limit
     * @param int|null $offset
     * 
     * @return IQueryBuilder
     */
    public function limit(int $limit, ?int $offset = null): IQueryBuilder;

    /**
     * Returns a copy with fields replaced by provided fields
     * 
     * @param IQueryField[] $fields
     *
     * @return IQueryBuilder
     */
    public function resetFields(IQueryField ...$fields): IQueryBuilder;

}