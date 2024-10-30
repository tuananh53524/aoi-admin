<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'thumbnail_url', 'meta_title',
        'meta_description', 'description', 'content', 'author', 'tags',
        'status', 'feature'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // Mối quan hệ với User
    }
}
