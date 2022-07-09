<div class="px-4 py-5 bg-white space-y-6">
    <div class="md:grid md:grid-cols-12 gap-y-3 gap-x-4">
        <div class="col-span-3 ">
            <x-input wire:model="data.name" label="{{ __('Nome do relatório') }}"
                placeholder="{{ __('Nome do relatório') }}" />
        </div>
        <div class="col-span-3 ">
            <x-select label="{{ __('Modelos') }}" wire:model.defer="data.model"
                placeholder="{{ __('Selecione o modelo') }}" :async-data="route(config('schema.routes.models'))" option-label="name" option-value="id" />
            {{-- <x-native-select label="{{ __('Modelo') }}" wire:model.defer="data.model">
                <option>=={{ __('Selecione') }}==</option>
                @if ($tables)
                    @foreach ($tables as $value => $table)
                        <option value="{{ $value }}">{{ $table }}</option>
                    @endforeach
                @endif
            </x-native-select> --}}
        </div>
        <div class="col-span-6 ">
            <x-select multiselect label="{{ __('Modelos') }}" wire:model.defer="data.foreigns_table"
                placeholder="{{ __('Selecione tabelas relacionadas') }}" option-label="name" option-value="id"
                :async-data="route(config('schema.routes.tables'))" />
            {{-- <x-select multiselect label="{{ __('Modelo') }}" wire:model.defer="data.foreigns_table">
                @if ($table_names)
                    @foreach ($table_names as $value => $table)
                        <x-select.option label="{{ $table }}" value="{{ $value }}" />
                    @endforeach
                @endif
            </x-select> --}}
        </div>
        <div class="col-span-2 ">
            <x-input wire:model="data.freeze_column" label="{{ __('Congelar Coluna') }}" placeholder="0"
                hint="{{ __('ex: D Colunas A até C será fixada') }}" />
        </div>
        <div class="col-span-2 ">
            <x-input wire:model="data.freeze_row" label="{{ __('Congelar Linha') }}" placeholder="0"
                hint="{{ __(' ex: 2 A primeira linha será fixada') }}" />
        </div>
        <div class="col-span-2 ">
            <x-input wire:model="data.zoom_scale" label="{{ __('Zoom Scala') }}" placeholder="150"
                hint="{{ __(' ex: 2 A primeira linha será fixada') }}" />
        </div>
        <div class="col-span-6 flex items-center">
            <div class="my-2 flex space-x-3 h-full w-full items-center">
                <div>
                    <x-radio value="published" lg id="left-label" left-label="{{ __('PUBLICADO') }}"
                        wire:model.defer="data.status_id" />
                </div>
                <div>
                    <x-radio value="draft" lg id="right-label" label="{{ __('RASCUNHO') }}" wire:model.defer="data.status_id" />
                </div>
            </div>
        </div>
    </div>
</div>
