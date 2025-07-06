{{-- resources/views/quotes/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Quote Request</h1>
                        <p class="mt-1 text-sm text-gray-600">Quote ID: #{{ $quote->id }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        @include('partials.quote-status-badge', ['quote' => $quote])
                        
                        {{-- Actions Dropdown --}}
                        @if(auth()->user()->hasRole('Admin') || auth()->id() === $quote->seller_id)
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                                    <div class="py-1">
                                        @can('delete', $quote)
                                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50" onclick="return confirm('Are you sure you want to delete this quote?')">
                                                    Delete Quote
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Product Information --}}
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Product Information</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            @if($quote->product->image)
                                <img src="{{ asset('storage/' . $quote->product->image) }}" alt="{{ $quote->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                            @endif
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $quote->item_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $quote->product->category->name ?? 'Uncategorized' }}</p>
                                @if($quote->product->price)
                                    <p class="text-sm font-medium text-green-600">Listed Price: ${{ number_format($quote->product->price, 2) }}</p>
                                @endif
                                <a href="{{ route('products.show', $quote->product) }}" class="text-sm text-blue-600 hover:text-blue-800">View Product →</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quote Details --}}
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Quote Details</h2>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quote->quantity }}</dd>
                            </div>
                            @if($quote->requested_price)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Requested Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($quote->requested_price, 2) }}</dd>
                                </div>
                            @endif
                            @if($quote->quoted_price)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Quoted Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">${{ number_format($quote->quoted_price, 2) }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date Requested</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $quote->created_at->format('M j, Y g:i A') }}</dd>
                            </div>
                            @if($quote->responded_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date Responded</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $quote->responded_at->format('M j, Y g:i A') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Messages --}}
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Messages</h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        {{-- Buyer's Initial Message --}}
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">{{ substr($quote->buyer->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm">
                                    <span class="font-medium text-gray-900">{{ $quote->buyer->name }}</span>
                                    <span class="text-gray-500">{{ $quote->created_at->format('M j, Y g:i A') }}</span>
                                </div>
                                <div class="mt-1 text-sm text-gray-700">
                                    <p>{{ $quote->message }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Seller's Response --}}
                        @if($quote->seller_response)
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-green-600">{{ substr($quote->seller->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm">
                                        <span class="font-medium text-gray-900">{{ $quote->seller->name }}</span>
                                        <span class="text-gray-500">{{ $quote->responded_at->format('M j, Y g:i A') }}</span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>{{ $quote->seller_response }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Participants</h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        {{-- Buyer --}}
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">{{ substr($quote->buyer->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $quote->buyer->name }}</p>
                                <p class="text-sm text-gray-500">Buyer</p>
                            </div>
                        </div>

                        {{-- Seller --}}
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-green-600">{{ substr($quote->seller->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $quote->seller->name }}</p>
                                <p class="text-sm text-gray-500">Seller</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-6 bg-white shadow-sm rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Actions</h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        {{-- Seller Actions --}}
                        @if(auth()->id() === $quote->seller_id)
                            @if($quote->isPending())
                                <a href="{{ route('quotes.edit', $quote) }}" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Respond to Quote
                                </a>
                            @endif
                            @if($quote->isAccepted())
                                @can('fulfill', $quote)
                                    <form action="{{ route('quotes.fulfill', $quote) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            Mark as Fulfilled
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        @endif

                        {{-- Buyer Actions --}}
                        @if(auth()->id() === $quote->buyer_id && $quote->isReplied())
                            <div class="space-y-2">
                                @can('accept', $quote)
                                    <form action="{{ route('quotes.accept', $quote) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Accept Quote
                                        </button>
                                    </form>
                                @endcan
                                @can('reject', $quote)
                                    <form action="{{ route('quotes.reject', $quote) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Reject Quote
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection