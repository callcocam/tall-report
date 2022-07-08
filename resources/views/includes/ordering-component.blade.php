<div class="hidden sm:block ml-3">
    <x-modal.card max-width="sm" title="{{ __('Ordernar colunas') }} - {{ $model->name }}" blur squared x-on:close="$wire.closeModal()"
        wire:model.defer="cardModal">
        <div class="flex flex-col space-y-2">
            <div class="flex justify-center w-full overflow-hidden">
                <ul class="bg-white rounded-lg w-96 text-gray-900 space-y-2  overflow-hidden" wire:sortable="updateColunaOrder"
                    wire:sortable-group="updaterelationshipOrder">
                    @if ($colunas = $this->colunas)
                        @foreach ($colunas as $coluna)
                            <li class="px-6 py-2 bg-gray-200 w-full rounded cursor-pointer "
                                wire:key="group-{{ $coluna->id }}" wire:sortable.item="{{ $coluna->id }}">
                                <div class="flex justify-between items-center">
                                    <svg wire:sortable.handle xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                    <span>{{ $coluna->name }}</span>
                                </div>
                                @if ($relationships = $coluna->relationships)
                                    <ul wire:sortable-group.item-group="{{ $coluna->id }}">
                                        @foreach ($relationships as $relationship)
                                            <li class="px-6 py-2 bg-gray-200 w-full rounded cursor-pointer"
                                                wire:key="task-{{ $relationship->id }}"
                                                wire:sortable-group.item="{{ $relationship->id }}">
                                                <div class="flex justify-between items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                                    </svg>
                                                    <span>{{ $coluna->name }} - {{ $relationship->name }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
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
    <button type="button" wire:click="openModal"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
        </svg>
        {{ __('Ordenar') }}
    </button>
</div>
