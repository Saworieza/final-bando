{{-- resources/views/quotes/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Respond to Quote Request</h1>
                <p class="mt-1 text-sm text-gray-600">Provide your quote and response to the buyer</p>
            </div>

            {{-- Quote Information --}}
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Product</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $quote->item_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Buyer</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $quote->buyer->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Quantity</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $quote->quantity }}</p>
                    </div>
                    @if($quote->requested_price)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Requested Price</h3>
                            <p class="mt-1 text-sm text-gray-900">${{ number_format($quote->requested_price, 2) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Buyer's Message --}}
            <div class="px-6 py-4 bg-blue-50 border-b border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Buyer's Request</h3>
                <div class="text-sm text-gray-900 bg-white p-3 rounded-md border">
                    {{ $quote->message }}
                </div>
            </div>

            {{-- Response Form --}}
            <form action="{{ route('quotes.update', $quote) }}" method="POST" class="px-6 py-4">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Quoted Price --}}
                    <div>
                        <label for="quoted_price" class="block text-sm font-medium text-gray-700">Your Quote Price *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="quoted_price" 
                                name="quoted_price" 
                                min="0" 
                                step="0.01"
                                value="{{ old('quoted_price', $quote->requested_price) }}"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md @error('quoted_price') border-red-300 @enderror"
                                placeholder="0.00"
                                required>
                        </div>
                        @error('quoted_price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Enter your quoted price for the requested quantity.</p>
                    </div>

                    {{-- Seller Response --}}
                    <div>
                        <label for="seller_response" class="block text-sm font-medium text-gray-700">Your Response *</label>
                        <div class="mt-1">
                            <textarea 
                                id="seller_response" 
                                name="seller_response" 
                                rows="4" 
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('seller_response') border-red-300 @enderror" 
                                placeholder="Respond to the buyer's request. Include details about delivery time, terms, specifications, etc."
                                required>{{ old('seller_response') }}</textarea>
                        </div>
                        @error('seller_response')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Provide details about your offer, delivery terms, specifications, etc.</p>
                    </div>

                    {{-- Price Breakdown (Optional) --}}
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Price Breakdown</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div class="flex justify-between">
                                <span>Quantity:</span>
                                <span>{{ $quote->quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Unit Price:</span>
                                <span id="unit-price">$0.00</span>
                            </div>
                            <div class="flex justify-between font-medium text-gray-900 border-t pt-1">
                                <span>Total:</span>
                                <span id="total-price">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('quotes.show', $quote) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Send Quote Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePriceBreakdown() {
        const quotedPrice = parseFloat(document.getElementById('quoted_price').value) || 0;
        const quantity = {{ $quote->quantity }};
        const unitPrice = quantity > 0 ? quotedPrice / quantity : 0;
        
        document.getElementById('unit-price').textContent = '$' + unitPrice.toFixed(2);
        document.getElementById('total-price').textContent = '$' + quotedPrice.toFixed(2);
    }

    document.getElementById('quoted_price').addEventListener('input', updatePriceBreakdown);
    
    // Initialize on page load
    updatePriceBreakdown();
</script>
@endpush
@endsection