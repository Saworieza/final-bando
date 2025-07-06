<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsMedia extends Model
{
    protected $fillable = [
        'news_id',
        'file_path',
        'file_type',
        'original_name'
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}