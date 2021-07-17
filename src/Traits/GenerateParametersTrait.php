<?php

namespace SunnyFlail\QueryBuilder\Traits;

use Generator;

trait GenerateParametersTrait
{
    /**
     * Returns an generator generateing parameter name as key and param value as value
     * 
     * @param ISqlQuery[] $queries
     * 
     * @return Generator
     */
    protected function generateQueryParameters(array $queries): Generator
    {
        foreach ($queries as $query) {
            foreach ($query->generateParameters() as $key => $value) {
                if ($key === null) {
                    continue;
                }
                yield $key => $value;
            }
        }
    }
    
}