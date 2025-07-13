<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <x-breadcrumb 
                :model="$product"
                :currentItem="$product->name"
            />
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Back Button -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Products
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="mb-4">
                        @if($product->images->count() > 0)
                            <img
                                id="main-image"
                                src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-96 object-cover rounded-lg shadow-lg"
                            />
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg shadow-lg flex items-center justify-center">
                                <span class="text-gray-500">No image available</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $index => $image)
                                <button
                                    onclick="changeImage('{{ asset('storage/' . $image->image_path) }}', this)"
                                    class="border-2 rounded-lg overflow-hidden hover:border-red-600 {{ $index === 0 ? 'border-red-600' : 'border-gray-200' }}"
                                >
                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="{{ $product->name }} {{ $index + 1 }}"
                                        class="w-full h-20 object-cover"
                                    />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <div class="mb-4">
                        <span class="text-red-600 font-semibold">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
                        @if($product->sku)
                            <p class="text-gray-600 mt-1">SKU: {{ $product->sku }}</p>
                        @endif
                    </div>

                    <!-- Rating (if available) -->
                    @if(isset($product->rating))
                        <div class="flex items-center mb-4">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $product->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">
                                {{ $product->rating ?? 0 }} ({{ $product->reviews ?? 0 }} reviews)
                            </span>
                        </div>
                    @endif

                    <!-- Stock Status -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->in_stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <!-- Pricing and MOQ -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-gray-900">
                                @if($product->price)
                                    KES {{ number_format($product->price, 2) }}
                                @else
                                    Contact for pricing
                                @endif
                            </span>
                            @if($product->moq)
                                <span class="text-gray-600">MOQ: {{ $product->moq }} units</span>
                            @endif
                        </div>

                        <!-- Quantity Selector -->
                        <div class="flex items-center mb-4">
                            <label class="text-gray-700 mr-4">Quantity:</label>
                            <input
                                type="number"
                                id="quantity-input"
                                min="{{ $product->moq ?? 1 }}"
                                value="{{ $product->moq ?? 1 }}"
                                class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                            />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button 
                                onclick="showQuoteForm()"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md flex items-center justify-center flex-1"
                            >
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m-2 0v-5a2 2 0 012-2h2m0 0V4a2 2 0 012-2h2m0 0v2M8 6h8m-8 0V4a2 2 0 012-2h2m0 0V2"></path>
                                </svg>
                                Request Quote
                            </button>
                            <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md flex items-center justify-center flex-1 hover:bg-gray-50">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call Sales
                            </button>
                            <button type="button" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md flex items-center justify-center flex-1 hover:bg-gray-50">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Inquiry
                            </button>
                        </div>
                    </div>

                    <!-- Quick Contact -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Need Technical Support?</h3>
                        <p class="text-gray-600 text-sm mb-3">
                            Our technical team is ready to help you select the right product for your application.
                        </p>
                        <div class="flex items-center text-sm text-red-600">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>(254) 700 919173</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="mt-16">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button
                            onclick="showTab('specifications')"
                            class="tab-button border-b-2 py-2 px-1 font-medium border-red-600 text-red-600"
                            id="specifications-tab"
                        >
                            Specifications
                        </button>
                        <button
                            onclick="showTab('features')"
                            class="tab-button border-b-2 py-2 px-1 font-medium border-transparent text-gray-500 hover:text-gray-700"
                            id="features-tab"
                        >
                            Features
                        </button>
                        <button
                            onclick="showTab('applications')"
                            class="tab-button border-b-2 py-2 px-1 font-medium border-transparent text-gray-500 hover:text-gray-700"
                            id="applications-tab"
                        >
                            Applications
                        </button>
                        <button
                            onclick="showTab('downloads')"
                            class="tab-button border-b-2 py-2 px-1 font-medium border-transparent text-gray-500 hover:text-gray-700"
                            id="downloads-tab"
                        >
                            Downloads
                        </button>
                    </nav>
                </div>

                <div class="py-8">
                    <!-- Specifications Tab -->
                    <div id="specifications" class="tab-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Technical Specifications</h3>
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <table class="w-full">
                                        <tbody>
                                            @if($product->specifications)
                                                @foreach(json_decode($product->specifications, true) as $key => $value)
                                                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                                        <td class="px-4 py-3 text-gray-700 font-medium">{{ $key }}</td>
                                                        <td class="px-4 py-3 text-gray-900">{{ $value }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="px-4 py-3 text-gray-500 text-center">No specifications available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features Tab -->
                    <div id="features" class="tab-content hidden">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Key Features</h3>
                        <ul class="space-y-3">
                            @if($product->features)
                                @foreach(json_decode($product->features, true) as $feature)
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-3">•</span>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500">No features listed</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Applications Tab -->
                    <div id="applications" class="tab-content hidden">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Applications</h3>
                        <ul class="space-y-3">
                            @if($product->applications)
                                @foreach(json_decode($product->applications, true) as $application)
                                    <li class="flex items-start">
                                        <span class="text-red-600 mr-3">•</span>
                                        <span class="text-gray-700">{{ $application }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500">No applications listed</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Downloads Tab -->
                    <div id="downloads" class="tab-content hidden">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Technical Documents</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($product->documents && $product->documents->count() > 0)
                                @foreach($product->documents as $doc)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $doc->name }}</h4>
                                                <p class="text-sm text-gray-600">{{ $doc->type }} • {{ $doc->size }}</p>
                                            </div>
                                            <a 
                                                href="{{ asset('storage/' . $doc->file_path) }}"
                                                download
                                                class="border border-gray-300 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-50 flex items-center"
                                            >
                                                <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-3 text-center text-gray-500">No documents available</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote Request Section - Moved Below Product Details -->
            <div class="mt-16 bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Request a Quote</h2>
                
                @if(!auth()->check())
                    <!-- Not logged in - Show login prompt -->
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">Want to request a quote for this product?</p>
                        <a href="{{ route('login') }}" class="bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Login to Request Quote
                        </a>
                    </div>
                @elseif(auth()->user()->hasRole('Buyer') && auth()->id() !== $product->user_id)
                    <!-- Buyer logged in - Show quote form -->
                    <form id="quote-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="seller_id" value="{{ $product->user_id }}">
                        <input type="hidden" name="item_name" value="{{ $product->name }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    min="{{ $product->moq ?? 1 }}"
                                    value="{{ $product->moq ?? 1 }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                    required
                                />
                                <p class="text-xs text-gray-500 mt-1">Minimum order quantity: {{ $product->moq ?? 1 }} units</p>
                            </div>

                            <div>
                                <label for="requested_price" class="block text-sm font-medium text-gray-700 mb-2">Requested Price (Optional)</label>
                                <div class="relative">
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
                                        class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                placeholder="Please describe your requirements, delivery timeline, any specific needs..."
                                required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button 
                                type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-md flex items-center"
                            >
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m-2 0v-5a2 2 0 012-2h2m0 0V4a2 2 0 012-2h2m0 0v2M8 6h8m-8 0V4a2 2 0 012-2h2m0 0V2"></path>
                                </svg>
                                Send Quote Request
                            </button>
                        </div>
                    </form>
                @elseif(auth()->check() && !auth()->user()->hasRole('Buyer'))
                    <!-- Logged in but not as buyer - Show role switch -->
                    <div class="text-center">
                        <p class="text-gray-600 mb-4">You need to be logged in as a buyer to request quotes.</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Log in as Buyer
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image gallery functionality
        function changeImage(src, buttonElement) {
            document.getElementById('main-image').src = src;
            
            // Update active thumbnail
            document.querySelectorAll('.grid button').forEach(btn => {
                btn.classList.remove('border-red-600');
                btn.classList.add('border-gray-200');
            });
            buttonElement.classList.add('border-red-600');
            buttonElement.classList.remove('border-gray-200');
        }

        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Update tab button styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-red-600', 'text-red-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Style active tab button
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-red-600', 'text-red-600');
        }

        // Show quote form function
        function showQuoteForm() {
            // Scroll to the quote form section
            const quoteForm = document.querySelector('#quote-form');
            if (quoteForm) {
                quoteForm.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            } else {
                // If no form found, scroll to the quote section
                document.querySelector('.mt-16.bg-white.rounded-lg.shadow-lg').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Quote form submission
        document.getElementById('quote-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            fetch('{{ route("quotes.store") }}', {
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
                    this.querySelector('input[name="quantity"]').value = {{ $product->moq ?? 1 }};
                    
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