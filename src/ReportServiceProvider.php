<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component as LivewireComponent;
use Livewire\Livewire;
use Symfony\Component\Finder\Finder;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // if (!$this->app->runningInConsole()){
        //     if(!\Schema::hasTable('tenants')){
        //         return;
        //     }
        // }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
                
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishAssets();
        $this->loadMigrations();

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'report');

        Livewire::component( 'report::list-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\ListComponent::class);
        Livewire::component( 'report::create-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\CreateComponent::class);
        Livewire::component( 'report::edit-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\EditComponent::class);
        Livewire::component( 'report::generate-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\GenerateComponent::class);
        
        Livewire::component( 'report::includes.cell-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\CellComponent::class);
        Livewire::component( 'report::includes.column-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\ColumnComponent::class);
        Livewire::component( 'report::includes.columns-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\ColumnsComponent::class);
        Livewire::component( 'report::includes.filter-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\FilterComponent::class);
        Livewire::component( 'report::includes.filters-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\FiltersComponent::class);
        Livewire::component( 'report::includes.header-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\HeaderComponent::class);
        Livewire::component( 'report::includes.ordering-component', \Tall\Report\Http\Livewire\Admin\Operacional\Reports\Includes\OrderingComponent::class);

        $this->app->register(RouteServiceProvider::class);
    }
    
    /**
     * Publish the config file.
     *
     * @return void
     */
    protected function publishAssets()
    {
    
        $this->publishes([
            __DIR__.'/../public/js/report.js' => public_path('js/report.js'),
            __DIR__.'/../public/css/report.css' => public_path('css/report.css'),
        ], 'tall-assets');
    }
    
    /**
     * Publish the config file.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/report.php','report'
        );
        $this->publishes([
            __DIR__.'/../config/report.php' => config_path('report.php'),
        ], 'report');
    }

    /**
     * Publish the migration files.
     *
     * @return void
     */
    protected function publishMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'report-migrations');
    }

    /**
     * Load our migration files.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        if (config('report.migrate', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

}
