<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes;

use Tall\Report\Models\Report;
use Tall\Report\Http\Livewire\FormComponent;
use Tall\Report\Traits\Exportable;

class ColumnComponent extends FormComponent
{
    use Exportable;

    public $column;
    public $cardModal;
    public $name;
    public $title;

    public $listeners = ['openModal'];
     /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount(?Report $model, $column, $name)
    {
        $coluna = $model->columns()->where('name', $name)->first();
        $this->setFormProperties($model);  
        if($relationship = $coluna->relationships()->where('name', $column)->first()){
            $this->title =\Str::title(sprintf("%s %s" ,  $name, $column));
        }
        else{
           
            $this->title =\Str::title($column);             
        }
        $this->name = $name;
        $this->column = $column;
    }
   
  
    /*
    |--------------------------------------------------------------------------
    |  Features order
    |--------------------------------------------------------------------------
    | Order visivel no me menu
    |
    */
    public function openModal(){
        $this->cardModal = true;            
     }

     public function save(){

     }
     
     public function delete(){

    }
    
    public function view()
    {
        return 'report::includes.column-component';
    }
}
