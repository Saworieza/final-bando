<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto space-y-4">
        <p class="text-gray-700">Welcome, {{ Auth::user()->name }}</p>

        <a href="{{ route('products.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Add Product
        </a>

        <h3 class="text-lg font-semibold mt-6">My Products</h3>

        @php
            $products = Auth::user()->products ?? [];
        @endphp

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">SKU</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ $product->sku }}</td>
                        <td class="px-4 py-2">KES {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $product->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
