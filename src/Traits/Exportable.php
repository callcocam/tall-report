<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Traits;

use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Database\Eloquent as Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support as Support;
use Tall\Report\Types\{ExportToCsv, ExportToXLS};
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

/**
 * @property ?Batch $exportBatch
 */
trait Exportable
{
    use FilterTrait;
    
    protected $medelReport;

    public array $exportOptions = [];

    /**
     * @throws Throwable
     */
    public function exportToXLS(bool $selected = false): BinaryFileResponse|bool
    {
        return $this->export(ExportToXLS::class, $selected);
    }

    /**
     * @throws Throwable
     */
    public function exportToCsv(bool $selected = false): BinaryFileResponse|bool
    {
        return $this->export(ExportToCsv::class, $selected);
    }

    /**
     * @throws Exception
     */
    public function prepareToExport(bool $selected = false): Eloquent\Collection|Support\Collection
    {
        $builder = $this->query();
        /** @phpstan-ignore-next-line */
        $currentTable = $builder->getModel()->getTable();

        if($filters = $this->model->filters){
            // dd($filters);
            foreach ($filters as $key => $filter) {
                if($filter->name == $currentTable){
                    $this->filterInputText($builder, $filter->column, $filter->operador, $filter->value);
                    if($filter->nulo){
                       $builder->orWhereNull($filter->column);
                    }
                }
                else{
                    $builder->whereHas($filter->name, function (Builder $query) use ($filter) {
                        $this->filterInputText($query, $filter->column, $filter->operador, $filter->value);
                    });
                }
              
            }
        }
      
        $results = $builder
            // ->when($inClause, function ($query, $inClause) {
            //     return $query->whereIn($this->primaryKey, $inClause);
            // })
            // ->orderBy($sortField, $this->sortDirection)
            ->get();

        return $results;
    }

    /**
     * @throws Exception | Throwable
     */
    private function export(string $exportableClass, bool $selected): BinaryFileResponse|bool
    {
        
        if (count($this->checkboxValues) === 0 && $selected) {
            return false;
        }
        
        if (!count($this->checkboxValues)) {
            return false;
        }

        $this->createColumns();
        /**
         * @var ExportToCsv|ExportToCsv $exportable
         */
        $exportable = new $exportableClass();

        $columns = $this->model->columns->toArray();


        /** @var string $fileName */

        $fileName = data_get($this->model, 'slug');
        $exportable->fileName($fileName)
            ->setData($columns, $this->prepareToExport($selected));

        return $exportable->download([]);
    }

    
    public function createColumns($name = null){
        $model = $this->model;
        foreach($this->checkboxValues as $table=>$column) {       
            if(is_array($column)){
                foreach($column as $key => $item) { 
                    if($item === false) {        
                        if($coluna = $model->columns()->where('name', $name)->first()){
                            $this->deleteColumn($key,$coluna->relationships()); 
                            if($coluna = $model->columns()->where('name', $name)->first()){
                                if(!$coluna->relationships->count()){    
                                    $this->deleteColumn($name,$model->columns());  
                                }  
                            }  
                        }else{
                            $this->deleteColumn($name,$model->columns());   
                        }
                    }        
                    else{
                        $columnName = \Str::title($table);
                        if($coluna = $this->createColumn($table, $columnName,$model->columns())) {
                            $columnName = \Str::title($item);
                            $relationship = $this->createColumn($item, $columnName,$coluna->relationships());
                            $header = $this->createHeader($relationship, $columnName);
                            $this->createAttribute($header);
                            $cell = $this->createCell($relationship);
                            $this->createAttribute($cell);
                        }                        
                    }               
                };
            }
            else{
                if($column === false) {
                    $this->deleteColumn($table,$model->columns());   
                }        
                else{
                    $columnName = \Str::title($column);
                    if($coluna = $this->createColumn($column, $columnName,$model->columns())){
                        $header = $this->createHeader($coluna, $columnName);
                        $this->createAttribute($header);
                        $cell = $this->createCell($coluna);
                        $this->createAttribute($cell);
                    }
                }
            }        
        };
    }

    private function createColumn($column,$columnName, $model){        
        return $model->firstOrCreate([
            "name"=>$column
        ]);
    }
    
    private function createHeader($model, $columnName){        
        return $model->header()->firstOrCreate([
            'label'=>$columnName
        ]);
    }

    private function createCell($model){        
        return $model->cell()->firstOrCreate([]);
    }

    private function createAttribute($model){        
        return $model->attribute()->firstOrCreate([]);
    }

    private function deleteColumn($column, $model){
        if($coluna = $model->where('name', $column)->first()){
            if($cell = $coluna->cell){
                if($atribute = $cell->atribute){
                    $atribute->delete();
                }
                $cell->delete();
            }
            if($header = $coluna->header){
                if($atribute = $header->atribute){
                    $atribute->delete();
                }
                $header->delete();
            }
            $coluna->delete();
        }
       
    }

}
