<?php

namespace SunnyFlail\QueryBuilder\Fields;

use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use Iterator;

final class QueryField implements IQueryField
{

    public function __construct(
        private string|IQueryField $field,
        private ?string $alias = null
    ) {
    }

    public function __toString(): string
    {
        return $this->field . ($this->alias ? ' AS ' . $this->alias : '');
    }

    public function generateParameters(): Iterator
    {
        if (is_object($this->field)) {
            return $this->field->generateParameters();
        }

        yield null => null;
    }

}