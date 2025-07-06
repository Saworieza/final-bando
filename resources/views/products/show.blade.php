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
                <span class="text-sm text-gray-500">10 requests</span>
            </div>

            <!-- Quote Request Button/Form -->
            @if(!auth()->check())
                <!-- Not logged in - Show login prompt -->
                <div class="mb-6 border rounded-lg p-4 bg-gray-50 text-center">
                    <p class="text-gray-600 mb-3">Want to request a quote for this product?</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Login to Request Quote
                    </a>
                </div>
            @elseif(auth()->user()->hasRole('Buyer') && auth()->id() !== $product->user_id)
                <!-- Buyer logged in - Show quote form -->
                <div class="mb-6 border rounded-lg p-4 bg-gray-50">
                    <h5 class="font-medium mb-3">Request a Quote</h5>
                    <form id="quote-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="seller_id" value="{{ $product->user_id }}">
                        <input type="hidden" name="item_name" value="{{ $product->name }}">
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Describe your requirements, delivery timeline, etc..."
                                required></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity *</label>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    min="1" 
                                    value="1"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                            </div>
                            
                            <div>
                                <label for="requested_price" class="block text-sm font-medium text-gray-700">Requested Price (Optional)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">KES</span>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="requested_price" 
                                        name="requested_price" 
                                        min="0" 
                                        step="0.01"
                                        placeholder="0.00"
                                        class="block w-full pl-12 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
                            Send Quote Request
                        </button>
                    </form>
                </div>
            @elseif(auth()->check() && !auth()->user()->hasRole('Buyer'))
                <!-- Logged in but not as buyer - Show role switch -->
                <div class="mb-6 border rounded-lg p-4 bg-gray-50 text-center">
                    <p class="text-gray-600 mb-3">You need to be logged in as a buyer to request quotes.</p>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Log in as Buyer
                        </button>
                    </form>
                </div>
            @endif

           
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
            
            fetch('/', {
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
                    document.getElementById('quantity').value = 1;
                    
                    // Show success message
                    showAlert('success', data.message || 'Quote request sent successfully!');
                    
                    // Refresh the page to show the new quote
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        for (let field in data.errors) {
                            errorMessage += `• ${data.errors[field][0]}\n`;
                        }
                        showAlert('error', errorMessage);
                    } else {
                        showAlert('error', data.message || 'An error occurred');
                    }
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
            alertDiv.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg max-w-md ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            
            if (type === 'error' && message.includes('\n')) {
                // Handle multi-line error messages
                alertDiv.innerHTML = `<pre class="whitespace-pre-wrap text-sm">${message}</pre>`;
            } else {
                alertDiv.textContent = message;
            }
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
    @endpush
</x-app-layout>