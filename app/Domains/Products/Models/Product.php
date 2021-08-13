<?php

namespace App\Domains\Products\Models;

use App\Domains\Stories\Models\Story;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App
 * @property $owner_user_id
 */
class Product extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'product_category_id',
        'name',
        'description',
        'stock',
        'sku',
        'image_url',
        'shipping_cost',
        'handling_cost',
        'product_cost',
        'msrp',
        'final_cost',
        'markup_percentage',
        'attributes',
        'owner_user_id',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'stock' => 'required|integer',
        'sku' => 'required|string|max:32',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        'msrp' => 'nullable|numeric',
        'product_category_id' => 'nullable|integer',
        'description' => 'nullable|string|max:255',
        'markup_percentage' => 'nullable|numeric',
        'product_cost' => 'required|nullable|numeric',
        'final_cost' => 'required|numeric',
        'shipping_cost' => 'nullable|numeric',
        'handling_cost' => 'nullable|numeric',
        'attributes' => 'nullable|json',
    ];

    public function products()
    {
        return $this->belongsToMany(Story::class, 'product_stories');
    }

    /**
     * @param Authenticatable $user
     * @return bool
     */
    public function hasAccess(Authenticatable $user): bool{
        return $this->owner_user_id === $user->id;
    }
}
