<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product)
    {
        if ($product->isDirty('stock_qty')) {
            \App\Models\ProductStockLog::create([
                'product_id' => $product->id,
                'old_qty' => $product->getOriginal('stock_qty'),
                'new_qty' => $product->stock_qty,
                'reason' => 'manual adjust',
                'user_id' => auth()->id(),
            ]);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
