<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <h1 class="text-3xl font-bold text-red-600 mb-4">Payment Cancelled</h1>
                <p class="text-lg text-gray-700 mb-6">Your payment was cancelled or failed. No charges were made.</p>
                
                <div class="mt-8">
                    <a href="{{ route('cart.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Return to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
