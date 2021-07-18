<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

interface IPersistBuilder extends IQueryBuilder
{
    /**
     * Adds a new value/values
     * 
     * @param IValue[] $values
     * 
     * @return IPersistBuilder
     */
    public function add(IValue ...$values): IPersistBuilder;

    /**
     * Replaces the query value
     * 
     * @param IValue $value
     * 
     * @return IPersistBuilder
     */
    public function replace(IValue $value): IPersistBuilder;

}