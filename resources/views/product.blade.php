<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products - TimeBridge</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased selection:bg-gray-900 selection:text-white flex flex-col min-h-screen">

    <!-- Navigation -->
    <header class="w-full bg-black text-white py-6">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
             <!-- Logo -->
            <div class="flex items-center gap-2">
                 <a href="{{ url('/') }}" class="text-2xl font-light tracking-widest text-white uppercase">
                     TimeBridge
                 </a>
            </div>

            <!-- Nav Links (Center) -->
            <nav class="hidden md:flex items-center gap-12">
                <a href="{{ url('/') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">Home</a>
                <a href="{{ url('/about') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">About Us</a>
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-white underline underline-offset-4 transition uppercase tracking-wide">Products</a>
            </nav>

            <!-- Auth Links (Right) -->
            <div class="flex items-center gap-6">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">Sign Up</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-8 pb-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Top Bar: Search & Sort -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="w-full md:w-1/2 relative">
                    <input type="text" placeholder="Search products..." class="w-full bg-gray-200 border-none rounded-sm py-3 px-4 pl-12 text-gray-700 focus:ring-0 focus:bg-white transition placeholder-gray-500">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <button class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-3 px-6 rounded-sm flex items-center gap-2 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        View Cart
                    </button>
                    <button class="p-3 text-gray-500 hover:text-gray-900 border border-transparent hover:border-gray-300 rounded-sm transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-12">
                <!-- Sidebar: Filters -->
                <aside class="w-full md:w-1/4 space-y-8">
                    
                    <div>
                        <h3 class="flex items-center gap-2 text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filters
                        </h3>
                        
                        <!-- Applied Filters -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Applied Filters</span>
                                <a href="#" class="text-xs text-gray-400 hover:text-black underline">clear all</a>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2 py-1 bg-gray-200 text-xs font-medium text-gray-700 rounded-sm">
                                    Rolex <button class="ml-1 text-gray-500 hover:text-black">&times;</button>
                                </span>
                                <span class="inline-flex items-center px-2 py-1 bg-gray-200 text-xs font-medium text-gray-700 rounded-sm">
                                    Hublot <button class="ml-1 text-gray-500 hover:text-black">&times;</button>
                                </span>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3 flex justify-between cursor-pointer">
                                Brand <span class="text-gray-400">^</span>
                            </h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Rolex</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Hublot</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Omega</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Seiko</span>
                                </label>
                            </div>
                        </div>

                        <!-- Gender Filter -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-3 flex justify-between cursor-pointer">
                                Gender <span class="text-gray-400">^</span>
                            </h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Men</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" class="rounded border-gray-300 text-black focus:ring-0">
                                    <span class="text-sm text-gray-600 group-hover:text-black transition">Women</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="w-full md:w-3/4">
                    <h2 class="text-2xl font-serif italic text-gray-900 mb-8">"Our Products"</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Product Item Template -->
                        @if($products->count() > 0)
                            @foreach ($products as $product)
                            <div class="group">
                                <div class="bg-transparent mb-4 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->brand }} {{ $product->model }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                                    <button class="absolute top-4 right-4 p-2 bg-white/80 rounded-full text-gray-500 hover:text-red-500 hover:bg-white transition opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-sm font-semibold text-gray-900 group-hover:text-amber-700 transition">{{ $product->brand }} {{ $product->model }}</h3>
                                    <div class="flex justify-center items-center gap-3 mt-1 mb-3">
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('products.show', $product) }}" class="text-xs text-gray-500 italic hover:underline">View Details</a>
                                    </div>
                                    <button class="w-full bg-gray-900 text-white py-2 text-sm font-medium uppercase tracking-wide hover:bg-black transition flex justify-center items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add To Cart
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-span-full py-12 text-center text-gray-500">
                                No products available at the moment.
                            </div>
                        @endif

                    </div>
                    
                    <!-- Pagination (Visual) -->
                    <div class="mt-12 flex justify-center">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center text-center">
            
            <div class="flex gap-8 mb-6 text-gray-300 font-medium text-lg">
                <a href="{{ url('/') }}" class="hover:text-white hover:underline transition">Home</a>
                <a href="{{ url('/about') }}" class="hover:text-white hover:underline transition">About Us</a>
                <a href="{{ route('products.index') }}" class="hover:text-white hover:underline transition">Products</a>
            </div>

            <div class="flex gap-6 mb-6">
                <!-- Facebook -->
                 <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition group text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                 </a>
                 <!-- Instagram -->
                 <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition group text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                 </a>
            </div>

            <p class="text-gray-400 mb-2 font-light">
                Colombo 03 - 41 Galle Road &bull; Tel: +94 11 2335787 &bull; Email: info@TimeBridge.lk
            </p>
            <p class="text-gray-600 text-sm font-light">
                &copy; {{ date('Y') }} TimeBridge Inc. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
