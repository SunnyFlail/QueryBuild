<?php

namespace SunnyFlail\QueryBuilder;

use Generator;
use SunnyFlail\QueryBuilder\Traits\ValueTrait;
use SunnyFlail\QueryBuilder\Interfaces\IValue;
use SunnyFlail\QueryBuilder\Interfaces\ISelectBuilder;

/**
 * Class for values from Select Queries
 */
final class SelectValue implements IValue
{
    use ValueTrait;

    public function __construct(
        string $columnName,
        private ISelectBuilder $value
    ) {
        $this->columnName = $columnName;
    }

    public function getParameter(): string
    {
        return '(' . $this->value->__toString() . ')';
    }

    public function generateParameters(): Generator
    {
        return $this->value->generateParameters();
    }

}