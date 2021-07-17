<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

interface IWhereQuery extends ISqlQuery
{
    
    /**
     * Returns an array with keys as parameter names and values as binded values
     * 
     * @return array
     */
    public function getParameters(): array;

}