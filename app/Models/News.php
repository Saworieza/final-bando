<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'category_id',
        'is_published'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(NewsMedia::class);
    }

    public function images()
    {
        return $this->media()->where('file_type', 'image');
    }

    public function files()
    {
        return $this->media()->where('file_type', 'file');
    }

    // In your News model (app/Models/News.php)
    public function getRouteKeyName()
    {
        return 'slug';
    }
}