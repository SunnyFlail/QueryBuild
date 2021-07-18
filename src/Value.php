<?php

namespace SunnyFlail\QueryBuilder;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IValue;
use SunnyFlail\QueryBuilder\Traits\ValueTrait;

/**
 * Class for values with binded parameters
 */
final class Value implements IValue
{

    use ValueTrait;

    public function __construct(
        string $columnName,
        private int|string $value
    ) {
        $this->columnName = $columnName;
    }

    public function getParameter(): string
    {
        return ':' . $this->columnName;
    }

    public function generateParameters(): Generator
    {
        yield $this->getParameter() => $this->value;
    }

}