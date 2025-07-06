<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // Add this to your existing Category.php
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
