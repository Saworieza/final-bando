<div class="max-w-xl mx-auto">
    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block text-sm font-medium">Product Name</label>
            <input type="text" wire:model="name" class="w-full border p-2 rounded">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">SKU</label>
            <input type="text" wire:model="sku" class="w-full border p-2 rounded">
            @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Price (KES)</label>
            <input type="number" step="0.01" wire:model="price" class="w-full border p-2 rounded">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Min Order Quantity</label>
            <input type="number" wire:model="min_order_qty" class="w-full border p-2 rounded">
            @error('min_order_qty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Category</label>
            <input type="text" wire:model="category" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Tags (comma-separated)</label>
            <input type="text" wire:model="tags" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Status</label>
            <select wire:model="status" class="w-full border p-2 rounded">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="out_of_stock">Out of Stock</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Image</label>
            <input type="file" wire:model="image" class="w-full">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="h-32 mt-2 rounded border">
            @endif
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Product
            </button>
        </div>
    </form>
</div>
