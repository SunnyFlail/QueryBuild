<?php

namespace SunnyFlail\QueryBuilder\Fields;

use SunnyFlail\QueryBuilder\Traits\GenerateParametersTrait;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use SunnyFlail\QueryBuilder\Interfaces\ISqlQuery;
use Generator;

final class ConcatField implements IQueryField
{

    use NestedFieldsTrait, GenerateParametersTrait;

    /**
     * @var ISqlQuery[] $fields
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
        $query = $this->separator ? 'CONCAT_WS("' . $this->separator . '", ': 'CONCAT(';
        $query .= $this->implodeFields($this->fields);
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