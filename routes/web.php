<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/relatorios', function () {
    return view('report::welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')->group(function () {
    Route::get('/relatorios',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\ListComponent::class)->name(config('report.routes.reports.list'));    
    Route::get('/relatorio/cadastrar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\CreateComponent::class)->name(config('report.routes.reports.create'));    
    Route::get('/relatorio/{model}/editar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\EditComponent::class)->name(config('report.routes.reports.edit'));    
    Route::get('/relatorio/{model}/gerenciar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\GenerateComponent::class)->name(config('report.routes.reports.generate'));    
});
