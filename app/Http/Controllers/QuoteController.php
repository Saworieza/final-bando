<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Product;
use App\Http\Requests\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    /**
     * Display a listing of quotes.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $query = Quote::with(['product', 'user'])
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
     * Store a newly created quote in storage.
     */
    public function store(QuoteRequest $request)
    {
        if (!Auth::check() || !Auth::user()->hasRole('Buyer')) {
            return redirect()->back()->with('error', 'Only buyers can create quotes.');
        }

        $product = Product::findOrFail($request->product_id);
        
        // Prevent buyers from requesting quotes for their own products
        if ($product->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot request a quote for your own product.');
        }

        $quote = Quote::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'quantity' => $request->quantity ?? 1,
            'requested_price' => $request->requested_price,
            'status' => 'pending',
        ]);

        return redirect()->route('products.show', $product)
            ->with('success', 'Quote request sent successfully!');
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('view', $quote);
        
        $quote->load(['product', 'user']);
        
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('update', $quote);
        
        return view('quotes.edit', compact('quote'));
    }

    /**
     * Update the specified quote in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('update', $quote);

        // Handle seller response
        if ($request->has('quoted_price') && $request->has('seller_response')) {
            $request->validate([
                'quoted_price' => 'required|numeric|min:0',
                'seller_response' => 'required|string|max:1000',
            ]);

            $quote->markAsReplied($request->quoted_price, $request->seller_response);
            
            return redirect()->route('products.show', $quote->product)
                ->with('success', 'Quote response sent successfully!');
        }

        // Handle status updates
        $request->validate([
            'status' => 'in:pending,replied,accepted,rejected,fulfilled',
        ]);

        $quote->update($request->only('status'));

        return back()->with('success', 'Quote updated');
    }

    /**
     * Remove the specified quote from storage.
     */
    public function destroy(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('delete', $quote);
        
        $product = $quote->product;
        $quote->delete();

        return redirect()->route('products.show', $product)
            ->with('success', 'Quote deleted successfully!');
    }

    /**
     * Accept a quote (buyer action).
     */
    public function accept(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('accept', $quote);
        
        $quote->markAsAccepted();

        return redirect()->route('products.show', $quote->product)
            ->with('success', 'Quote accepted successfully!');
    }

    /**
     * Reject a quote (buyer action).
     */
    public function reject(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('reject', $quote);
        
        $quote->markAsRejected();

        return redirect()->route('products.show', $quote->product)
            ->with('success', 'Quote rejected.');
    }

    /**
     * Mark a quote as fulfilled (seller action).
     */
    public function fulfill(Quote $quote)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->authorize('fulfill', $quote);
        
        $quote->markAsFulfilled();

        return redirect()->route('products.show', $quote->product)
            ->with('success', 'Quote marked as fulfilled!');
    }

    /**
     * Quick create quote via AJAX (for product show page).
     */
    public function quickStore(Request $request)
    {
        if (!Auth::check() || !Auth::user()->hasRole('Buyer')) {
            return response()->json(['error' => 'Only buyers can create quotes.'], 403);
        }

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
            'user_id' => Auth::id(),
            'message' => $request->message,
            'quantity' => $request->quantity ?? 1,
            'requested_price' => $request->requested_price,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quote request sent successfully!',
            'quote_id' => $quote->id,
            'quote_html' => view('partials.quote-item', compact('quote'))->render()
        ]);
    }

    /**
     * Quick respond to quote via AJAX (for product show page).
     */
    public function quickRespond(Request $request, Quote $quote)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required.'], 401);
        }

        $this->authorize('update', $quote);

        $request->validate([
            'quoted_price' => 'required|numeric|min:0',
            'seller_response' => 'required|string|max:1000',
        ]);

        $quote->markAsReplied($request->quoted_price, $request->seller_response);

        return response()->json([
            'success' => true,
            'message' => 'Quote response sent successfully!',
            'quote_html' => view('partials.quote-item', compact('quote'))->render()
        ]);
    }
}