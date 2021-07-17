<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

use Generator;
use Stringable;

interface ISqlQuery extends Stringable
{
    /**
     * Returns the sql code
     * 
     * @return string
     */
    public function __toString(): string;

    /**
     * Returns a Generator yielding column name as a key and binded value as value
     * 
     * @return Generator
     */
    public function generateParameters(): Generator;

}