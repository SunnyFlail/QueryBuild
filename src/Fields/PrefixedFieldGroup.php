<?php

namespace SunnyFlail\QueryBuilder\Fields;

use SunnyFlail\QueryBuilder\Interfaces\IQueryField;
use Generator;

/**
 * Query abstraction for fields of same table that are aliased with a prefix or table name
 */
final class PrefixedFieldGroup implements IQueryField
{
    /**
     * @var string[] $columnNames
     */
    private array $columnNames;

    public function __construct(
        private string $tableName,
        private ?string $prefix,
        string ...$columnNames
    ) {
        $this->columnNames = $columnNames;
    }
    
    public function __toString(): string
    {
        $query = '';
        foreach ($this->columnNames as $index => $column) {
            if ($index !== 0) {
                $query .= ', ';
            }
            $query .= $this->tableName . '.' . $column . ' AS ' . $this->getAlias($column);
        }

        return $query;
    }

    public function generateParameters(): Generator
    {
        yield null => null;
    }

    /**
     * Returns the prefixed alias
     * 
     * @param string $columnName
     * 
     * @return string
     */
    private function getAlias(string $columnName): string
    {
        if ($this->prefix) {
            return $this->prefix . '_' . $columnName;
        }

        return $this->tableName . '_' . $columnName;
    }

}