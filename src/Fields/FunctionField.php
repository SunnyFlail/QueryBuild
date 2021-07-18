<?php

namespace SunnyFlail\QueryBuilder\Fields;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;

/**
 * Class for one parameter functions such as MIN, MAX etc.
 */
final class FunctionField implements IQueryField
{

    public function __construct(
        private IQueryField $field,
        private string $functionName = "MIN",
        private ?string $alias = null
    ) {
    }

    public function __toString(): string
    {
        return $this->functionName . '(' . $this->field . ')' . ($this->alias ? ' AS ' . $this->alias : '');
    }

    public function generateParameters(): Generator
    {
        return $this->field->generateParameters();
    }

}