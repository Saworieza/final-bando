<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;

class StoreProductController extends Controller
{
    // Public product list
    
    public function index(Request $request)
    {
        $query = Product::with('category', 'user')->latest();

        // Filter by category slug if passed
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $products = $query->get();

        $currentCategory = $request->has('category') ? Category::where('slug', $request->category)->first() : null;

        // return view('products.index', compact('products'));
        return view('products.index', compact('products', 'currentCategory'));

        
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
            'images.*'    => 'nullable|image|max:2048', // multiple files
        ]);

        $data['user_id'] = Auth::id();

        $product = Product::create($data);

        // Save multiple images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

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
            'images.*'    => 'nullable|image|max:2048', // multiple files
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
