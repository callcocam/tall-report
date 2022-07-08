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

class HeaderComponent extends FormComponent
{
    use ColumnsTrait, Exportable;
     /*
    |--------------------------------------------------------------------------
    |  Features mount
    |--------------------------------------------------------------------------
    | Inicia o formulario com um cadastro selecionado
    |
    */
    public function mount(?Report $model, $column, $name)
    {
        $column = $model->columns()->where('name', $name)->first();

        if($relationship = $column->relationships()->where('name', $column)->first()){
            $this->setFormProperties($relationship->header); 
        }
        else{
            $this->setFormProperties($column->header);   
        }
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
            Input::make('Label','label')->span(5)->rules('required'),
            Input::make('Largura','width')->span(3),
            Input::make('Fonte','attribute.font_name')->span(4)->rules('required'),
            Toggle::make('Bold','attribute.bold')->lg()->span(3),
            Toggle::make('Italic','attribute.italic')->lg()->span(3),
            Toggle::make('Strikethrough','attribute.strikethrough')->lg()->span(3),
            Toggle::make('Underline','attribute.underline')->lg()->span(3),
            NativeSelect::make('Tamanho da Fonte','attribute.font_size')
            ->options($this->fontSize())
            ->span(4),
            ColorPicker::make('Cor da fonte','attribute.font_color')
            ->colors($this->colors())
            ->span(4),
            ColorPicker::make('Cor de fundo','attribute.background_color')
            ->colors($this->colors())
            ->span(4),
            NativeSelect::make('Alinhameto','attribute.alignment')
            ->options([
                'left'=>'LEFT','right'=>'RIGTH','justify'=>'JUSTIFY','center'=>'CENTER'
            ])->span(4)->rules('required'),
            NativeSelect::make('Alinhameto Vertical','attribute.vertical_alignment')            
            ->options([
                'auto'=>'AUTO',
                'baseline'=>'BASELINE',
                'bottom'=>'BOTTOM',
                'center'=>'CENTER',
                'distributed'=>'DISTRIBUTED',
                'justify'=>'JUSTIFY',
                'top'=>'TOP'
            ])->span(4)->rules('required'),
            Toggle::make('Quebrar texto','attribute.wrap_text')->mt(8)->span(4)->lg()->rules('required'),
            Radio::make('Status', 'status_id')->status()->lg()
        ];
    }

    public function view()
    {
        return 'tall-report::includes.header-component';
    }
}
