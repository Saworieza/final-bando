<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id', // The buyer who requested the quote
        'message',
        'quantity',
        'requested_price',
        'quoted_price',
        'status',
        'seller_response',
        'responded_at',
    ];

    protected $casts = [
        'requested_price' => 'decimal:2',
        'quoted_price' => 'decimal:2',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the product that this quote is for.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user (buyer) who requested this quote.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the buyer who requested this quote (alias for user).
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the seller who owns the product (through product relationship).
     */
    public function seller()
    {
        return $this->hasOneThrough(User::class, Product::class, 'id', 'id', 'product_id', 'user_id');
    }

    /**
     * Scope a query to only include quotes for products owned by a specific seller.
     */
    public function scopeForSeller($query, $sellerId)
    {
        return $query->whereHas('product', function ($q) use ($sellerId) {
            $q->where('user_id', $sellerId);
        });
    }

    /**
     * Scope a query to only include quotes by a specific buyer.
     */
    public function scopeForBuyer($query, $buyerId)
    {
        return $query->where('user_id', $buyerId);
    }

    /**
     * Scope a query to only include quotes with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include quotes for a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Get the status badge color for display.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'replied' => 'bg-blue-100 text-blue-800',
            'accepted' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'fulfilled' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if the quote is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the quote has been replied to.
     */
    public function isReplied()
    {
        return $this->status === 'replied';
    }

    /**
     * Check if the quote has been accepted.
     */
    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the quote has been rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the quote has been fulfilled.
     */
    public function isFulfilled()
    {
        return $this->status === 'fulfilled';
    }

    /**
     * Mark the quote as replied.
     */
    public function markAsReplied($quotedPrice, $response)
    {
        $this->update([
            'status' => 'replied',
            'quoted_price' => $quotedPrice,
            'seller_response' => $response,
            'responded_at' => now(),
        ]);
    }

    /**
     * Mark the quote as accepted.
     */
    public function markAsAccepted()
    {
        $this->update(['status' => 'accepted']);
    }

    /**
     * Mark the quote as rejected.
     */
    public function markAsRejected()
    {
        $this->update(['status' => 'rejected']);
    }

    /**
     * Mark the quote as fulfilled.
     */
    public function markAsFulfilled()
    {
        $this->update(['status' => 'fulfilled']);
    }

    /**
     * Get the item name (product name).
     */
    public function getItemNameAttribute()
    {
        return $this->product->name;
    }
}