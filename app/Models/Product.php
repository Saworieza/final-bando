<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use HasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Correct

class Product extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'sku', 'category', 'tags',
        'price', 'min_order_qty', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

