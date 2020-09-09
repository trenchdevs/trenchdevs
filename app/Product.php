<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

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
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'stock' => 'required|integer',
        'sku' => 'required|string|max:255',
        'msrp' => 'required|numeric',
        'product_category_id' => 'nullable|integer',
        'description' => 'nullable|string|max:255',
        'product_cost' => 'nullable|numeric',
        'shipping_cost' => 'nullable|numeric',
        'handling_cost' => 'nullable|numeric',
        'final_cost' => 'nullable|numeric',
        'markup_percentage' => 'nullable|numeric',
        'attributes' => 'nullable|json',
    ];
}
