<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Warehouse') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ @$warehouse ? 'Edit' : 'New' }} Warehouse
                            @if(@$warehouse)
                                - {{ $warehouse->name }}
                            @endif
                        </h2>
                    </header>

                    <form method="post" action="{{ @$warehouse ? route('warehouses.update', $warehouse) : route('warehouses.store') }}" class="space-y-6">
                        @csrf
                        @if(@$warehouse)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', @$warehouse->name) }}"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" value="{{ old('city', @$warehouse->city) }}"/>
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('warehouses.index') }}">
                                <x-secondary-button type="button">{{ __('Cancel') }}</x-secondary-button>
                            </a>
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
