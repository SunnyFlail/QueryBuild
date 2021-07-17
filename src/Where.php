<?php

namespace SunnyFlail\QueryBuilder;

use Generator;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;
use SunnyFlail\QueryBuilder\Interfaces\IWhereQuery;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;

final class Where implements IWhereQuery
{

    use NestedQueriesTrait;

    /**
     * @var ISearchTerm[] $searchTerms
     */
    private array $searchTerms;

    public function __construct(
        ISearchTerm ...$searchTerms
    ) {
        $this->searchTerms = $searchTerms;
    }

    public function __toString(): string
    {
        if (!$this->searchTerms) {
            return '';
        }
        
        return "WHERE" . $this->implodeQueries($this->searchTerms);
    }

    public function getParameters(): array
    {
        $params = [];
        foreach ($this->generateParameters() as $parameterName => $value) {
            $params[$parameterName] = $value;
        }
        return $params;
    }
   
    public function generateParameters(): Generator
    {
        return $this->generateQueryParameters($this->searchTerms);
    }
    
}