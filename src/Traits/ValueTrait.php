<?php

namespace SunnyFlail\QueryBuilder\Traits;

/**
 * Trait for object implementing IValue interface
 */
trait ValueTrait
{
    /**
     * @var string $columnName Name of the column this value relates to
     */
    protected string $columnName;

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function __toString(): string
    {
        return $this->columnName . ' = ' . $this->getParameter();
    }

}
