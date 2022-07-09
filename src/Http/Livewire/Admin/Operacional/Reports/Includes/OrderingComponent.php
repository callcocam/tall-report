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

class OrderingComponent extends FormComponent
{
    use Exportable;
    
    public $cardModal;
    public $updated = false;
    
     /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount(?Report $model)
    {
        
        $this->setFormProperties($model); 
        
    }

    public function getColunasProperty(){
        return $this->model->columns()->orderBy('ordering')->get();
    }
    /*
    |--------------------------------------------------------------------------
    |  Features order
    |--------------------------------------------------------------------------
    | Order visivel no me menu
    |
    */
    public function order(){
        return 1000;
     }
    /*
    |--------------------------------------------------------------------------
    |  Features order
    |--------------------------------------------------------------------------
    | Order visivel no me menu
    |
    */
    public function updateColunaOrder($data){
      if($data){
         foreach($data as $order){
            $this->model->columns()->where('id',data_get($order, 'value'))->update([
                "ordering"=>data_get($order, 'order')
            ]);
         }
         $this->updated = true;
      }
     }
  /*
    |--------------------------------------------------------------------------
    |  Features order
    |--------------------------------------------------------------------------
    | updateGroupOrder visivel no me menu
    |
    */
    public function updaterelationshipOrder($data){
        if($data){
            foreach($data as $order){
                if($coluna =  $this->model->columns()->where('id',data_get($order, 'value'))->first()){
                    if($items = data_get($order, 'items')){
                        foreach($items as $item){
                                if($relationships =  $coluna->relationships()->where('id',data_get($item, 'value'))->first()){
                                    $relationships->update([
                                        "ordering"=>data_get($item, 'order')
                                    ]);
                                }
                            }
                        }
                    }
                }
                $this->updated = true;
             }
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

      /*
    |--------------------------------------------------------------------------
    |  Features order
    |--------------------------------------------------------------------------
    | Order visivel no me menu
    |
    */
    public function closeModal(){
        if($this->updated)
            return redirect()->route(config('report.routes.reports.generate'), $this->model);         
     }


    public function view()
    {
        return 'tall-report::includes.ordering-component';
    }
}
