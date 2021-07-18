<?php

namespace SunnyFlail\QueryBuilder\Terms;

use SunnyFlail\QueryBuilder\Traits\GenerateParametersTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use Generator;

final class Group implements ISearchTerm
{

    use NestedQueriesTrait, GenerateParametersTrait;

    public function __construct(
        private string $combinedOperator,
        ISearchTerm ...$searchTerms
    ) {
        $this->searchTerms = $searchTerms;
    }

    public function __toString(): string
    {
        if (!$this->searchTerms) {
            return '';
        }

        return '(' . $this->implodeQueries($this->searchTerms) . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->generateQueryParameters($this->searchTerms);
    }

    public function getCombinedOperator(): string
    {
        return $this->combinedOperator;
    }


}