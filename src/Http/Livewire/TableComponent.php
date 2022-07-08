<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\{Collection as BaseCollection, Str};
use WireUi\Traits\Actions;

abstract class TableComponent extends Component
{
    use Actions;

    protected $perPage = 12;

    public $search;

    abstract protected function view();
    

    abstract protected function query();


    protected function layout(){
        if(config("report.layout")){
            return config("report.layout");
        }
        return config('livewire.layout');
    }
       
    public function render(){      
        return view($this->view())->layout($this->layout())->with('models', $this->models());
    }  
    
    /**
     * @return AbstractPaginator|BaseCollection
     * @throws Exception
     */
    protected function models(){

        /** @var Builder|BaseCollection|\Illuminate\Database\Eloquent\Collection $datasource */
        $builder = $this->query();

        return $builder
        ->paginate($this->perPage);
    }

        
    public function kill($value)
    {
        if($value){
            if($this->query()->where('id', $value)->delete()){
                $this->reset(['search']);            
                $this->notification()->success(
                    $title = __('Deleted'),
                    $description = __("Registro excluido com sucesso :)")
                );
            }
       }
    }
}
