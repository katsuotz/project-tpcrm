<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $item->name }} - {{ $warehouse->name }}
            @if(@$log)
                - {{ $log->created_at->format('d F Y, H:i') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ $type == 'add' ? 'Buy / Add' : 'Sell / Remove' }} {{ __('Stock') }}
                        </h2>
                    </header>

                    <form method="post" action="{{ @$log ? route('logs.update', ['warehouse' => $warehouse, 'item' => $item, 'log' => $log]) : route('logs.store', ['warehouse' => $warehouse, 'item' => $item]) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if(@$log)
                            @method('put')
                        @endif
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div>
                            <x-input-label for="qty" :value="__('Quantity ' . ($item->unit ?'(' . $item->unit . ')' : ''))" />
                            <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full" value="{{ old('qty', @$log->qty) }}"/>
                            <x-input-error :messages="$errors->get('qty')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price (Optional)')" />
                            <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" value="{{ old('price', @$log->price) }}"/>
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Image (Optional)')" />
                            <input class="mt-1 block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="image" id="image" type="file" accept="image/jpeg,image/png">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('items.index', $warehouse) }}">
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
