<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manage Watch Product
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg mt-6">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- UPDATE FORM --}}
        <form method="POST" action="{{ route('admin.products.update', $product)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                    <select name="brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach (['Rolex','Omega','Patek Philippe','Audemars Piguet'] as $brand)
                            <option value="{{ $brand }}" {{ $product->brand === $brand ? 'selected' : '' }}>
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Model -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model"
                           value="{{ old('model', $product->model) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Product Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code"
                           value="{{ old('product_code', $product->product_code) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Diameter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Diameter</label>
                    <input type="text" name="diameter"
                           value="{{ old('diameter', $product->diameter) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="men" {{ $product->type === 'men' ? 'selected' : '' }}>Men</option>
                        <option value="women" {{ $product->type === 'women' ? 'selected' : '' }}>Women</option>
                    </select>
                </div>

                <!-- Material -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Material</label>
                    <select name="material" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="steel" {{ $product->material === 'steel' ? 'selected' : '' }}>Steel</option>
                        <option value="plastic" {{ $product->material === 'plastic' ? 'selected' : '' }}>Plastic</option>
                    </select>
                </div>

                <!-- Strap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Strap</label>
                    <select name="strap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="leather" {{ $product->strap === 'leather' ? 'selected' : '' }}>Leather</option>
                        <option value="steel" {{ $product->strap === 'steel' ? 'selected' : '' }}>Steel</option>
                    </select>
                </div>

                <!-- Water Resistance -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Water Resistance</label>
                    <input type="text" name="water_resistance"
                           value="{{ old('water_resistance', $product->water_resistance) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Caliber -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Caliber</label>
                    <input type="text" name="caliber"
                           value="{{ old('caliber', $product->caliber) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price"
                           value="{{ old('price', $product->price) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity"
                           value="{{ old('quantity', $product->quantity) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Current Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Current Image</label>
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="h-32 mt-2 rounded shadow">
                </div>

                <!-- New Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Change Image</label>
                    <input type="file" name="image" class="mt-1 block w-full text-sm">
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-6 flex gap-4">
                <button type="submit"
                        class="px-6 py-2 bg-black text-white rounded hover:bg-gray-800">
                    Save Changes
                </button>
            </div>
        </form>

        {{-- DELETE FORM --}}
        <form method="POST"
              action="{{ route('admin.products.destroy', $product) }}"
              class="mt-4"
              onsubmit="return confirm('Are you sure you want to delete this watch?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Delete Product
            </button>
        </form>

    </div>
</x-app-layout>
