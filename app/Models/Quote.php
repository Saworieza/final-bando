<?php
// app/Models/Quote.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'company_name',
        'contact_name',
        'email',
        'phone',
        'quantity',
        'message',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function responses()
    {
        return $this->hasMany(QuoteResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }     
}

