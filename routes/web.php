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
    return view('tall-report::welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')->group(function () {
    Route::get('/relatorios',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\ListComponent::class)->name('tall.report.admin.reports');    
    Route::get('/relatorio/cadastrar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\CreateComponent::class)->name('tall.report.admin.report.create');    
    Route::get('/relatorio/{model}/editar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\EditComponent::class)->name('tall.report.admin.report.edit');    
    Route::get('/relatorio/{model}/gerenciar',\Tall\Report\Http\Livewire\Admin\Operacional\Reports\GenerateComponent::class)->name('tall.report.admin.report.generate');    
});
