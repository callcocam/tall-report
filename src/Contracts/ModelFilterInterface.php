<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Tall\Report\Helpers\Model;

interface ModelFilterInterface
{
    public static function query(Builder $query): Model;

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): Model;

    public function setSearch(string $search): Model;

    /**
     * @param array<string, array<string>> $filters
     */
    public function setFilters(array $filters): Model;

    public function filter(): Builder;
}