<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductForm extends Component
{
    use WithFileUploads;

    public $name, $sku, $price, $description, $category, $tags;
    public $min_order_qty = 1;
    public $status = 'active';
    public $image;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'min_order_qty' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:active,inactive,out_of_stock',
            'image' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function submit()
    {
        $validated = $this->validate();

        if ($this->image) {
            $validated['image_path'] = $this->image->store('products', 'public');
        }

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        session()->flash('status', 'Product created successfully.');

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.seller.product-form');
    }
}
