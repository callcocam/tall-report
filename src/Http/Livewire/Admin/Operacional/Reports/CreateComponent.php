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
        data_set($this->data, 'freeze_column', '');
        data_set($this->data, 'freeze_row', '');
        data_set($this->data, 'zoom_scale', '');
        data_set($this->data, 'views', '');
        data_set($this->data, 'content', '');
        data_set($this->data, 'foreigns_table', []);
    }
   
    
    public function getModelsProperty()
    {
        
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
        $collections = \Tall\Schema\Schema::models(array_merge($ignore, config('schema.ignore.models',[])));
        return $collections;
    }

    public function getTablesProperty()
    {
        $collections = \Tall\Schema\Schema::tables(config('schema.ignore.tables',[]));
        return $collections;

    }
    
    protected function view()
    {
        return 'tall-report::create-component';
    }
}
