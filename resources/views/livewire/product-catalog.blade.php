<div>
    {{-- Top Bar: Search & Sort --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div class="w-full md:w-1/2 relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products..." class="w-full bg-gray-200 border-none rounded-sm py-3 px-4 pl-12 text-gray-700 focus:ring-0 focus:bg-white transition placeholder-gray-500">
            <svg class="w-5 h-5 absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('cart.index') }}" class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-3 px-6 rounded-sm flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                View Cart
            </a>
            <a href="{{ route('favorites.index') }}" class="p-3 text-gray-500 hover:text-gray-900 border border-transparent hover:border-gray-300 rounded-sm transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-12">
        {{-- Sidebar: Filters --}}
        <aside class="w-full md:w-1/4 space-y-8">
            
            <div>
                <h3 class="flex items-center gap-2 text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                </h3>
                
                {{-- Applied Filters (Optional: Can be enhanced later) --}}
                @if(count($selectedBrands) > 0 || count($selectedTypes) > 0)
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Applied Filters</span>
                        <button wire:click="$set('selectedBrands', []); $set('selectedTypes', [])" class="text-xs text-gray-400 hover:text-black underline">clear all</button>
                    </div>
                </div>
                @endif

                {{-- Brand Filter --}}
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex justify-between cursor-pointer">
                        Brand
                    </h4>
                    <div class="space-y-2">
                        @foreach($brands as $brand)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model.live="selectedBrands" value="{{ $brand }}" class="rounded border-gray-300 text-black focus:ring-0">
                            <span class="text-sm text-gray-600 group-hover:text-black transition">{{ $brand }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Gender Filter --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 mb-3 flex justify-between cursor-pointer">
                        Gender
                    </h4>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model.live="selectedTypes" value="men" class="rounded border-gray-300 text-black focus:ring-0">
                            <span class="text-sm text-gray-600 group-hover:text-black transition">Men</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model.live="selectedTypes" value="women" class="rounded border-gray-300 text-black focus:ring-0">
                            <span class="text-sm text-gray-600 group-hover:text-black transition">Women</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="w-full md:w-3/4">
            <h2 class="text-2xl font-serif italic text-gray-900 mb-8">"Our Products"</h2>
            
            <div class="relative">
                {{-- Loading Indicator --}}
                <div wire:loading.flex class="absolute inset-0 bg-white/50 z-10 justify-center items-start pt-20">
                    <svg class="w-10 h-10 animate-spin text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($products as $product)
                    <div class="group">
                        <div class="bg-transparent mb-4 overflow-hidden relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->brand }} {{ $product->model }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                            <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                                @csrf
                                <button type="submit" class="p-2 bg-white/80 rounded-full text-gray-500 hover:text-red-500 hover:bg-white transition">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="text-center">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-amber-700 transition">{{ $product->brand }} {{ $product->model }}</h3>
                            <div class="flex justify-center items-center gap-3 mt-1 mb-3">
                                <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product->id) }}" class="text-xs text-gray-500 italic hover:underline">View Details</a>
                            </div>
                            <form action="{{ route('cart.store', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-900 text-white py-2 text-sm font-medium uppercase tracking-wide hover:bg-black transition flex justify-center items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add To Cart
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        No products found matching your criteria.
                    </div>
                    @endforelse
                </div>
            </div>
            
            {{-- Pagination (Visual) --}}
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</div>
