<div class="w-full">
    <div class="flex w-full justify-between items-center px-6 py-2 bg-gray-200">
       
         <form class="grid grid-cols-1 sm:grid-cols-7 gap-2 flex-1">
            <div class="col-span-1 sm:col-span-2 flex flex-col">
                <x-native-select label="{{ $column }}" wire:model.defer="data.filter.operador">
                    @foreach ($this->filter_options as $key => $option)
                        <option value="{{ $key }}">{{ $option }}</option>
                    @endforeach
                </x-native-select>
                @error('operador') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            @if ($values = $this->values)
                <div class="col-span-1 sm:col-span-3">
                    <x-native-select label="{{ $column }}" wire:model.defer="data.filter.value">
                        <option value="">{{ __("Selecione") }}</option>
                        @foreach ($values as $key => $option)
                            <option value="{{ $key }}">{{ $option }}</option>
                        @endforeach
                    </x-native-select>
                </div>
                <div class="flex items-end space-x-1 col-span-1 mb-2">
                    <x-toggle class="mx-auto" label="{{ __('Nulo') }}" lg wire:model.defer="data.filter.nulo" />
                </div>
            @else
                <div class="col-span-1 sm:col-span-4">
                    <x-input label="{{ __('Valor') }}" placeholder="{{ __('Valor') }}"
                        wire:model.defer="data.filter.value" />
                </div>
            @endif
            <div class="flex items-end space-x-1 col-span-4 sm:col-span-1 mb-1">
                @if (data_get($data, 'filter'))
                    <x-button wire:click="editFilter" positive icon="check" />
                    <x-button negative wire:click="removeFilter" icon="x" />
                @else
                    <x-button wire:click="createFilter" positive icon="plus" />
                @endif
            </div>
        </form>
    </div>
</div>
