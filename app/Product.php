<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
        'product_category_id',
        'name',
        'description',
        'stock',
        'image_url',
        'is_on_sale',
        'shipping_cost',
        'handling_cost',
        'product_cost',
        'sale_product_cost',
        'final_cost',
        'attributes',
    ];
}
