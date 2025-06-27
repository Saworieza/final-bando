<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KnowledgeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The posts that belong to this knowledge category.
     */
    public function posts()
    {
        return $this->belongsToMany(KnowledgePost::class);
    }
}
