<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgePost extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'user_id'];

    public function categories()
    {
        return $this->belongsToMany(KnowledgeCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
