@if (!in_array($item, ['deleted_at', 'id']))
    @if (!\Str::contains($item, 'able_type'))
        @if (!\Str::contains($item, 'able_id'))
            @if (!\Str::contains($item, '_id'))
                @if ($column = sprintf('%s.%s', $name, $item))
                    <div class="flex justify-between items-center  py-2 ">
                        <div class="flex items-center">
                            <input id="{{ $name }}-{{ $item }}"
                                wire:model="checkboxValues.{{ $name }}.{{ $item }}" value="{{ $item }}"
                                type="checkbox"
                                class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                            <label for="{{ $name }}-{{ $item }}" class="ml-3 text-sm text-gray-600">
                                {{ __(\Str::title($item)) }}
                            </label>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    @endif
@endif
