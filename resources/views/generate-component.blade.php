<div class="flex-1 h-screen p-5">
    <div class="flex flex-col">
        <div class="recent-activity block">
            <div class="w-full py-2">
                <x-slot name="header">
                    <!-- Section Hero -->
                    @include('report::header', ['label' => 'Gerenciar'])
                </x-slot>
            </div>
            <div class="flex flex-col">
                <div class="mt-5 md:mt-0">
                    <div class="block border-4 border-dashed border-gray-200  p-2 rounded-lg h-96  lg:h-full z-20">
                        @include('report::partials.header')
                        @if ($selecteds = array_filter($checkboxValues))
                            @if ($models = $this->models)
                                <div class="flex flex-col">
                                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="overflow-hidden">
                                                @if (array_filter($selecteds))
                                                    <table class="w-full text-left lg:max-h-[500px]">
                                                        @include('report::partials.table.thead')
                                                        <tbody class="w-full overflow-y-scroll">
                                                            @foreach ($models as $model)
                                                                <tr class="bg-white border-b w-full">
                                                                    @foreach ($selecteds as $name => $items)
                                                                        @if (is_string($items))
                                                                            <td
                                                                                class="px-6 py-2 text-sm font-medium text-gray-900">
                                                                                {{ data_get($model, $items) }}
                                                                            </td>
                                                                        @else
                                                                            @if ($selecteds_items = array_filter($items))
                                                                                @foreach ($selecteds_items as $item)
                                                                                    <td
                                                                                        class="px-6 py-2 text-sm font-medium text-gray-900">
                                                                                        {{ data_get($model, sprintf('%s.%s', $name, $item)) }}
                                                                                    </td>
                                                                                @endforeach
                                                                            @endif
                                                                        @endif
                                                                    @endforeach

                                                                </tr>
                                                            @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
