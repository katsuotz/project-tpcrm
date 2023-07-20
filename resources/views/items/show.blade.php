<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $warehouse->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <img src="{{ $item->image_url }}" alt="" class="h-[100px] w-[100px] object-cover">
                            <div>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $item->name }}
                                </h2>
                                <div class="text-sm text-gray-500">
                                    {{ $item->category->name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="flex items-center gap-2">
                                <div class="font-semibold mr-2 {{ $item->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $item->stock }} {{ $item->unit }}
                                </div>
                                <a href="{{ route('logs.add', ['warehouse' => $warehouse, 'item' => $item]) }}">
                                    <x-success-button>
                                        +
                                    </x-success-button>
                                </a>
                                <a href="{{ route('logs.remove', ['warehouse' => $warehouse, 'item' => $item]) }}">
                                    <x-danger-button>
                                        -
                                    </x-danger-button>
                                </a>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-500 text-right">
                                    Total Income: <span class="text-green-500">{{ number_format($item->income, 2) }}</span>
                                </div>
                                <div class="text-sm font-semibold text-gray-500">
                                    Total Expenses: <span class="text-red-500">{{ number_format($item->expenses, 2) }}</span>
                                </div>
                                <div class="text-sm font-semibold text-gray-500 text-right">
                                    Cash Flow: <span class="{{ $item->cash_flow > 0 ? 'text-green-500' : 'text-red-500' }}">{{ number_format($item->cash_flow, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 50px">#</th>
                            <th scope="col" class="px-6 py-3" style="width: 150px;">Image</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Qty</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Income/Expenses</th>
                            <th scope="col" class="px-6 py-3">Time</th>
                            <th scope="col" class="px-6 py-3" style="width: 220px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($logs->count())
                            @foreach($logs as $key => $log)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        @if($log->image)
                                            <a href="{{ $log->image_url }}" target="_blank">
                                                <img src="{{ $log->image_url }}" alt="" class="h-[100px] w-[100px] object-cover">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold whitespace-nowrap {{ $log->type == 'add' ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $log->type_label }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $log->qty }}
                                        {{ $item->unit }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        {{ number_format($log->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        @if($log->price)
                                            {{ $log->type == 'add' ? '-' : '+' }}{{ number_format($log->price * $log->qty, 2) }}
                                            <div class=" {{ $log->type == 'remove' ? 'text-green-500' : 'text-red-500' }}">
                                                ({{ $log->type == 'add' ? 'Expenses' : 'Income' }})
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        {{ $log->created_at->format('d F Y, H:i') }}
                                        @if($log->updated_at)
                                        <div class="text-xs text-gray-500">
                                            Updated at: {{ $log->updated_at->format('d F Y, H:i') }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <a href="{{ route('logs.edit', ['warehouse' => $warehouse, 'item' => $item, 'log' => $log]) }}">
                                                <x-warning-button>
                                                    {{ __('Edit') }}
                                                </x-warning-button>
                                            </a>
                                            <form method="post" action="{{ route('logs.destroy', ['warehouse' => $warehouse, 'item' => $item, 'log' => $log]) }}">
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
</x-app-layout>
