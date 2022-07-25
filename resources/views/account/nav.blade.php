<x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ __('Dashboard') }}
</x-jet-nav-link>
@if (function_exists('routeTenant'))
    <x-jet-nav-link href="{{ route(routeTenant()) }}" :active="request()->routeIs(routeTenant())">
        {{ __('Tenants') }}
    </x-jet-nav-link>
@endif
