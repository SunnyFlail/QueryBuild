<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

interface ISearchTerm extends ISqlQuery
{

    /**
     * Returns the combining operator this query answers
     * 
     * @return string
     */
    public function getCombinedOperator(): string;

}