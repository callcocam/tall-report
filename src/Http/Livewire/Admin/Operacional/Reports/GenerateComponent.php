<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports;

use Tall\Report\Http\Livewire\FormComponent;
use Tall\Report\Models\Report;
use Tall\Report\Traits\Exportable;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Tall\Report\Http\Livewire\Traits\LivewireInfo;

class GenerateComponent extends FormComponent
{
    use LivewireInfo, AuthorizesRequests, Exportable;
    

    public $checkboxValues = [];
    public $perPage = 6;
     /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro vasio
    |
    */
    public function mount(?Report $model)
    {
        if(\Schema::hasTable('roles')){
            $this->authorize(Route::currentRouteName());
        }     
        
        $this->setFormProperties($model); 
        if($columns = $model->columns){
            if($columns->count()){
                foreach($columns as $name => $column){
                   if($column->relationships->count()){                        
                        if($relationships = $column->relationships){                        
                            foreach($relationships as $relationship){
                                data_set($this->checkboxValues,sprintf("%s.%s", $column->name, $relationship->name),$relationship->name);
                            }
                        }
                   }
                   else{                    
                       data_set($this->checkboxValues, $column->name,$column->name);
                   }
                }
            }
        }
    }

    public function removeColumn($name, $column=null)
    {       
        if($coluna = $this->model->columns()->where('name', $name)->first()){
            if($column){
                $this->deleteColumn($column,$coluna->relationships()); 
                if($coluna = $this->model->columns()->where('name', $name)->first()){
                    if(!$coluna->relationships->count()){    
                        $this->deleteColumn($name,$this->model->columns());  
                    }  
                }  
            }
            else{
                $this->deleteColumn($name,$this->model->columns());   
            }  
            return redirect()->route(config('report.routes.reports.generate'), $this->model);              
        }
    }
      /*
    |--------------------------------------------------------------------------
    |  Features query
    |--------------------------------------------------------------------------
    | Inicia a consulta ao banco de dados
    |
    */
    protected function query(){
       
        if($this->model->exists){     
            $class = \Str::replace('-', '\\', $this->model->model); 
            if(class_exists($class))    
            {
                $builder = app($class)->query();
                 /** @phpstan-ignore-next-line */
                    $currentTable = $builder->getModel()->getTable();

                    if($filters = $this->model->filters){
                        // dd($filters);
                        foreach ($filters as $key => $filter) {
                            if($filter->name == $currentTable){
                                $this->filterInputText($builder, $filter);
                                if($filter->nulo){
                                    $builder->orWhereNull($filter->column);
                                }
                            }
                            else{
                                $builder->whereHas($filter->name, function (Builder $query) use ($filter) {
                                    $this->filterInputText($query, $filter);
                                });
                            }
                            
                        }
                    }
                return $builder;
            }
        }
        return null;
    }
    
    public function getModelsProperty()
    {
        $builder = $this->query();
        if($builder) return $builder->limit($this->perPage)->get();
        return null;
    }
    protected function view()
    {

        return 'report::generate-component';
    }
}
