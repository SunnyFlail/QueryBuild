<?php

namespace SunnyFlail\QueryBuilder\Fields;

use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use Generator;
use SunnyFlail\QueryBuilder\Traits\GenerateParametersTrait;

final class GroupConcatField implements IQueryField
{

    use NestedFieldsTrait, GenerateParametersTrait;

    /**
     * @var IQueryField[] $fields
     */
    private array $fields;

    public function __construct(
        private ?string $separator = null,
        private ?string $alias = null,
        IQueryField ...$fields
    ) {
        $this->fields = $fields;
    }

    public function __toString(): string
    {
        $query = 'GROUP_CONCAT(';
        $query .= $this->implodeFields($this->fields);
        if ($this->separator) {
            $query .= ' SEPARATOR "' . $this->separator . '"';
        }
        $query .= ')';
        if ($this->alias) {
            $query .= ' AS ' . $this->alias;
        }
        return $query;
    }

    public function generateParameters(): Generator
    {
        return $this->generateQueryParameters($this->fields);
    }

}