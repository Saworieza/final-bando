<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Add Product</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <!-- <div>
                <label class="block font-medium">Image</label>
                <input type="file" name="image" class="w-full">
            </div> -->

            <div class="mb-4">
                <label for="images" class="block font-medium text-sm text-gray-700">Product Images</label>
                <input type="file" name="images[]" multiple accept="image/*"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>


            <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </form>
    </div>
</x-app-layout>
