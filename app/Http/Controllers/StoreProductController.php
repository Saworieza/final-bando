<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreProductController extends Controller
{
    // Public product list
    // public function index()
    // {
    //     $products = Product::with('category', 'user')->latest()->get();
    //     return view('products.index', compact('products'));
    // }
    public function index(Request $request)
    {
        $query = Product::with('category', 'user')->latest();

        // Filter by category slug if passed
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    // Public product details
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Seller/Admin product dashboard
    public function myProducts()
    {
        $user = Auth::user();
        $products = $user->hasRole('Admin')
            ? Product::with('category')->latest()->get()
            : $user->products()->with('category')->latest()->get();

        return view('products.my', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store product
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.my')->with('status', 'Product created!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $this->authorizeAccess($product);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $this->authorizeAccess($product);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.my')->with('status', 'Product updated!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $this->authorizeAccess($product);

        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('products.my')->with('status', 'Product deleted.');
    }

    // Helper to restrict access to owner or admin
    protected function authorizeAccess(Product $product)
    {
        if (Auth::user()->hasRole('Admin')) return;
        if ($product->user_id !== Auth::id()) abort(403);
    }
}
