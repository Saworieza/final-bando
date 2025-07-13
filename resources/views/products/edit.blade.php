<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit Product</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- SKU -->
            <div>
                <label class="block font-medium">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Stock Qty -->
            <div>
                <label class="block font-medium">Stock Quantity</label>
                <input type="number" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty, 0) }}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Min Order Qty -->
            <div>
                <label class="block font-medium">Min Order Qty</label>
                <input type="number" name="min_order_qty" value="{{ old('min_order_qty', $product->min_order_qty, 1) }}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Weight (kg) -->
            <div>
                <label class="block font-medium">Weight (kg)</label>
                <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Dimensions -->
            <div>
                <label class="block font-medium">Dimensions (L*W*H cm)</label>
                <input type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="20×15×10" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Warranty -->
            <div>
                <label class="block font-medium">Warranty</label>
                <textarea name="warranty" class="w-full border rounded px-3 py-2">{{ old('warranty', $product->warranty) }}</textarea>
            </div>

            <!-- Return Policy -->
            <div>
                <label class="block font-medium">Return Policy</label>
                <textarea name="return_policy" class="w-full border rounded px-3 py-2">{{ old('return_policy', $product->return_policy) }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="block font-medium">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="Active" {{ old('status')=='Active'?'selected':'' }}>Active</option>
                    <option value="Inactive" {{ old('status')=='Inactive'?'selected':'' }}>Inactive</option>
                    <option value="OutOfStock" {{ old('status')=='OutOfStock'?'selected':'' }}>Out of Stock</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Image</label>
                @if ($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="image" class="w-full">
            </div>

            <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
        </form>
    </div>
</x-app-layout>
