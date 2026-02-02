@extends('layouts.main')

@section('title', 'Payment Successful - TimeBridge')
@section('body-class', 'bg-gray-50')

@section('content')
    <!-- Main Content -->
    <main class="flex-grow pt-12 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-lg p-12 text-center max-w-3xl mx-auto">
                
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Successful!</h1>
                <p class="text-lg text-gray-600 mb-6">Thank you for your purchase. Your payment has been processed successfully.</p>
                
                @if(isset($order))
                <p class="text-gray-500 mb-8">Your Order ID: <span class="font-mono font-medium text-gray-900">#{{ $order->id }}</span></p>
                @endif
                
                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
