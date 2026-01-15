<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <h1 class="text-3xl font-bold text-green-600 mb-4">Payment Successful!</h1>
                <p class="text-lg text-gray-700 mb-6">Thank you for your purchase. Your payment has been processed successfully.</p>
                <p class="text-gray-600">A receipt has been emailed to you.</p>
                
                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
