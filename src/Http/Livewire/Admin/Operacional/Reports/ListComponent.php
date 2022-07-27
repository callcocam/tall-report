<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Http\Livewire\Admin\Operacional\Reports;

use Tall\Report\Http\Livewire\Traits\LivewireInfo;
use Tall\Report\Http\Livewire\TableComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tall\Report\Models\Report;

class ListComponent extends TableComponent
{
    use LivewireInfo;
    use AuthorizesRequests;
    
    public function mount()
    {
        if(\Schema::hasTable('roles')){
            $this->authorize(Route::currentRouteName());
        }     
    }
    /*
    |--------------------------------------------------------------------------
    |  Features query
    |--------------------------------------------------------------------------
    | Inicia a consulta ao banco de dados
    |
    */
    protected function query()
    {
        return Report::query();
    }

    protected function view()
    {

        return 'report::list-component';
    }
}
