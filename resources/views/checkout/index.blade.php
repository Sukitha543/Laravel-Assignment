@extends('layouts.main')

@section('title', 'Checkout - TimeBridge')
@section('body-class', 'bg-gray-50')

@section('content')
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
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                !-- @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror -->
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                                <textarea name="address" id="address" rows="3" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">{{ old('address') }}</textarea>
                                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-6">
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Town / City</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}"
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
@endsection
