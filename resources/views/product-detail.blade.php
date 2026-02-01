@extends('layouts.main')

@section('title', $product->brand . ' ' . $product->model . ' - TimeBridge')
@section('body-class', 'bg-gray-50')

@section('content')
    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-6">
        
        <!-- Product Card/Modal Container -->
        <div class="bg-white w-full max-w-5xl rounded-xl shadow-2xl overflow-hidden relative flex flex-col md:flex-row min-h-[600px]">
            
            <!-- Close Button (Top Right Absolute) -->
            <a href="{{ route('products.index') }}" class="absolute top-6 right-6 text-gray-400 hover:text-gray-900 z-10 p-2 bg-white/50 rounded-full hover:bg-gray-100 transition">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <!-- Left: Image Section -->
            <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-8 md:p-12">
                 <img src="{{ $product->image_url }}" alt="{{ $product->brand }} {{ $product->model }}" class="w-full h-auto max-h-[500px] object-contain drop-shadow-xl transform hover:scale-105 transition duration-500">
            </div>

            <!-- Right: Details Section -->
            <div class="w-full md:w-1/2 p-8 md:p-12 md:pr-16 flex flex-col justify-center">
                
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-2">
                    {{ $product->brand }} {{ $product->model }}
                </h1>
                
                <div class="text-3xl font-bold text-gray-900 mb-8 mt-2">
                    ${{ number_format($product->price, 2) }}
                </div>

                <div class="space-y-4 mb-10 text-lg">
                    <div class="flex items-baseline border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-900 w-40">Diameter -</span>
                        <span class="text-gray-600 italic font-light">{{ $product->diameter }}</span>
                    </div>
                    <div class="flex items-baseline border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-900 w-40">Type -</span>
                        <span class="text-gray-600 italic font-light capitalize">{{ $product->type }}</span>
                    </div>
                    <div class="flex items-baseline border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-900 w-40">Material -</span>
                        <span class="text-gray-600 italic font-light capitalize">{{ $product->material }}</span>
                    </div>
                    <div class="flex items-baseline border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-900 w-40">Strap -</span>
                        <span class="text-gray-600 italic font-light capitalize">{{ $product->strap }}</span>
                    </div>
                    <div class="flex items-baseline border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-900 w-40">Water Resistance -</span>
                        <span class="text-gray-600 italic font-light">{{ $product->water_resistance }}</span>
                    </div>
                    <div class="flex items-baseline">
                        <span class="font-medium text-gray-900 w-40">Caliber -</span>
                        <span class="text-gray-600 italic font-light">{{ $product->caliber }}</span>
                    </div>
                </div>

                <div class="flex gap-4">
                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="flex-grow">
                        @csrf
                        <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-md font-medium text-lg hover:bg-black transition flex justify-center items-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Add to cart
                        </button>
                    </form>
                    <form action="{{ route('favorites.store', $product->id) }}" method="POST">
                        @csrf
                    <button class="w-16 h-14 flex items-center justify-center bg-gray-100 rounded-md hover:bg-gray-200 transition text-gray-600 hover:text-red-500">
                         <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    </form>
                </div>

            </div>

        </div>
    </main>
@endsection
