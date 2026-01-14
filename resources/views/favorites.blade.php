<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Favorites - TimeBridge</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased selection:bg-gray-900 selection:text-white flex flex-col min-h-screen">

    <!-- Navigation (Reused) -->
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
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition uppercase tracking-wide">Products</a>
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
    <main class="flex-grow pt-12 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Favorites</h1>
                <p class="text-gray-500 text-sm mt-1">{{ count($favorites) }} items in your favorites</p>
            </div>

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

            @if(count($favorites) > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                
                @foreach($favorites as $item)
                <div class="p-6 flex items-center justify-between border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-6">
                         <div class="w-24 h-24 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->brand }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-medium text-lg text-gray-900">{{ $item->product->brand }} {{ $item->product->model }}</h3>
                            <a href="{{ route('products.show', $item->product) }}" class="text-gray-500 text-sm mt-1 hover:text-gray-900 hover:underline">View Details</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                         <span class="font-bold text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                         <form action="{{ route('favorites.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                             <button type="submit" class="text-red-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                             </button>
                         </form>
                    </div>
                </div>
                @endforeach

            </div>
            @else
                <div class="text-center py-24 bg-white rounded-lg shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">No Favorites Added</h2>
                    <p class="text-gray-500 mb-8">Start adding items to your favorites list.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition">
                        Browse Products
                    </a>
                </div>
            @endif

        </div>
    </main>

    <!-- Footer (Reused) -->
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
