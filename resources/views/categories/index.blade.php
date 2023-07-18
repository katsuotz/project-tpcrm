<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Category') }}
            </h2>
            <a href="{{ route('categories.create') }}">
                <x-primary-button>
                    + {{ __('New Category') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 50px">#</th>
                            <th scope="col" class="px-6 py-3">Category Name</th>
                            <th scope="col" class="px-6 py-3" style="width: 220px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($categories->count())
                            @foreach($categories as $key => $category)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('categories.edit', $category) }}">
                                                <x-warning-button>
                                                    {{ __('Edit') }}
                                                </x-warning-button>
                                            </a>
                                            <form method="post" action="{{ route('categories.destroy', $category) }}">
                                                @csrf
                                                @method('delete')
                                                <x-danger-button>
                                                    {{ __('Delete') }}
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="bg-white border-b">
                                <th colspan="3" scope="row" class="px-6 py-4 text-center">
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
</x-app-layout>
