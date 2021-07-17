<?php

namespace SunnyFlail\QueryBuilder;

use SunnyFlail\QueryBuilder\Interfaces\IGroupBy;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;

final class GroupBy implements IGroupBy
{

    public function __construct(
        private string|IQueryField $field
    ) {
    }

    public function __toString(): string
    {
        return $this->field;
    }

}