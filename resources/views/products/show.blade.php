<x-app-layout>
    <x-slot name="header">
        <p class="text-sm text-gray-600 mb-2">
            {{ $product->category->name ?? 'Uncategorized' }}
        </p>

        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <x-breadcrumb :links="[
                ($product->category->name ?? 'Uncategorized') => route('products.index', ['category' => $product->category->slug ?? null]), 
                $product->name => null
            ]" />
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto space-y-6">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-2xl font-bold mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mb-1">Category: <strong>{{ $product->category->name ?? 'Uncategorized' }}</strong></p>
            <p class="text-gray-700 mb-4">{{ $product->description }}</p>
            <p class="text-lg font-semibold text-green-700 mb-4">KES {{ number_format($product->price, 2) }}</p>

            <!-- Quote Request Button -->
            <div class="mt-4">
                @include('partials.quote-button', ['product' => $product])
            </div>
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

        <!-- Quote Requests Section -->
        <div class="bg-white p-6 rounded shadow">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-lg font-semibold">Quote Requests</h4>
                <span class="text-sm text-gray-500">{{ $product->quotes->count() }} requests</span>
            </div>

            @if(auth()->check() && auth()->user()->hasRole('Buyer') && auth()->id() !== $product->user_id)
                <!-- Quote Request Form -->
                <div class="mb-6 border rounded-lg p-4 bg-gray-50">
                    <h5 class="font-medium mb-3">Request a Quote</h5>
                    <form id="quote-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Describe your requirements..."
                                required></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    min="1" 
                                    value="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="requested_price" class="block text-sm font-medium text-gray-700">Requested Price (Optional)</label>
                                <input 
                                    type="number" 
                                    id="requested_price" 
                                    name="requested_price" 
                                    min="0" 
                                    step="0.01"
                                    placeholder="0.00"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Send Quote Request
                        </button>
                    </form>
                </div>
            @endif

            <!-- Quote Requests List -->
            <div id="quotes-list" class="space-y-4">
                @forelse($product->quotes->sortByDesc('created_at') as $quote)
                    @if(auth()->check() && (auth()->user()->hasRole('Admin') || auth()->id() === $product->user_id || auth()->id() === $quote->user_id))
                        @include('partials.quote-item', ['quote' => $quote])
                    @endif
                @empty
                    <div class="text-center py-8 text-gray-500">
                        No quote requests yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('quote-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            fetch('{{ route("quotes.quick-store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset form
                    this.reset();
                    
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Add new quote to the list
                    const quotesList = document.getElementById('quotes-list');
                    if (data.quote_html) {
                        const emptyState = quotesList.querySelector('.text-center.py-8');
                        if (emptyState) {
                            emptyState.remove();
                        }
                        quotesList.insertAdjacentHTML('afterbegin', data.quote_html);
                    }
                    
                    // Update quote count
                    const countElement = document.querySelector('.text-sm.text-gray-500');
                    if (countElement) {
                        const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]) || 0;
                        countElement.textContent = `${currentCount + 1} requests`;
                    }
                } else {
                    showAlert('error', data.error || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred while sending the quote request');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
        
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            alertDiv.textContent = message;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
    @endpush
</x-app-layout>