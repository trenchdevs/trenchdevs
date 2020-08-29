<?php

namespace App\Models;

use App\Models\Blogs\BlogTag;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * @property $tags
 * @package App\Models
 */
class Blog extends Model
{
    protected $table = 'blogs';

    const DB_STATUS_DRAFT = 'draft';
    const DB_STATUS_published = 'published';

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'tagline',
        'markdown_contents',
        'status',
    ];

    public function tags(){
        $this->hasMany(BlogTag::class);
    }

}
