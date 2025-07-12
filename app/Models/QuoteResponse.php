<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteResponse extends Model
{
    use HasFactory; // This is crucial
    
    protected $fillable = [
        'quote_id',
        'seller_id',
        'price',
        'message',
        'estimated_delivery'
    ];
    
    // Relationships
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}