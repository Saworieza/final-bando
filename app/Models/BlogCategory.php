<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $table = 'blog_categories';

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}