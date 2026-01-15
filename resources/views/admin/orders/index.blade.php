<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Filter Section -->
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6 flex flex-wrap gap-4 items-center p-4 bg-gray-50 rounded-lg">
                        <span class="font-semibold text-gray-700">Filter Orders:</span>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_accepted" value="1" 
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ request('filter_accepted') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-600">Accepted Orders</span>
                        </label>

                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_unaccepted" value="1" 
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ request('filter_unaccepted') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-600">Not Accepted Orders</span>
                        </label>

                        <label class="inline-flex items-center">
                            <input type="checkbox" name="filter_all" value="1" 
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                {{ request('filter_all') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-600">All Orders</span>
                        </label>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Apply Filter
                        </button>
                        
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                            Reset
                        </a>
                    </form>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Order ID</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Name</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Email</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Ordered Products</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Total Cost</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Status</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 align-top">{{ $order->id }}</td>
                                        <td class="px-4 py-3 align-top">{{ $order->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 align-top">{{ $order->user->email ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 align-top">
                                            <ul class="list-disc list-inside text-sm text-gray-600">
                                                @foreach($order->items as $item)
                                                    <li>
                                                        {{ $item->product->brand ?? 'Unknown' }} {{ $item->product->model ?? 'Product' }}
                                                        (x{{ $item->quantity }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-4 py-3 align-top font-semibold">
                                            ${{ number_format($order->total_price, 2) }}
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            @if($order->status === 'accepted')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Accepted
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 align-top">
                                            <div class="flex gap-2">
                                                @if($order->status !== 'accepted')
                                                    <form method="POST" action="{{ route('admin.orders.accept', $order) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out">
                                                            Accept
                                                        </button>
                                                    </form>
                                                @endif

                                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                            No orders found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
