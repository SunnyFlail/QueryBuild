<?php

namespace SunnyFlail\QueryBuilder\Fields;

use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use ArrayIterator;
use Iterator;

/**
 * Query abstraction for fields of same table
 */
final class QueryFieldGroup implements IQueryField
{
    /**
     * @var string[] $columnNames
     */
    private array $columnNames;

    public function __construct(
        private string $tableName,
        private ?string $separator = null,
        string ...$columnNames
    ) {
        $this->columnNames = $columnNames;
    }

    public function __toString(): string
    {
        $query = '';

        while (($iterator = new ArrayIterator($this->columnNames))->valid()) {
            $current = $iterator->current();

            $query .= $this->tableName . '.' . $current;

            $iterator->next();
            
            if ($this->separator) {
                $query .= ', ' . $this->separator;
            }

            if ($iterator->valid()) {
                $query .= ', ';
            }

        }
        return $query;
    }

    public function generateParameters(): Iterator
    {
        yield null => null;
    }

}