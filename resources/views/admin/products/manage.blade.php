<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manage Products</h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Image</th>
                    <th class="p-3 text-left">Brand</th>
                    <th class="p-3 text-left">Model</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Quantity</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-t">
                        <td class="p-3">
                            <img src="{{ $product->image_url }}"
                                 class="h-16 rounded">
                        </td>
                        <td class="p-3">{{ $product->brand }}</td>
                        <td class="p-3">{{ $product->model }}</td>
                        <td class="p-3">${{ number_format($product->price, 2) }}</td>
                        <td class="p-3">{{ $product->quantity }}</td>
                        <td class="p-3">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-blue-600 hover:underline">
                                Manage
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
