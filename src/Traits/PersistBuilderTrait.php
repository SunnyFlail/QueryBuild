<?php

namespace SunnyFlail\QueryBuilder\Traits;

use SunnyFlail\QueryBuilder\Interfaces\IPersistBuilder;
use SunnyFlail\QueryBuilder\Interfaces\IValue;

/**
 * Trait for classes implementing IPersistBuilder interface
 */
trait PersistBuilderTrait
{

    /**
     * @var IValue[] $values Array containing binded values, key is column name, value the object holding value
     */
    protected array $values;

    public function add(IValue ...$values): IPersistBuilder
    {
        foreach ($values as $value) {
            $this->values[$value->getColumnName()] = $value;
        }
        return $this;
    }

    public function replace(IValue $value): IPersistBuilder
    {
        $this->values[$value->getColumnName()] = $value;
        return $this;
    }
}