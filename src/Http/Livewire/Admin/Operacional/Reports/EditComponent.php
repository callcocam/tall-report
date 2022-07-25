<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports;

use Tall\Report\Models\Report;
use Tall\Report\Traits\Exportable;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Tall\Report\Http\Livewire\Traits\LivewireInfo;

use Tall\Report\Http\Livewire\FormComponent;

class EditComponent extends FormComponent
{
    use LivewireInfo, AuthorizesRequests, Exportable;
    
    
    protected function rules(){
        return [
             'name'=>'required',
             'model'=>'required',
        ];
     }
     
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
    }
    
   
    
    public function getModelsProperty()
    {
        if(  $collections = config('schema.models',null) ){            
           return $collections;
        }
        else{
            $collections = \Tall\Schema\Schema::models(config('schema.ignore.models',[]));
        }
      
        return $collections;
    }

    public function getTablesProperty()
    {
        if(  $collections = config('schema.tables',null) ){            
            return $collections;
         }
         else{
            $collections = \Tall\Schema\Schema::tables(config('schema.ignore.tables',[]));
         }
        return $collections;

    }
    protected function view()
    {

        return 'tall-report::edit-component';
    }
    
}
