@if (is_string($column))
    @if (!in_array($column, ['deleted_at', 'id']))
        @if (!\Str::contains($column, 'able_type'))
            @if (!\Str::contains($column, 'able_id'))
                @if (!\Str::contains($column, '_id'))
                    <li class="flex justify-between items-center  py-2">
                        <div class="flex items-center">
                            <input id="{{ $column }}-column" wire:model="checkboxValues.{{ $column }}"
                                value="{{ $column }}" type="checkbox"
                                class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                            <label for="{{ $column }}-column" class="ml-3 text-sm text-gray-600">
                                {{ __(\Str::title($column)) }}
                            </label>
                        </div>
                    </li>
                @endif
            @endif
        @endif
    @endif
@endif
