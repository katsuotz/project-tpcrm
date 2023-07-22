<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $warehouse->name }}
            </h2>
            <a href="{{ route('items.create', $warehouse) }}">
                <x-primary-button>
                    + {{ __('New Item') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="" class="flex justify-between mb-4" id="form-search">
                <x-select-input id="category" class="w-[200px]" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </x-select-input>
                <x-text-input id="search" class="w-[200px]" type="text" name="search" placeholder="Search..." value="{{ $search }}"/>
            </form>
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 50px">#</th>
                            <th scope="col" class="px-6 py-3" style="width: 150px;">Image</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Stock</th>
                            <th scope="col" class="px-6 py-3">Expenses</th>
                            <th scope="col" class="px-6 py-3">Income</th>
                            <th scope="col" class="px-6 py-3" style="width: 220px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($items->count())
                            @foreach($items as $key => $item)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        @if($item->image)
                                            <img src="{{ $item->image_url }}" alt=""
                                                 class="h-[100px] w-[100px] object-cover">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $item->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $item->stock }}
                                        {{ $item->unit }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-red-500 whitespace-nowrap">
                                        {{ number_format($item->expenses, 2) }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-green-500 whitespace-nowrap">
                                        {{ number_format($item->income, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('logs.add', ['warehouse' => $warehouse, 'item' => $item]) }}">
                                                <x-success-button class="whitespace-nowrap">
                                                    {{ __('+') }}
                                                </x-success-button>
                                            </a>
                                            <a href="{{ route('logs.remove', ['warehouse' => $warehouse, 'item' => $item]) }}">
                                                <x-danger-button class="whitespace-nowrap">
                                                    {{ __('-') }}
                                                </x-danger-button>
                                            </a>

                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <x-secondary-button>
                                                        ...
                                                    </x-secondary-button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('items.show', ['warehouse' => $warehouse, 'item' => $item])">
                                                        {{ __('Detail') }}
                                                    </x-dropdown-link>

                                                    <x-dropdown-link :href="route('items.edit', ['warehouse' => $warehouse, 'item' => $item])">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>

                                                    <form method="post" action="{{ route('items.destroy', ['warehouse' => $warehouse, 'item' => $item]) }}">
                                                        @csrf
                                                        @method('delete')

                                                        <x-dropdown-link :href="route('items.destroy', ['warehouse' => $warehouse, 'item' => $item])" onclick="event.preventDefault();this.closest('form').submit();">
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b">
                                <th colspan="8" scope="row" class="px-6 py-4 text-center">
                                    No Data
                                </th>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <script>
            const category = document.querySelector('#category')
            const form = document.querySelector('#form-search')

            category.onchange = function () {
                form.submit()
            }
        </script>
    </x-slot>
</x-app-layout>
