<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Products</h2>
        <x-breadcrumb :links="[
            'Products' => route('products.index'),
            $currentCategory?->name ?? 'All Products' => null
        ]" />
    </x-slot>

    


    <div class="py-6 px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($products as $product)
            <div class="border rounded shadow-sm bg-white p-4">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover mb-2" />
                @endif
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mb-1">Ksh {{ number_format($product->price, 2) }}</p>
                <p class="text-xs text-gray-500">Category: {{ $product->category->name ?? '-' }}</p>
                <a href="{{ route('products.show', $product) }}" class="text-blue-500 text-sm mt-2 inline-block">View</a>
            </div>
        @empty
            <p class="text-gray-500">No products found.</p>
        @endforelse
    </div>
</x-app-layout>
