<?php

namespace SunnyFlail\QueryBuilder\Terms;

use SunnyFlail\QueryBuilder\Traits\GenerateParametersTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use Generator;

final class Group implements ISearchTerm
{

    use NestedQueriesTrait, GenerateParametersTrait, SearchTermTrait;

    public function __construct(
        string $combinedOperator = 'AND',
        ISearchTerm ...$searchTerms
    ) {
        $this->combinedOperator = $combinedOperator;
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

}