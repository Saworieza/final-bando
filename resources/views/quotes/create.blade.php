{{-- resources/views/quotes/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Request Quote</h1>
                <p class="mt-1 text-sm text-gray-600">Send a quote request to the seller</p>
            </div>

            {{-- Product Information --}}
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Product Information</h2>
                <div class="flex items-center space-x-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg">
                    @endif
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-sm text-gray-600">Seller: {{ $product->user->name ?? 'Unknown' }}</p>
                        @if($product->price)
                            <p class="text-sm font-medium text-green-600">Listed Price: ${{ number_format($product->price, 2) }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quote Request Form --}}
            <form action="{{ route('quotes.store') }}" method="POST" class="px-6 py-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="space-y-6">
                    {{-- Message --}}
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                        <div class="mt-1">
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="4" 
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('message') border-red-300 @enderror" 
                                placeholder="Please describe your requirements, preferred specifications, delivery timeline, etc."
                                required>{{ old('message') }}</textarea>
                        </div>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Provide details about your requirements and any specific requests.</p>
                    </div>

                    {{-- Quantity --}}
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <div class="mt-1">
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                min="1" 
                                max="10000"
                                value="{{ old('quantity', 1) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('quantity') border-red-300 @enderror">
                        </div>
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">How many units do you need?</p>
                    </div>

                    {{-- Requested Price --}}
                    <div>
                        <label for="requested_price" class="block text-sm font-medium text-gray-700">Requested Price (Optional)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="requested_price" 
                                name="requested_price" 
                                min="0" 
                                step="0.01"
                                value="{{ old('requested_price') }}"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md @error('requested_price') border-red-300 @enderror"
                                placeholder="0.00">
                        </div>
                        @error('requested_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">What price are you hoping for? (Leave blank if you want the seller to quote first)</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('products.show', $product) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Send Quote Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection