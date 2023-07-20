<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item') }} - {{ $warehouse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ @$item ? 'Edit' : 'New' }} Item
                            @if(@$item)
                                - {{ $item->name }}
                            @endif
                        </h2>
                    </header>

                    <form method="post" action="{{ @$item ? route('items.update', ['warehouse' => $warehouse, 'item' => $item]) : route('items.store', $warehouse) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if(@$item)
                            @method('put')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', @$item->name) }}"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="category" id="category">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category', @$item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Unit (Optional)')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" value="{{ old('unit', @$item->unit) }}" placeholder="eg: Kg, g;"/>
                            <x-input-error :messages="$errors->get('unit')" class="mt-2" />
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
