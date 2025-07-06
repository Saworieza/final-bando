{{-- resources/views/partials/quote-item.blade.php --}}
<div class="quote-item border rounded-lg p-4 bg-white" data-quote-id="{{ $quote->id }}">
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-sm font-medium text-blue-600">{{ substr($quote->user->name, 0, 1) }}</span>
            </div>
            <div>
                <h5 class="font-medium text-gray-900">{{ $quote->user->name }}</h5>
                <p class="text-sm text-gray-500">{{ $quote->created_at->format('M j, Y g:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @include('partials.quote-status-badge', ['quote' => $quote])
            
            @if(auth()->check() && (auth()->user()->hasRole('Admin') || auth()->id() === $quote->user_id))
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                        <div class="py-1">
                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50" onclick="return confirm('Are you sure you want to delete this quote?')">
                                    Delete Quote
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Quote Details -->
    <div class="mb-3">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-700">Quantity:</span>
                <span class="text-gray-900">{{ $quote->quantity }}</span>
            </div>
            @if($quote->requested_price)
                <div>
                    <span class="font-medium text-gray-700">Requested Price:</span>
                    <span class="text-gray-900">KES {{ number_format($quote->requested_price, 2) }}</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Quote Message -->
    <div class="mb-4">
        <p class="text-gray-700 text-sm">{{ $quote->message }}</p>
    </div>
    
    <!-- Seller Response -->
    @if($quote->seller_response)
        <div class="bg-gray-50 p-3 rounded-md mb-4">
            <div class="flex items-center space-x-2 mb-2">
                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-xs font-medium text-green-600">{{ substr($quote->product->user->name, 0, 1) }}</span>
                </div>
                <span class="text-sm font-medium text-gray-900">{{ $quote->product->user->name }}</span>
                <span class="text-xs text-gray-500">{{ $quote->responded_at->format('M j, Y g:i A') }}</span>
            </div>
            
            @if($quote->quoted_price)
                <div class="mb-2">
                    <span class="text-sm font-medium text-gray-700">Quoted Price:</span>
                    <span class="text-sm text-gray-900">KES {{ number_format($quote->quoted_price, 2) }}</span>
                </div>
            @endif
            
            <p class="text-sm text-gray-700">{{ $quote->seller_response }}</p>
        </div>
    @endif
    
    <!-- Actions -->
    <div class="flex items-center justify-between">
        <div class="flex space-x-2">
            <!-- Seller Actions -->
            @if(auth()->check() && auth()->id() === $quote->product->user_id)
                @if($quote->isPending())
                    <button 
                        onclick="showResponseForm({{ $quote->id }})"
                        class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Respond
                    </button>
                @endif
                @if($quote->isAccepted())
                    <form action="{{ route('quotes.fulfill', $quote) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700">
                            Mark as Fulfilled
                        </button>
                    </form>
                @endif
            @endif
            
            <!-- Buyer Actions -->
            @if(auth()->check() && auth()->id() === $quote->user_id && $quote->isReplied())
                <form action="{{ route('quotes.accept', $quote) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        Accept
                    </button>
                </form>
                <form action="{{ route('quotes.reject', $quote) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Reject
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    <!-- Response Form (Hidden by default) -->
    @if(auth()->check() && auth()->id() === $quote->product->user_id && $quote->isPending())
        <div id="response-form-{{ $quote->id }}" class="hidden mt-4 p-4 bg-gray-50 rounded-md">
            <h6 class="font-medium mb-3">Respond to Quote Request</h6>
            <form class="quote-response-form space-y-3" data-quote-id="{{ $quote->id }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quoted Price *</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">KES</span>
                        </div>
                        <input 
                            type="number" 
                            name="quoted_price" 
                            min="0" 
                            step="0.01"
                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 pr-3 sm:text-sm border-gray-300 rounded-md"
                            placeholder="0.00"
                            required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Your Response *</label>
                    <textarea 
                        name="seller_response" 
                        rows="3" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="Respond to the buyer's request..."
                        required></textarea>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button 
                        type="submit" 
                        class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Send Response
                    </button>
                    <button 
                        type="button" 
                        onclick="hideResponseForm({{ $quote->id }})"
                        class="text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

<script>
function showResponseForm(quoteId) {
    document.getElementById('response-form-' + quoteId).classList.remove('hidden');
}

function hideResponseForm(quoteId) {
    document.getElementById('response-form-' + quoteId).classList.add('hidden');
}

// Handle quote response form submission
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quote-response-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const quoteId = this.getAttribute('data-quote-id');
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            fetch(`/quotes/${quoteId}/respond`, {
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
                    // Hide the form
                    hideResponseForm(quoteId);
                    
                    // Show success message
                    showAlert('success', data.message);
                    
                    // Reload the page to show the updated quote
                    window.location.reload();
                } else {
                    showAlert('error', data.error || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'An error occurred while sending the response');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
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