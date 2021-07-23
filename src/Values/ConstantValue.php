<?php

namespace SunnyFlail\QueryBuilder\Values;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IValue;
use SunnyFlail\QueryBuilder\Traits\ValueTrait;

/**
 * Class for values that are created directly inline in sql
 */
final class ConstantValue implements IValue
{
    use ValueTrait;

    public function __construct(
        string $columnName,
        private mixed $value,
        private bool $escape = true
    ) {
        $this->columnName = $columnName;
    }

    public function getParameter(): string
    {
        if ($this->escape) {
            return'"' . $this->value . '"';
        }

        return $this->value;
    }

    public function generateParameters(): Generator
    {
        yield null => null;
    }

}