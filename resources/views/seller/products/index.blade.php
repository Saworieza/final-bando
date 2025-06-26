<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            My Products
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('products.create') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Add Product
            </a>

            @livewire('seller.product-table')
        </div>
    </div>
</x-app-layout>
