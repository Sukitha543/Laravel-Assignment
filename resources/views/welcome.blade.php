@extends('layouts.main')

@section('content')
    <!-- Hero Section -->
    <main class="relative min-h-screen flex items-center bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center pt-12 pb-12">
            <!-- Text Content -->
            <div class="space-y-8 z-20">
                <div class="space-y-4">
                    <p class="text-sm font-semibold tracking-widest text-gray-500 uppercase">Luxury Collection</p>
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight tracking-tight text-gray-900">
                        Find Your Perfect <br>
                        <span class="text-gray-900">Timepiece Online</span>
                    </h1>
                </div>
                <p class="text-lg text-gray-600 max-w-lg leading-relaxed">
                    Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.
                </p>
                <div>
                    @auth
                        <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-8 py-4 rounded-none font-medium text-lg hover:bg-gray-800 transition transform hover:-translate-y-0.5">
                            Browse Products
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-black text-white px-8 py-3 rounded-none font-medium text-lg hover:bg-gray-800 transition transform hover:-translate-y-0.5">
                            Browse Collection
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block bg-transparent border-2 border-black text-black px-8 py-4 rounded-none font-medium text-lg hover:bg-black hover:text-white transition transform hover:-translate-y-0.5 text-center">
                                    Sign Up
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative w-full h-full flex justify-end items-center z-20">
                  <div class="relative z-10 w-full flex justify-center lg:justify-end">
                    <img src="{{ asset('images/watch.png') }}" alt="Luxury Watch" class="w-full max-w-[600px] object-contain drop-shadow-2xl">
                  </div>
            </div>
        </div>
        
        <!-- Background decorative shape -->
         <div class="absolute top-0 right-0 w-[55%] h-full bg-gray-100/80 -skew-x-12 translate-x-48 z-10 hidden lg:block border-l border-white/50"></div>
    </main>
@endsection
