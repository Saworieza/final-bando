<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-4">
        <p class="text-gray-700">Welcome, {{ Auth::user()->name }}</p>

        <!-- Add Product Button -->
        <div class="flex justify-between items-center">

            <a href="{{ route('products.create') }}"
            class="inline-flex items-center bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">
                + Add Product
            </a>
        </div>


        <h3 class="text-lg font-semibold mt-6">My Products</h3>

        @php
            $products = Auth::user()->products()->latest()->get();
        @endphp

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">KES {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $product->status ?? 'active' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('products.edit', $product) }}" class="text-sm text-indigo-600 hover:underline">Edit</a>
                            |
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
