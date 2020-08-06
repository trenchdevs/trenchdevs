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
        'image_url',
        'is_on_sale',
        'shipping_cost',
        'handling_cost',
        'product_cost',
        'sale_product_cost',
        'final_cost',
        'attributes',
    ];

    public static function fillProductWithRequestValues(Product $product, Request $request)
    {
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->stock = $request->stock;

        $product->image_url = '';

        $product->is_on_sale = $request->is_on_sale;
        $product->shipping_cost = $request->shipping_cost;
        $product->handling_cost = $request->handling_cost;
        $product->product_cost = $request->product_cost;
        $product->sale_product_cost = $request->sale_product_cost;
        $product->final_cost = $request->final_cost;
        $product->attributes = $request->attributes;

        return $product;
    }
}
