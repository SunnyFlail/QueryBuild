<?php

namespace SunnyFlail\QueryBuilder\Interfaces;

interface IValue extends ISqlQuery
{

    /**
     * Returns name of the column this value relates to
     * 
     * @return string
     */
    public function getColumnName(): string;

    /**
     * Returns the parameter name if this is binded PDO param OR Query String
     * 
     * @return string
     */
    public function getParameter(): string;

}