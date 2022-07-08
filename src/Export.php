<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Helpers\Helpers;

class Export
{
    public string $fileName;

    public Collection $data;

    public string $striped = '';

    public array $columnWidth = [];

    /** @var array $columns */
    public array $columns;

    public function fileName(string $name): Export
    {
        $this->fileName = $name;

        return $this;
    }

    /**
     * @param array $columns
     * @param Collection $data
     * @return Export
     */
    public function setData(array $columns, Collection $data): Export
    {
        $this->columns    = $columns;
        $this->data       = collect($data->toArray());

        return $this;
    }

    /**
     * @param Collection $data
     * @param array $columns
     * @return array{headers: array, rows: array}.
     */
    public function prepare(Collection $data, array $columns): array
    {
        $header = collect([]);
        
        $data   = $data->transform(function ($row) use ($columns, $header) {
            $item = collect([]);

           
            collect($columns)->each(function ($column) use ($row, $header, $item) {
                if($relationships = data_get($column, 'relationships')){                  
                    collect($relationships)->each(function ($relationship) use ($row, $header, $item, $column) {
                        $columnName = \Str::title(data_get($relationship,'header.label'));
                        $columnName = sprintf("%s %s",data_get($column, 'name'), $columnName);
                        $name = sprintf("%s.%s",data_get($column, 'name'), data_get($relationship, 'name'));
                        $item->put($columnName , data_get($row,  $name));
                        if (!$header->contains($columnName )) {
                            $header->push($columnName);
                        }  
                    });    
                }
                else{  
                   $columnName = \Str::title(data_get($column,'header.label'));                   
                    $item->put($columnName , data_get($row,  data_get($column,'name')));
                    if (!$header->contains($columnName )) {
                        $header->push($columnName);
                    }
                }
            });
            return $item->toArray();
        });
        return [
            'headers' => $header->toArray(),
            'rows'    => $data->toArray(),
        ];
    }
}
