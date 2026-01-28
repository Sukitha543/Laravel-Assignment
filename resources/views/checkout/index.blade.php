<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - TimeBridge</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
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

            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Shipping Details Form -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h2 class="text-xl font-semibold mb-6">Shipping Details</h2>
                        
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            
                            <!-- Name & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                                <textarea name="address" id="address" rows="3" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">{{ old('address') }}</textarea>
                                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-6">
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Town / City</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between items-start text-sm">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $item->product->brand }} {{ $item->product->model }}</span>
                                    <span class="text-gray-500">Qty: {{ $item->quantity }}</span>
                                </div>
                                <span class="font-semibold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <span>Total</span>
                                <span>${{ number_format($totalPrice, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" form="checkout-form"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                            Pay with Stripe
                        </button>
                        
                        <p class="mt-4 text-xs text-center text-gray-500">
                            You will be redirected to Stripe to securely complete your payment.
                        </p>
                    </div>
                </div>
            </div>
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
    @livewireScripts
</body>
</html>
