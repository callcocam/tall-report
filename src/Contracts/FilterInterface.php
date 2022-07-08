<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as BaseCollection;

interface FilterInterface
{
    /**
     * @param Builder | BaseCollection $query
     */
    public static function query($query);

    /** 
     * 
    */
    public function setColumns(array $columns);

    /** 
     * 
     */
    public function setSearch(string $search);

    /** 
     * 
     */
    public function setFilters(array $filters);

    /** @return Builder */
    public function filter();
}