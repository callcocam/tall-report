<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

abstract class FormComponent extends Component
{
    use Actions;    
    public $data = [];
    public $model;
    
    abstract protected function view();

    public function saveAndStay(){
         return $this->submit();
    }

    protected function submit(){
            if ($this->rules())
            $this->validate($this->rules());
            return $this->success();
    }

    protected function success(){
  
        if ($this->model->exists) {
            try {
                if($this->model->update($this->data)){
                    $this->notification()->success(
                        $title = __('SALVOU'),
                        $description = __("Relatório atualizado com sucesso!!")
                    );
                    return true;
                }
                return false;
            } catch (\PDOException $PDOException) {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = $PDOException->getMessage()
                );
                return false;
            }
        } else {
            try {
                $this->model = $this->model->create($this->data);
                if ($this->model->exists) {
                    $this->notification()->success(
                        $title = __('SALVOU'),
                        $description = __("Relatório criado com sucesso!!")
                    );              
                    return $this->saveAndGoBackResponse();
                }
                return false;
            } catch (\PDOException $PDOException) {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = $PDOException->getMessage()
                );
                return false;
            }

        }

    }

     /*
    |--------------------------------------------------------------------------
    |  Features saveAndGoBackResponse
    |--------------------------------------------------------------------------
    | Rota de redirecionamento apos a criação bem sucedida de um novo registro
    |
    */
     /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function saveAndGoBackResponse()
    {
        return redirect()->route('tall.report.admin.report.edit', $this->model);
    }

    protected function rules(){

    }

   
    protected function layout(){
        if(config("report.layout")){
            return config("report.layout");
        }
        return config('livewire.layout');
    }

    /**
     * @param null $model
     */
    protected function setFormProperties($model = null)
    {
        $this->model = $model;
        if ($model) {
            $this->data = $model->toArray();
        } else if (is_array($model)) {
            $this->data = $model;
        }
    }
       
    public function render(){      
        return view($this->view())
        ->with('tables',$this->tables())
        ->with('table_names',$this->tablesNames())
        ->layout($this->layout());
    }
}
