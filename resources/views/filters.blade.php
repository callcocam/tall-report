<tr class="p-2 flex-1 w-full">
    <th>
        <div class="flex items-center justify-start  px-2 z-40">
            <div class="relative inline-block text-left" x-data="wireui_dropdown"
                x-on:click.outside="close" x-on:keydown.escape.window="close">
                <div class="cursor-pointer focus:outline-none" x-on:click="toggle">
                    <button
                        class="rounded-l-sm border-0 text-white bg-indigo-500 flex items-center p-2">
                        <svg class="h-5 w-5 animate-pulse"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                </div>
                <div x-show="status"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="origin-top-left left-0 w-48 absolute mt-2 whitespace-nowrap z-40"
                    wire:model="filters.name.key" style="display: none;"
                    x-on:click="close">
                    <div
                        class="relative max-h-60 soft-scrollbar overflow-auto border border-secondary-200
                        rounded-lg shadow-lg p-1 bg-white dark:bg-secondary-800 dark:border-secondary-600">
                        <a class="text-secondary-600 px-4 py-2 text-sm flex items-center cursor-pointer rounded-md transition-colors duration-150 hover:text-secondary-900 hover:bg-secondary-100 dark:text-secondary-400 dark:hover:bg-secondary-700"
                            wire:click="$set('filters.name.key','is')">
                            <svg class="w-5 h-5 mr-2"
                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            É exatamente
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="relative rounded-md  shadow-sm ">
                    <input type="text"
                        autocomplete="off"
                        class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm pr-8 rounded-l-sm rounded-r-none"
                        wire:model.debounce.500ms="filters.name.value"
                        placeholder="Contém" name="filters.name.value">
                    <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-secondary-400">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </th>
    <th>
    </th>
    <th>
    </th>
    <th class="px-2 py-3 flex items-center justify-between space-x-2">
        <x-input wire:model="filters.search" placeholder="{{ __('Search...')}}" />
        <a href="{{ route('tall.report.admin.report.create') }}"
            class="bg-green-500 text-white w-8 h-8 items-center justify-center flex">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </a>
    </th>
</tr>