<?php

namespace SunnyFlail\QueryBuilder\Terms;

use Iterator;
use SunnyFlail\QueryBuilder\Interfaces\ISearchTerm;
use SunnyFlail\QueryBuilder\Traits\PrepareArrayTrait;
use SunnyFlail\QueryBuilder\Traits\SearchTermTrait;

final class In implements ISearchTerm
{
    use SearchTermTrait, PrepareArrayTrait;

    private string $query;
    /**
     * @var string[] $values
     */
    private array $values;

    public function __construct(
        string $tableName,
        string $columnName,
        array $values,
        string $combinedOperator = "AND"
    ) {
        $this->query = $tableName . '.' . $columnName;
        $this->values = $values;
        $this->combinedOperator = $combinedOperator;
    }

    public function __toString(): string
    {
        return $this->query . ' IN (' . implode(
            ', ', array_keys(
                $this->prepareArray($this->values, $this->query)
            )
        ) . ')';
    }

    public function generateParameters(): Iterator
    {
        return $this->generatePreparedArray($this->values, $this->query);
    }

}