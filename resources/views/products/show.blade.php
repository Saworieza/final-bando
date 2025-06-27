<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-6">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-2xl font-bold mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mb-1">Category: <strong>{{ $product->category->name ?? 'Uncategorized' }}</strong></p>
            <p class="text-gray-700 mb-2">{{ $product->description }}</p>
            <p class="text-lg font-semibold text-green-700">KES {{ number_format($product->price, 2) }}</p>
        </div>

        @if ($product->images->count())
            <div class="bg-white p-6 rounded shadow">
                <h4 class="text-lg font-semibold mb-4">Product Gallery</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($product->images as $img)
                        <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 alt="Product Image"
                                 class="w-full h-48 object-cover rounded border">
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
