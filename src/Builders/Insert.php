<?php

namespace SunnyFlail\QueryBuilder\Builders;

use Generator;
use SunnyFlail\QueryBuilder\Interfaces\IInsertBuilder;
use SunnyFlail\QueryBuilder\Interfaces\IPersistBuilder;
use SunnyFlail\QueryBuilder\Interfaces\IValue;
use SunnyFlail\QueryBuilder\Traits\NestedFieldsTrait;
use SunnyFlail\QueryBuilder\Traits\NestedQueriesTrait;
use SunnyFlail\QueryBuilder\Traits\PersistBuilderTrait;

final class Insert implements IInsertBuilder, IPersistBuilder
{

    use PersistBuilderTrait, NestedQueriesTrait, NestedFieldsTrait;

    /**
     * @param string $tableName Name of the table to update
     * @param IValue[] $values Values to update it with
     */
    public function __construct(
        private string $tableName,
        array $values
    ) {
        $this->values = [];
        foreach ($values as $value) {
            $this->values[$value->getColumnName()] = $value;
        }
    }
    
    public function __toString(): string
    {
        $query = 'INSERT INTO ' . $this->tableName . ' (';
        $query .= implode(
            ', ', array_keys($this->values)
        );
        $query .= ') VALUES (';
        foreach (array_values($this->values) as $key => $value) {
            if ($key !== 0) {
                $query .= ', ';
            }
            $query .= $value->getParameter();
        }
        $query .= ');';
        
        return $query;
    }

    public function generateParameters(): Generator
    {
        foreach ($this->values as $value) {
            foreach ($value->generateParameters() as $key => $value) {
                yield $key => $value;
            }
        }
    }

}