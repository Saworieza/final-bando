<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">My Products</h2>
    </x-slot>

    <div class="py-6 px-4">
        <a href="{{ route('products.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Product</a>

        @if (session('status'))
            <div class="mb-4 p-2 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            @forelse ($products as $product)
                <div class="bg-white border p-4 rounded shadow-sm">
                    <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                    <p class="text-gray-600">Ksh {{ number_format($product->price, 2) }}</p>
                    <div class="flex space-x-2 mt-3">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 text-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>No products yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
