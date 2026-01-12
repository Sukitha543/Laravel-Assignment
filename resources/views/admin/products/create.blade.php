<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Add Watch Product
        </h2>
    </x-slot>
    <div class="max-w-5xl mx-auto p-6 bg-white shadow rounded-lg mt-6">
            @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
        <form method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                    <select name="brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option>Select Brand</option>
                        <option>Rolex</option>
                        <option>Omega</option>
                        <option>Patek Philippe</option>
                        <option>Audemars Piguet</option>
                    </select>
                </div>

                <!-- Model -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Product Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" name="product_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Diameter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Diameter</label>
                    <input type="text" name="diameter" placeholder="e.g. 42mm"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option>Select Type</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                    </select>
                </div>

                <!-- Material -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Material</label>
                    <select name="material" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option>Select Material</option>
                        <option value="steel">Steel</option>
                        <option value="plastic">Plastic</option>
                    </select>
                </div>

                <!-- Strap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Strap</label>
                    <select name="strap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option>Select Strap</option>
                        <option value="leather">Leather</option>
                        <option value="steel">Steel</option>
                    </select>
                </div>

                <!-- Water Resistance -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Water Resistance</label>
                    <input type="text" name="water_resistance" placeholder="e.g. 100m"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Caliber -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Caliber</label>
                    <input type="text" name="caliber" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file"
                            name="image"
                           class="mt-1 block w-full text-sm text-gray-600
                           file:mr-4 file:py-2 file:px-4
                           file:rounded file:border-0
                           file:text-sm file:font-semibold
                           file:bg-black file:text-white
                           hover:file:bg-gray-800">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                        class="px-6 py-2 bg-black text-white rounded hover:bg-gray-800">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
