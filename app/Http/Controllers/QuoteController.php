<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Product;
use App\Http\Requests\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Buyer')->only(['store']);
        $this->middleware('role:Seller|Admin')->only(['show', 'update', 'destroy']);
    }

    /**
     * Display a listing of quotes.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Quote::with(['product', 'buyer', 'seller'])
            ->orderBy('created_at', 'desc');

        // Filter based on user role
        if ($user->hasRole('Seller')) {
            $query->forSeller($user->id);
        } elseif ($user->hasRole('Buyer')) {
            $query->forBuyer($user->id);
        }
        // Admin can see all quotes, so no filter needed

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->withStatus($request->status);
        }

        $quotes = $query->paginate(15);

        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new quote.
     */
    public function create(Product $product)
    {
        // Check if user is authenticated and is a buyer
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please log in to request a quote.');
        }

        if (!Auth::user()->hasRole('Buyer')) {
            return redirect()->back()->with('error', 'Only buyers can request quotes.');
        }

        return view('quotes.create', compact('product'));
    }

    /**
     * Store a newly created quote in storage.
     */
    public function store(QuoteRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Prevent buyers from requesting quotes for their own products
        if ($product->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot request a quote for your own product.');
        }

        $quote = Quote::create([
            'product_id' => $product->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $product->user_id,
            'item_name' => $product->name,
            'message' => $request->message,
            'quantity' => $request->quantity ?? 1,
            'requested_price' => $request->requested_price,
        ]);

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote request sent successfully!');
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote)
    {
        $this->authorize('view', $quote);
        
        $quote->load(['product', 'buyer', 'seller']);
        
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        $this->authorize('update', $quote);
        
        return view('quotes.edit', compact('quote'));
    }

    /**
     * Update the specified quote in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $this->authorize('update', $quote);

        $request->validate([
            'quoted_price' => 'required|numeric|min:0',
            'seller_response' => 'required|string|max:1000',
        ]);

        $quote->markAsReplied($request->quoted_price, $request->seller_response);

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote response sent successfully!');
    }

    /**
     * Remove the specified quote from storage.
     */
    public function destroy(Quote $quote)
    {
        $this->authorize('delete', $quote);
        
        $quote->delete();

        return redirect()->route('quotes.index')
            ->with('success', 'Quote deleted successfully!');
    }

    /**
     * Accept a quote (buyer action).
     */
    public function accept(Quote $quote)
    {
        $this->authorize('accept', $quote);
        
        $quote->markAsAccepted();

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote accepted successfully!');
    }

    /**
     * Reject a quote (buyer action).
     */
    public function reject(Quote $quote)
    {
        $this->authorize('reject', $quote);
        
        $quote->markAsRejected();

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote rejected.');
    }

    /**
     * Mark a quote as fulfilled (seller action).
     */
    public function fulfill(Quote $quote)
    {
        $this->authorize('fulfill', $quote);
        
        $quote->markAsFulfilled();

        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote marked as fulfilled!');
    }

    /**
     * Quick create quote via AJAX (for product show page).
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|max:1000',
            'quantity' => 'nullable|integer|min:1',
            'requested_price' => 'nullable|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if ($product->user_id === Auth::id()) {
            return response()->json(['error' => 'You cannot request a quote for your own product.'], 403);
        }

        $quote = Quote::create([
            'product_id' => $product->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $product->user_id,
            'item_name' => $product->name,
            'message' => $request->message,
            'quantity' => $request->quantity ?? 1,
            'requested_price' => $request->requested_price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quote request sent successfully!',
            'quote_id' => $quote->id
        ]);
    }
}