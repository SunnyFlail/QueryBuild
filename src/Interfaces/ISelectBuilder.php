<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

/**
 * Interface for Select queries
 */
interface ISelectBuilder extends IConditionalBuilder
{

    /**
     * Adds Join constraints
     * 
     * @param IJoin[] $joins
     * 
     * @return ISelectBuilder
     */
    public function join(IJoinQuery ...$joins): ISelectBuilder;

    /**
     * Adds a GroupBy constraint
     * 
     * @param IGroupBy $groupBy
     * 
     * @return ISelectBuilder
     */
    public function groupBy(IGroupBy $groupBy): ISelectBuilder;

    /**
     * Returns a copy with fields replaced by provided fields
     * 
     * @param IQueryField[] $fields
     *
     * @return ISelectBuilder
     */
    public function resetFields(IQueryField ...$fields): ISelectBuilder;

    /**
     * Adds Having Conditions
     * 
     * @param ISearchTerm[] $having
     * 
     * @return ISelectBuilder
     */
    public function having(ISearchTerm ...$having): ISelectBuilder;

}