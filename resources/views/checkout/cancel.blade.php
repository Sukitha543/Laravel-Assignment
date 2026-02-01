@extends('layouts.main')

@section('title', 'Payment Cancelled - TimeBridge')
@section('body-class', 'bg-gray-50')

@section('content')
    <!-- Main Content -->
    <main class="flex-grow pt-12 pb-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-lg p-12 text-center max-w-3xl mx-auto">
                
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-red-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">Payment Cancelled</h1>
                <p class="text-lg text-gray-600 mb-6">Your payment was cancelled or failed. No charges were made.</p>
                
                <div class="mt-8">
                    <a href="{{ route('cart.index') }}" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition">
                        Return to Cart
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
