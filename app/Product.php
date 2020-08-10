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
}
