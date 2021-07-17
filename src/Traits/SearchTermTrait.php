<?php

namespace SunnyFlail\QueryBuilder\Traits;

trait SearchTermTrait
{

    private string $combinedOperator;

    public function getCombinedOperator(): string
    {
        return $this->combinedOperator;
    }

}