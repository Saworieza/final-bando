{{-- resources/views/quotes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            @if(auth()->user()->hasRole('Buyer'))
                My Quote Requests
            @elseif(auth()->user()->hasRole('Seller'))
                Quote Requests for My Products
            @else
                All Quotes
            @endif
        </h1>
        
        {{-- Status Filter --}}
        <div class="flex items-center space-x-2">
            <label for="status-filter" class="text-sm font-medium text-gray-700">Filter by Status:</label>
            <select id="status-filter" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="fulfilled" {{ request('status') === 'fulfilled' ? 'selected' : '' }}>Fulfilled</option>
            </select>
        </div>
    </div>

    @if($quotes->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No quotes found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(auth()->user()->hasRole('Buyer'))
                    You haven't requested any quotes yet.
                @else
                    No quote requests have been received.
                @endif
            </p>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($quotes as $quote)
                    <li>
                        <a href="{{ route('quotes.show', $quote) }}" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <p class="text-sm font-medium text-blue-600 truncate">
                                            {{ $quote->item_name }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0">
                                            @include('partials.quote-status-badge', ['quote' => $quote])
                                        </div>
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Qty: {{ $quote->quantity }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                            @if(auth()->user()->hasRole('Buyer'))
                                                From: {{ $quote->seller->name }}
                                            @else
                                                From: {{ $quote->buyer->name }}
                                            @endif
                                        </p>
                                        @if($quote->requested_price)
                                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Requested: ${{ number_format($quote->requested_price, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p>{{ $quote->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{ $quotes->links() }}
    @endif
</div>

@push('scripts')
<script>
    document.getElementById('status-filter').addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        window.location.href = url.toString();
    });
</script>
@endpush
@endsection