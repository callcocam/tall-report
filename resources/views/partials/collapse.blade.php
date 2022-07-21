<button type="button" @click="item = !item"
    class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500"
    aria-controls="filter-section-0" aria-expanded="false">
    <span class="font-medium text-gray-900">
        {{ __(\Str::title($name)) }} </span>
    <span class="ml-6 flex items-center">
        @include('tall-report::partials.plus')
        @include('tall-report::partials.minus')
    </span>
</button>
