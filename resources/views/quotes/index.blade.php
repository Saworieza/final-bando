// resources/views/quotes/index.blade.php
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">My Quote Requests</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($quotes->isEmpty())
                <p class="text-muted">No quote requests found.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotes as $quote)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $quote->product) }}">
                                            {{ $quote->product->name }}
                                        </a>
                                    </td>
                                    <td>{{ $quote->quantity }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($quote->status === 'pending') bg-warning text-dark
                                            @elseif($quote->status === 'accepted') bg-primary
                                            @else bg-success @endif">
                                            {{ ucfirst($quote->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $quote->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('quotes.show', $quote) }}" class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                        @can('delete', $quote)
                                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection