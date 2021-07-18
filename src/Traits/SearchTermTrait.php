<?php

namespace SunnyFlail\QueryBuilder\Traits;

/**
 * Trait for classes implementing ISearchTerm interface
 */
trait SearchTermTrait
{

    private string $combinedOperator;

    public function getCombinedOperator(): string
    {
        return $this->combinedOperator;
    }

}