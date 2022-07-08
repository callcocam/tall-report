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

    public function tablesNames(){
        $tables = \Tall\Schema\Schema::make()->getTableNames()->toArray();
        $options = [];
        foreach($tables as $table){
            if(!in_array($table, $this->getIgnoreTables())){
                $options[$table] = $table;
            }
        }
        return $options;
    }
    
    public function tables(){

        $ignore = [
            "Attribute",
            "Permission",
            "Role",
            "Header",
            "Cell",
            "Coluna",
            "Documento",
            "File",
            "Filter",
            "Image",
            "Description",
            "Policy",
            "PoliticaDeDesistencia",
            "PoliticaDeInscricao",
            "Relationship",
            "Relatorio",
            "Status",
            "Pagina",
            "Page",
            "Detalhe"
        ];
        
        $tables = $this->getModels();
        // $tables = $this->schema->getTableNames();

        $collection = new \Illuminate\Database\Eloquent\Collection;

        foreach($tables as $table){
            $label = \Str::afterLast($table, '\\');
            if(!in_array($label, $ignore)){
                $collection->put($table,$label );
            }
        }
        return $collection; //or compact('collection'); //for combo select
    }

    protected function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\\%s%s', Container::getInstance()->getNamespace(), strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));
    
                return $class;
            })
            ->filter(function ($class) {
                $valid = false;
    
                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }
    
                return $valid;
            });
        return $models->values();
    }

    
    protected function getIgnoreTables(){

        return [
            "attributes",
            "headers",
            "cells",
            "columns",
            "descriptions",
            "failed_jobs",
            "lb_blocks",
            "lb_contents",
            "migrations",
            "newsletters",
            "orderings",
            "pages",
            "paginas",
            "password_resets",
            "permission_role",
            "permission_user",
            "permissions",
            "personal_access_tokens",
            "policies",
            "politica_de_desistencias",
            "politica_de_inscricaos",
            "reports",
            "role_user",
            "roles",
            "sessions",
            "statuses",
        ];
    }
}
