<?php

namespace SunnyFlail\QueryBuilder\Joins;

final class RightJoin extends Join
{

    public function __construct(
        string $tableOne,
        string $columnOne,
        string $tableTwo,
        string $columnTwo,
        ?string $alias = null
    ) {
        parent::__construct($tableOne, $columnOne, $tableTwo, $columnTwo, $alias);

        $this->prefix = 'RIGHT ';
    }

}