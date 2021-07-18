<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IInsertBuilder;
use SunnyFlail\QueryBuilder\Interfaces\ISelectBuilder;

/**
 * Builder for queries inserting multiple values
 */
final class InsertRows implements IInsertBuilder
{

    protected array $rows;

    /**
     * @param string $tableName Name of the table to insert values into
     * @param string[] $columnNames Names of the columns to insert into
     */
    public function __construct(
        private string $tableName,
        private array $columnNames
    ) {
        $this->rows = [];
    }

    /**
     * Adds a new row of values
     * 
     * @return InsertRows
     */
    public function addRow(string|ISelectBuilder ...$values): InsertRows
    {
        $this->rows[] = $values;

        return $this;
    }

    public function generateParameters(): Generator
    {
        foreach ($this->rows as $repeat => $row) {
            foreach ($row as $index => $value) {
                if (is_object($value)) {
                    foreach ($value->generateParameters() as $key => $paramValue) {
                        yield $key => $paramValue;
                    }
                    continue;
                }
                yield $this->generateParameterName($index, $repeat) => $value;
            }
        }
    }

    public function __toString(): string
    {
        $query = 'INSERT INTO ' . $this->tableName;
        $query .= '(' . implode(', ', $this->columnNames) . ')';
        $query .= ' VALUES ';

        foreach ($this->rows as $repeat => $row) {
            if ($repeat !== 0) {
                $query .= ', ';
            }
            $query .= '(';
            foreach ($row as $index => $value) {
                if ($index !== 0) {
                    $query .= ', ';
                }
                if (is_object($value)) {
                    $query .= $value;
                    continue;
                }
                $query .= $this->generateParameterName($index, $repeat);
            }
            $query .= ')';
        }

        return $query;
    }

    protected function generateParameterName(int $columnIndex, int $repeat): string
    {
        return ':' . $this->columnNames[$columnIndex] . '_' . $repeat;
    }

}