<div class="space-y-4">
    <input
        type="text"
        wire:model.debounce.300ms="search"
        placeholder="Search products..."
        class="w-full p-2 border rounded"
    />

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">SKU</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->sku }}</td>
                    <td class="px-4 py-2">KES {{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $product->status) }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline-block" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 px-4 py-6">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
