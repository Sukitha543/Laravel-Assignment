@extends('layouts.main')

@section('title', 'About Us - TimeBridge')

@section('content')
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
                       At TimeBridge, we believe a watch is more than just a device to tell time — it tells a story, carries history, and shows true precision. We connect watch lovers with some of the world’s finest timepieces, ensuring authenticity, quality, and elegance in every piece.
                    </p>
                    <div class="pt-2 flex gap-4">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center bg-black text-white px-8 py-3 rounded-none font-medium text-lg hover:bg-gray-800 transition transform hover:-translate-y-0.5">
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
                    <img src="{{ asset('images/about_us.jpg') }}" alt="Man viewing luxury watches" class="relative z-10 w-full h-full object-cover shadow-2xl">
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
                <img src="{{ asset('images/about_us.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:opacity-30 transition blur-sm">
                 <div class="relative z-10 text-center text-white p-8">
                     <h2 class="text-3xl font-bold mb-4">Join the Inner Circle</h2>
                     <p class="text-gray-300 max-w-xl mx-auto mb-8">Sign up today to get exclusive access to our newest arrivals.</p>
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
                         <span class="text-3xl font-serif font-bold tracking-wider group-hover:text-black">CASIO</span>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
