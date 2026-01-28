<div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
        <p class="text-gray-500 text-sm mt-1">{{ count($cartItems) }} items in your cart</p>
    </div>

    @if(count($cartItems) > 0)
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Cart Items List (Left) -->
        <div class="w-full lg:w-2/3 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden relative">
            
            {{-- Loading Overlay --}}
            <div wire:loading.flex class="absolute inset-0 bg-white/50 z-10 justify-center items-center">
                <svg class="w-10 h-10 animate-spin text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            @foreach($cartItems as $item)
            <div class="p-6 flex items-center justify-between border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition">
                <div class="flex items-center gap-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->brand }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-medium text-lg text-gray-900">{{ $item->product->brand }} {{ $item->product->model }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ ucfirst($item->product->material) }}</p>
                        <p class="text-gray-900 font-semibold mt-2">${{ number_format($item->product->price, 2) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                        <span class="font-bold text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                        
                        {{-- Livewire Delete Button --}}
                        <button wire:click="remove({{ $item->id }})" 
                                wire:confirm="Are you sure you want to remove this item?"
                                class="text-red-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Order Summary (Right) -->
            <div class="w-full lg:w-1/3">
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 pb-4 border-b border-gray-100">Order Summary</h2>
                
                <div class="flex justify-between items-center mb-6">
                    <span class="text-gray-600 font-medium text-lg">Total</span>
                    <span class="text-2xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-md transition mb-4 shadow-sm">
                    Proceed to Checkout
                </a>
                
                <div class="text-center">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Continue Shopping</a>
                </div>
            </div>
            </div>

    </div>
    @else
        <div class="text-center py-24 bg-white rounded-lg shadow-sm border border-gray-100">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition">
                Start Shopping
            </a>
        </div>
    @endif
</div>
