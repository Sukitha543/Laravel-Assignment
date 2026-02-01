<div>
    <div class="p-6 bg-white border-b border-gray-200">
        
        <!-- Filter Section -->
        <div class="mb-6 flex flex-col md:flex-row gap-4 items-center p-4 bg-gray-50 rounded-lg justify-between shadow-sm">
            <div class="flex flex-wrap gap-4 items-center w-full md:w-auto">
                <span class="font-semibold text-gray-700">Filter:</span>
                
                <label class="inline-flex items-center cursor-pointer hover:bg-gray-200 p-2 rounded transition">
                    <input type="checkbox" wire:model.live="filterAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-600 font-medium text-sm">All</span>
                </label>

                <label class="inline-flex items-center cursor-pointer hover:bg-green-100 p-2 rounded transition">
                    <input type="checkbox" wire:model.live="filterAccepted" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-600 font-medium text-sm">Accepted</span>
                </label>

                <label class="inline-flex items-center cursor-pointer hover:bg-blue-100 p-2 rounded transition">
                    <input type="checkbox" wire:model.live="filterUnaccepted" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-600 font-medium text-sm">Paid</span>
                </label>

                <label class="inline-flex items-center cursor-pointer hover:bg-red-100 p-2 rounded transition">
                    <input type="checkbox" wire:model.live="filterRejected" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <span class="ml-2 text-gray-600 font-medium text-sm">Rejected</span>
                </label>

                {{-- Loading Indicator --}}
                <span wire:loading class="ml-2 text-indigo-600 text-sm font-medium">Updating...</span>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-auto">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search Order ID..." 
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full md:w-80">
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Orders Table -->
        <div class="overflow-x-auto relative">
            <div wire:loading.flex wire:target="filterAll, filterAccepted, filterUnaccepted, filterRejected, accept, reject, search" class="absolute inset-0 bg-white/50 z-10 justify-center items-start pt-10">
                <svg class="w-8 h-8 animate-spin text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 font-bold">Order ID</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-bold">Name</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-bold">Email</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-bold">Contact Number</th>
                        <th class="px-4 py-2 text-left text-gray-600 font-bold">Address</th>
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
                            <td class="px-4 py-3 align-top">{{ $order->shippingDetail->name ?? ($order->user->name ?? 'N/A') }}</td>
                            <td class="px-4 py-3 align-top">{{ $order->shippingDetail->email ?? ($order->user->email ?? 'N/A') }}</td>
                            <td class="px-4 py-3 align-top">{{ $order->shippingDetail->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-3 align-top text-sm">
                                @if($order->shippingDetail)
                                    <div>{{ $order->shippingDetail->address }}</div>
                                    <div class="text-gray-500">{{ $order->shippingDetail->city }}</div>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="space-y-3">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="Product Image" class="w-12 h-12 object-cover rounded border border-gray-200">
                                            @else
                                                <div class="w-12 h-12 bg-gray-100 rounded border border-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                                    N/A
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->product->brand ?? 'Unknown' }} {{ $item->product->model ?? 'Product' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top font-semibold">
                                ${{ number_format($order->total_price, 2) }}
                            </td>
                            <td class="px-4 py-3 align-top">
                                @if($order->status === 'accepted')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @elseif($order->status === 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="flex gap-2">
                                    @if($order->status === 'paid' || $order->status === 'pending')
                                        <button wire:click="accept({{ $order->id }})" 
                                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out">
                                            Accept
                                        </button>

                                        <button wire:click="reject({{ $order->id }})" 
                                            wire:confirm="Are you sure you want to reject this order? Value of items will be added back to inventory."
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out">
                                            Reject
                                        </button>
                                    @endif
                                    
                                    {{-- Optional: Allow rejection of accepted orders? Usually yes, but with caution --}}
                                    @if($order->status === 'accepted')
                                         <button wire:click="reject({{ $order->id }})" 
                                            wire:confirm="Are you sure you want to reject this previously accepted order?"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out">
                                            Reject
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                                No orders found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
