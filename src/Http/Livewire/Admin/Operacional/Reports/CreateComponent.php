<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports;

//Http\Livewire\Traits\LivewireInfo.php
use Tall\Report\Http\Livewire\Traits\LivewireInfo;
use Tall\Report\Traits\Exportable;
use Tall\Report\Models\Report;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Http;

use Tall\Report\Http\Livewire\FormComponent;

class CreateComponent extends FormComponent
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
        
        $this->setFormProperties($model); // $relatorio from hereon, called $this->model        
        data_set($this->data, 'name', '');
        data_set($this->data, 'model', '');
        data_set($this->data, 'freeze_column', 0);
        data_set($this->data, 'freeze_row', 0);
        data_set($this->data, 'zoom_scale', 0);
        data_set($this->data, 'views', 0);
        data_set($this->data, 'content', '');
        data_set($this->data, 'status_id', 'published');
        data_set($this->data, 'foreigns_table', []);
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
        return 'tall-report::create-component';
    }
}
