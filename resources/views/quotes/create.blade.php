// resources/views/quotes/create.blade.php
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Request Quote</div>

                <div class="card-body">
                    <div class="product-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5>{{ $product->name }}</h5>
                                    <p class="text-muted mb-1">{{ $product->category->name }}</p>
                                    <p class="text-muted mb-0">SKU: {{ $product->sku }}</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="h5 mb-1">${{ number_format($product->price, 2) }}</p>
                                <p class="text-muted">MOQ: {{ $product->min_order_quantity }} units</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('quotes.store', $product) }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_name" class="form-label">Contact Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contact_name') is-invalid @enderror" 
                                       id="contact_name" name="contact_name" value="{{ old('contact_name') }}" required>
                                @error('contact_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" min="{{ $product->min_order_quantity }}" 
                                   value="{{ old('quantity', $product->min_order_quantity) }}" required>
                            <div class="form-text">Minimum order quantity: {{ $product->min_order_quantity }} units</div>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Additional Requirements</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" 
                                      name="message" rows="3">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="quote-summary p-3 mb-4 bg-light rounded">
                            <h5>Quote Summary</h5>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Product:</span>
                                <span>{{ $product->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Quantity:</span>
                                <span id="displayQuantity">{{ $product->min_order_quantity }} units</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Estimated Total:</span>
                                <span id="displayTotal">${{ number_format($product->price * $product->min_order_quantity, 2) }}</span>
                            </div>
                            <div class="form-text mt-2">* Final pricing may vary based on quantity, shipping, and current market conditions</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Submit Quote Request</button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const displayQuantity = document.getElementById('displayQuantity');
        const displayTotal = document.getElementById('displayTotal');
        const unitPrice = {{ $product->price }};
        
        quantityInput.addEventListener('input', function() {
            const qty = parseInt(this.value) || {{ $product->min_order_quantity }};
            const total = qty * unitPrice;
            displayQuantity.textContent = qty + ' units';
            displayTotal.textContent = '$' + total.toFixed(2);
        });
    });
</script>
@endsection