<div class="hidden sm:block ml-3">
    <x-modal.card max-width="sm" title="{{ __('Ordernar colunas') }} - {{ $model->name }}" blur="md" squared
        x-on:close="$wire.closeModal()" wire:model.defer="cardModal">
        <div class="flex flex-col space-y-2 h-96">
            <div class="flex justify-center w-full overflow-y-scroll">
                <form class="mt-4 w-full border-t border-gray-200 p-2">
                    <h3 class="sr-only">Colunas</h3>
                    @if ($columns = array_filter($this->columns))
                        <ul role="list" class="font-medium text-gray-900 px-2 py-3">
                            @foreach ($columns as $column)
                                @include('tall-report::partials.selecteds')
                            @endforeach
                        </ul>
                        @if ($parents = data_get($columns, 'parent'))
                            @foreach ($parents as $name => $parent)
                                <div x-data="{ item: false }" class="border-t border-gray-200 px-4 py-6">
                                    <h3 class="-mx-2 -my-3 flow-root">
                                        <!-- Expand/collapse section button -->
                                        @include('tall-report::partials.collapse')
                                    </h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-mobile-0" x-show="item">
                                        <div class="space-y-2">
                                            @foreach ($parent as $item)
                                                @include('tall-report::partials.selecteds-mobile-item')
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <span class="hidden sm:block">
        <button type="button" wire:click="openModal"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
            </svg>
            {{ __('Colunas') }}
        </button>
    </span>
</div>
