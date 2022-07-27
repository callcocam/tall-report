<div class="hidden sm:block ml-3">
    <x-modal.card maxWidth="4xl" title="{{ __('Filtros columns') }} - {{ $model->name }}" blur="md" squared
        x-on:close="$wire.closeModal()" wire:model.defer="cardModal">
        <div class="flex flex-col space-y-2 h-96">
            <div class="flex justify-center w-full overflow-y-scroll">
                <form class="mt-4 w-full border-t border-gray-200 p-2">
                    <h3 class="sr-only">Colunas</h3>
                    @if ($columns = $this->columns)
                        <ul class="bg-white rounded-lg text-gray-900 space-y-2  w-full">
                            @if ($columns = $this->columns)
                                <li class=" w-full rounded ">
                                    <div class="flex justify-between items-center px-6 py-2 bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="-ml-1 mr-2 h-5 w-5 text-gray-500 cursor-pointer" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        <span
                                            class="text-2xl font-bold uppercase">{{ \Str::afterLast($model->model, '\\') }}</span>
                                    </div>
                                </li>
                                @if ($columns = array_filter($this->columns))
                                    <ul role="list" class="font-medium text-gray-900 px-2 py-3 space-y-2">
                                        @foreach ($columns as $column)
                                            @if (is_string($column))
                                                @if (!in_array($column, ['two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'deleted_at', 'current_team_id', 'email_verified_at', 'password']))
                                                    @if (!\Str::contains($column, 'able_type'))
                                                        @if (!\Str::contains($column, 'able_id'))
                                                            @if ($name = $tableName)
                                                                @if ($options = data_get($this->localColumns, $column))
                                                                    @livewire('report::includes.filter-component', compact('model', 'column', 'name', 'options'), key($column))
                                                                @else
                                                                    @livewire('report::includes.filter-component', compact('model', 'column', 'name'), key($column))
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                    @if ($parents = data_get($columns, 'parent'))
                                        @foreach ($parents as $name => $parent)
                                            <div x-data="{ item: false }" class="border-t border-gray-200 px-4 py-3">
                                                <h3 class="-mx-2 -my-3 flow-root">
                                                    <!-- Expand/collapse section button -->
                                                    <button type="button" @click="item = !item"
                                                        class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500"
                                                        aria-controls="filter-section-0" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="-ml-1 mr-2 h-5 w-5 text-gray-500 cursor-pointer"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                                        </svg> <span class="text-xl font-bold uppercase">
                                                            {{ __(\Str::title($name)) }} </span>
                                                        <span class="ml-6 flex items-center">
                                                            @include('report::partials.plus')
                                                            @include('report::partials.minus')
                                                        </span>
                                                    </button>
                                                </h3>
                                                <!-- Filter section, show/hide based on section state. -->
                                                <div class="pt-6" id="filter-section-mobile-0" x-show="item">
                                                    <div class="space-y-2">
                                                        @foreach ($parent as $item)
                                                            @if (is_string($item))
                                                                @if (!in_array($item, ['two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'deleted_at', 'current_team_id', 'email_verified_at', 'password']))
                                                                    @if (!\Str::contains($item, 'able_type'))
                                                                        @if (!\Str::contains($item, 'able_id'))
                                                                            {{-- @if (!\Str::contains($item, '_id')) --}}
                                                                            @if ($column = $item)
                                                                                @if ($options = data_get($this->localColumns, $column))
                                                                                    @livewire('report::includes.filter-component', compact('model', 'column', 'name', 'options'), key(sprintf('%s.%s', $name, $column)))
                                                                                @else
                                                                                    @livewire('report::includes.filter-component', compact('model', 'column', 'name'), key(sprintf('%s.%s', $name, $column)))
                                                                                @endif
                                                                            @endif
                                                                            {{-- @endif --}}
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            @endif
                    @endif

                </form>

            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button negative flat label="{{ __('Finalizar Operação') }}" x-on:click="close" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
    <span class="hidden sm:block ml-3">
        <button type="button" wire:click="openModal"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            {{ __('Filtros') }}
        </button>
    </span>
</div>
