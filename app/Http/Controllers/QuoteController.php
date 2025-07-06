<?php

// app/Http/Controllers/QuoteController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $quotes = Quote::with(['product', 'buyer'])->latest()->get();
        } elseif ($user->hasRole('seller')) {
            $quotes = Quote::whereHas('product', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['product', 'buyer'])->latest()->get();
        } else {
            $quotes = $user->quotes()->with(['product', 'responses.seller'])->latest()->get();
        }

        return view('quotes.index', compact('quotes'));
    }

    public function create(Product $product)
    {
        return view('quotes.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'quantity' => 'required|integer|min:' . $product->min_order_quantity,
            'message' => 'nullable|string',
        ]);

        $quote = $product->quotes()->create([
            'buyer_id' => Auth::id(),
            'company_name' => $validated['company_name'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'quantity' => $validated['quantity'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        // Notify seller here (you can implement notification system)

        return redirect()->route('quotes.show', $quote)->with('success', 'Quote request submitted successfully!');
    }

    public function show(Quote $quote)
    {
        $this->authorize('view', $quote);
        
        if (Auth::user()->hasRole('seller') && $quote->status === 'pending') {
            $quote->update(['status' => 'accepted']);
        }

        return view('quotes.show', compact('quote'));
    }

    public function destroy(Quote $quote)
    {
        $this->authorize('delete', $quote);
        
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully');
    }
}

// app/Http/Controllers/QuoteResponseController.php
namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteResponseController extends Controller
{
    public function store(Request $request, Quote $quote)
    {
        $this->authorize('respond', $quote);
        
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'message' => 'required|string',
        ]);

        $response = $quote->responses()->create([
            'seller_id' => Auth::id(),
            'price' => $validated['price'],
            'message' => $validated['message'],
        ]);

        // Notify buyer here

        return redirect()->route('quotes.show', $quote)->with('success', 'Response submitted successfully!');
    }
}