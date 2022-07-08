<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

trait FilterTrait
{
    /**
     * @param string|array $value
     */
    public function filterInputText(Builder &$query, string $field, $operator, $value): void
    { 
   
        switch ($operator) {
            case 'is':
                $query->where($field, '=', $value);

                break;
            case 'is_not':
                $query->where($field, '!=', $value);

                break;
            case 'starts_with':
                $query->where($field, 'LIKE', $value . '%');

                break;
            case 'ends_with':
                $query->where($field, 'LIKE', '%' . $value);

                break;
            case 'contains':
                $query->where($field, 'LIKE', '%' . $value . '%');

                break;
            case 'contains_not':
                $query->where($field, 'NOT ' . 'LIKE', '%' . $value . '%');

                break;
            case 'is_empty':
                $query->where($field, '=', '')->orWhereNull($field);

                break;
            case 'is_not_empty':
                $query->where($field, '!=', '')->whereNotNull($field);

                break;
            case 'is_null':
                $query->whereNull($field);

                break;
            case 'is_not_null':
                $query->whereNotNull($field);

                break;
            case 'is_blank':
                $query->where($field, '=', '');

                break;
            case 'is_not_blank':
                $query->where($field, '!=', '')->orWhereNull($field);

                break;
        }
       
    }
}