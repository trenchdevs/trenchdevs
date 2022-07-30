<?php

namespace App\Modules\Stories\Models;

use App\Modules\Products\Models\Product;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Story
 * @package App\Models\Stories
 * @property $id
 * @property $slug
 * @property $owner_user_id
 * @property $is_active
 */
class Story extends Model
{
    use HasFactory;

    protected $table = 'stories';

    protected $fillable = [
        'owner_user_id',
        'title',
        'slug',
        'is_active',
        'description'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_stories');
    }

    public function hasAccess(Authenticatable $user)
    {
        return $this->owner_user_id === $user->id;
    }

}
