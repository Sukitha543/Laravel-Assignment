<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - TimeBridge</title>
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
                <a href="{{ url('/about') }}" class="text-sm font-medium text-white underline underline-offset-4 transition uppercase tracking-wide">About Us</a>
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
            
            <!-- Hero / Intro Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
                <!-- Text Content -->
                <div class="space-y-8 animate-fade-in-up">
                    <div class="space-y-4">
                        <p class="text-sm font-bold tracking-widest text-amber-600 uppercase">Since 2025</p>
                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Bridging Time, <br> <span class="text-gray-500">Curating Legacy.</span>
                        </h1>
                    </div>
                    <p class="text-lg text-gray-600 leading-relaxed max-w-lg">
                        At TimeBridge, we believe a watch is more than a tool—it's a story, an heirloom, and a testament to precision. We connect discerning collectors with the world's most exquisite timepieces, ensuring authenticity and elegance in every second.
                    </p>
                    <div class="pt-2 flex gap-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-black text-white px-8 py-3 rounded-none font-medium text-lg hover:bg-gray-800 transition transform hover:-translate-y-0.5">
                            Browse Collection
                        </a>
                        <a href="#values" class="inline-flex items-center justify-center border border-gray-300 text-gray-700 px-8 py-3 rounded-none font-medium text-lg hover:border-black hover:text-black transition">
                            Our Values
                        </a>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative w-full h-full min-h-[400px] lg:min-h-[500px]">
                    <div class="absolute inset-0 bg-gray-100 transform translate-x-4 translate-y-4 z-0"></div>
                    <img src="{{ asset('images/about_us.png') }}" alt="Man viewing luxury watches" class="relative z-10 w-full h-full object-cover shadow-2xl">
                </div>
            </div>

            <!-- Values Section -->
            <div id="values" class="bg-gray-50 -mx-6 px-6 py-20 mb-20 border-y border-gray-100">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">The TimeBridge Standard</h2>
                        <p class="text-gray-600 text-lg">We don't just sell watches; we curate experiences defined by trust, transparency, and timeless quality.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <!-- Value 1 -->
                        <div class="bg-white p-8 shadow-sm hover:shadow-md transition duration-300 border border-gray-100 flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mb-6 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Certified Authenticity</h3>
                            <p class="text-gray-600 leading-relaxed">Every timepiece is rigorously inspected by expert horologists to guarantee 100% authenticity and original parts.</p>
                        </div>

                        <!-- Value 2 -->
                        <div class="bg-white p-8 shadow-sm hover:shadow-md transition duration-300 border border-gray-100 flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mb-6 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Timeless Curation</h3>
                            <p class="text-gray-600 leading-relaxed">Our collection is handpicked, focusing on rare, vintage, and modern classics that hold value and style forever.</p>
                        </div>

                        <!-- Value 3 -->
                        <div class="bg-white p-8 shadow-sm hover:shadow-md transition duration-300 border border-gray-100 flex flex-col items-center text-center">
                             <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mb-6 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Global Sourcing</h3>
                            <p class="text-gray-600 leading-relaxed">We scour the globe to find unique pieces, bringing international luxury directly to your wrist, hassle-free.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video/Story Placeholder Section (Visual Break) -->
            <div class="relative w-full h-80 rounded-sm overflow-hidden mb-24 bg-gray-900 flex items-center justify-center group cursor-pointer">
                <img src="{{ asset('images/about_us.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:opacity-30 transition blur-sm">
                 <div class="relative z-10 text-center text-white p-8">
                     <h2 class="text-3xl font-bold mb-4">Join the Inner Circle</h2>
                     <p class="text-gray-300 max-w-xl mx-auto mb-8">Sign up today to get exclusive access to our newest arrivals and members-only events.</p>
                     @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-block bg-white text-black px-8 py-3 font-medium hover:bg-gray-100 transition">Create Account</a>
                     @endif
                 </div>
            </div>

            <!-- Brands Section -->
            <div class="border-t border-gray-100 pt-16">
                <div class="text-center mb-12">
                    <p class="text-sm font-bold tracking-widest text-gray-400 uppercase mb-2">Our Partners</p>
                    <h2 class="text-3xl font-bold text-gray-900">Curated Brands</h2>
                </div>
                
                <div class="flex flex-wrap justify-center items-center gap-12 lg:gap-24 grayscale opacity-60 hover:opacity-100 transition duration-500">
                    <!-- Rolex Placeholder -->
                    <div class="flex flex-col items-center gap-2 group cursor-pointer">
                        <span class="text-3xl font-serif font-bold tracking-wider group-hover:text-black">ROLEX</span>
                    </div>

                    <!-- Omega Placeholder -->
                    <div class="flex flex-col items-center gap-2 group cursor-pointer">
                         <span class="text-3xl font-serif font-bold tracking-wider group-hover:text-black">Ω OMEGA</span>
                    </div>

                    <!-- Seiko Placeholder -->
                    <div class="flex flex-col items-center gap-2 group cursor-pointer">
                         <span class="text-3xl font-serif font-bold tracking-wider group-hover:text-black">SEIKO</span>
                    </div>

                    <!-- Hublot Placeholder -->
                    <div class="flex flex-col items-center gap-2 group cursor-pointer">
                         <span class="text-3xl font-serif font-bold tracking-wider group-hover:text-black">HUBLOT</span>
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
