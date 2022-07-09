<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes;


use Tall\Report\Models\Report;
use Tall\Report\Http\Livewire\FormComponent;
use Tall\Report\Traits\ColumnsTrait;
use Tall\Report\Traits\Exportable;

class FiltersComponent extends FormComponent
{
    use ColumnsTrait,Exportable;
    
    public $localColumns = [];
    public $tableName;
    public $cardModal;
    private $schema;
    public $updated = false;
    
    public $listeners = ['setUpdated'];

    public function setUpdated()
    {
       $this->updated = true;
    }
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
                $this->tableName = $table;
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
        $foreignKeys = $this->schema->getTableForeignKeys($table);
        if ($foreignKeys) {
            foreach($foreignKeys as $foreignKey){
                if($localColumns = $foreignKey->getLocalColumns()){
                    $data_loadcolumns=[];
                    foreach($localColumns as $localColumn){
                        $this->localColumns[$localColumn] = [
                            "column"=>$localColumn,
                            "table"=>$foreignKey->getForeignTableName()
                        ];
                    }
                }
            }
        }
      
        $foreignKeys = $this->model->foreigns_table;
        // if ($foreignKeys->isNotEmpty()) {
        if ($foreignKeys) {
            // foreach($foreignKeys as $foreignKey){
            foreach($foreignKeys as $name){
            // $name = $foreignKey->getForeignTableName();
                if(!in_array($name, $this->getIgnoreTables())){
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
  /*
    |--------------------------------------------------------------------------
    |  Features fields
    |--------------------------------------------------------------------------
    | Inicia a configuração do campos disponiveis no formulario
    |
    */
    protected function fields(): array
    {
        return [
           
        ];
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
        return 'tall-report::includes.filters-component';
    }
}
