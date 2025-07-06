// resources/views/quotes/show.blade.php
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Quote Details</span>
                    <span class="badge 
                        @if($quote->status === 'pending') bg-warning text-dark
                        @elseif($quote->status === 'accepted') bg-primary
                        @else bg-success @endif">
                        {{ ucfirst($quote->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="product-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $quote->product->image_url }}" alt="{{ $quote->product->name }}" 
                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5>{{ $quote->product->name }}</h5>
                                    <p class="text-muted mb-1">{{ $quote->product->category->name }}</p>
                                    <p class="text-muted mb-0">SKU: {{ $quote->product->sku }}</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="h5 mb-1">${{ number_format($quote->product->price, 2) }}</p>
                                <p class="text-muted">MOQ: {{ $quote->product->min_order_quantity }} units</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Request Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Company:</strong> {{ $quote->company_name }}</p>
                                <p><strong>Contact:</strong> {{ $quote->contact_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $quote->email }}</p>
                                <p><strong>Phone:</strong> {{ $quote->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Quantity:</strong> {{ $quote->quantity }} units</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Requested:</strong> {{ $quote->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @if($quote->message)
                            <div class="mt-3">
                                <strong>Additional Requirements:</strong>
                                <p class="text-muted">{{ $quote->message }}</p>
                            </div>
                        @endif
                    </div>

                    @if($quote->responses->isNotEmpty())
                        <div class="mb-4">
                            <h5>Seller Responses</h5>
                            @foreach($quote->responses as $response)
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Response from {{ $response->seller->name }}</span>
                                        <small class="text-muted">{{ $response->created_at->format('M d, Y H:i') }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>Offered Price:</strong>
                                            <span class="h5">${{ number_format($response->price, 2) }}</span>
                                        </div>
                                        <div>
                                            <strong>Message:</strong>
                                            <p>{{ $response->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-4">
                            No responses yet from the seller.
                        </div>
                    @endif

                    @can('respond', $quote)
                        <div class="mt-4">
                            <h5>Submit Response</h5>
                            <form method="POST" action="{{ route('quotes.responses.store', $quote) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" required>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" 
                                              name="message" rows="3" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Response</button>
                            </form>
                        </div>
                    @endcan

                    <div class="mt-4">
                        <a href="{{ route('quotes.index') }}" class="btn btn-outline-secondary">Back to Quotes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection