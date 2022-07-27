<div>
    <x-modal.card hide-close blur wire:model.defer="cardModal">
        <div class="flex flex-col space-y-2">
            <div>
                @livewire('report::includes.header-component', compact('column', 'name', 'model'), key(sprintf('header-%s', $model->id)))
            </div>
            <div>
                @livewire('report::includes.cell-component', compact('column', 'name', 'model'), key(sprintf('cell-%s', $model->id)))
            </div>
        </div>
    </x-modal.card>
    <button type="button" wire:click="openModal">
        <x-icon name="pencil-alt" class="w-5 h-5" style="solid" />
    </button>
</div>
