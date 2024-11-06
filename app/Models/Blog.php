<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterTrait;
class Blog extends Model
{
    use HasFactory, FilterTrait;
    protected $table = 'blogs';

    protected $fillable = [
        'category_id', 'title', 'slug', 'thumbnail_url', 'meta_title',
        'meta_description', 'description', 'content', 'author_id', 'tags',
        'status', 'feature'
    ];
    /**
	 * set string fields for filtering
	 * @var array
	 */
	protected $likeFilterFields = ['title'];

    /**
     * set boolean fields for filtering
     * @var array
     */
    protected $boolFilterFields = ['status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // Mối quan hệ với User
    }

}
