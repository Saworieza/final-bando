<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'item_name',
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
     * Get the buyer who requested this quote.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the seller who owns the product.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Scope a query to only include quotes for a specific seller.
     */
    public function scopeForSeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    /**
     * Scope a query to only include quotes by a specific buyer.
     */
    public function scopeForBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    /**
     * Scope a query to only include quotes with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
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
}