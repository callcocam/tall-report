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

class ColumnsComponent extends FormComponent
{
    use Exportable;
    
    public $cardModal;
    public $updated = false;
    private $schema;
    private $remover;

    public $checkboxValues = [];
    public $ignoreColumns = ["two_factor_recovery_codes",'two_factor_secret','remember_token','email_verified_at'];

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
    |  Features columns
    |--------------------------------------------------------------------------
    | Configuração das columns da tabel o cards de exibição
    |
    */
    public function getColumnsProperty(){
        $columns = [];
       
        if($this->model->exists){     
            $class = \Str::replace('-', '\\', $this->model->model); 
            if(class_exists($class))    
            {
                $table = app($class)->getTable();
                if(empty($this->schema)){
                    $this->makeSchema();
                }
                //dd($this->schema->getTableNames());
                $columns = \Schema::getColumnListing($table);
                $columns["parent"] = $this->generateForeignKeys($table);
            }
        }
        else{
            $this->reset(['data']);
        }

        return $columns;
    }

    /**
     * Generates foreign key migrations.
     *
    * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateForeignKeys($table): array
    {
        $data=[];
       // $foreignKeys = $this->schema->getTableForeignKeys($table);
        $foreignKeys = $this->model->foreigns_table;;
        // if ($foreignKeys->isNotEmpty()) {
        if ($foreignKeys) {
            // foreach($foreignKeys as $foreignKey){
            foreach($foreignKeys as $name){
            // $name = $foreignKey->getForeignTableName();
                if(!in_array($name, config('schema.ignore.tables',[]))){
                    $data[$name] = \Schema::getColumnListing($name);
                }
            }
        }
        return $data;
    }

     /**
     * Get DB schema by the database connection name.
     *
    * @throws \Exception
     */
    protected function makeSchema(): void
    {
        $this->schema = \Tall\Schema\Schema::make();
    }


    public function updatedCheckboxValues($value){
        $this->createColumns($this->remover);
        $this->updated = true;
      }

    public function updatingCheckboxValues($value, $key){
        if(\Str::of($key)->contains('.')){
            $this->remover = \Str::beforeLast($key, '.');
        }
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
        return 'tall-report::includes.columns-component';
    }
}
